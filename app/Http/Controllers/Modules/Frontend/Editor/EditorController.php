<?php

namespace App\Http\Controllers\Modules\Frontend\Editor;

use Illuminate\Http\Request;
use App\Facades\LaravelTheme;
use App\Facades\EditorGrapesJs;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\PagesRepositori;
use App\Repositories\ProjectRepositori;
use Exception;

class EditorController extends Controller
{
    protected $theme;
    protected $editor;
    protected $projectRepositori;
    protected $pagesRepositori;

    public function __construct(
        LaravelTheme $theme, EditorGrapesJs $editor, ProjectRepositori $projectRepositori, PagesRepositori $pagesRepositori
    ) {
        $this->theme = $theme;
        $this->editor = $editor;
        $this->projectRepositori = $projectRepositori;
        $this->pagesRepositori = $pagesRepositori;
    }

    public function getBlocks($id_theme) {
       return EditorGrapesJs::select($id_theme)->getBlocks();
    }

    public function getPages($id_project) {
        return EditorGrapesJs::getPages($id_project);
    }

    public function storePage(Request $request, $id_project) {
        DB::beginTransaction();
        try {

            $project = $this->projectRepositori->find($id_project);
            $theme = $this->theme::findTheme($project->id_theme);
            $viewTheme = view('themes/'.$theme['name'].'/'.'index', compact('theme'))->render();
          
            $page = $this->pagesRepositori->create([
                'uuid_project' => $id_project,
                'title' => $request->title,
                'style' => (isset($request->style) ? $request->style : ''),
                'content' => (isset($request->content) ? $request->content : $viewTheme)
            ]);

            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Ok',
                'detail' => $page
            ]);

        }catch(\Exception $err) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $err->getMessage(),
                'detail' => null
            ]);
        }
    }

    public function destroyPage(Request $request, $id_project) {
        try {

            $page = $this->pagesRepositori->delete($request->id);

            if($page) {
                return response()->json([
                    'status' => true,
                    'message' => 'Page berhasil dihapus.',
                    'detail' => true
                ]);
            }

            throw new Exception('Gagal menghapus page, mohong ulangi transaksi.');
        }catch(\Exception $err) {
            return response()->json([
                'status' => false,
                'message' => $err->getMessage(),
                'detail' => null
            ]);
        }
    }

    public function updateNamePage(Request $request) {
        try {

            $page = $this->pagesRepositori->update($request->id, [
                'title' => $request->title
            ]);

            if($page) {
                return response()->json([
                    'status' => true,
                    'message' => 'Nama page berhasil diupdate.',
                    'detail' => true
                ]);
            }

            throw new Exception('Gagal update nama page, mohong ulangi transaksi.');
        }catch(\Exception $err) {
            return response()->json([
                'status' => false,
                'message' => $err->getMessage(),
                'detail' => null
            ]);
        }
    }

    public function saveProjects(Request $request, $id_project) {
        try {

            foreach($request->pages as $page) {
                $update = $this->pagesRepositori->find($page['id']);
                if($update) {
                    $update->update([
                        'content' => $page['content'],
                        'style' => $this->removeDuplicateCss($page['style'])
                    ]);
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Berhasil menyimpan project.',
                'detail' => null
            ]);

        }catch(\Exception $err) {
            return response()->json([
                'status' => false,
                'message' => $err->getMessage(),
                'detail' => null
            ]);
        }
    }

    public function normalizeCss($css) {
        $css = preg_replace('/\s+/', ' ', $css);
        $css = preg_replace('/\s*{\s*/', '{', $css);
        $css = preg_replace('/;\s*/', ';', $css);
        $css = preg_replace('/}\s*/', '}', $css);
        $css = preg_replace('/\s*:\s*/', ':', $css);
        return $css;
    }
    
    public function removeDuplicateCss($css) {
        // Match all CSS rules
        preg_match_all('/[^{]+\{[^}]*\}/', $css, $matches);
    
        $uniqueRules = [];
        foreach ($matches[0] as $rule) {
            // Normalize the rule for comparison
            $normalizedRule = $this->normalizeCss($rule);
    
            // Extract selector and properties
            if (preg_match('/([^{}]+)\{([^}]*)\}/', $normalizedRule, $match)) {
                $selector = trim($match[1]);
                $properties = trim($match[2]);
    
                // Use the selector as a key and properties as value in associative array
                if (!isset($uniqueRules[$selector])) {
                    $uniqueRules[$selector] = [];
                }
    
                // Add properties to the list for this selector
                $uniqueRules[$selector][] = $properties;
            }
        }
    
        // Merge properties for each selector and remove duplicates
        $finalRules = [];
        foreach ($uniqueRules as $selector => $propertiesList) {
            $mergedProperties = implode(';', array_unique($propertiesList));
            $mergedProperties = trim($mergedProperties, ';');
            $finalRules[] = "$selector{{$mergedProperties}}";
        }
    
        return implode("\n", $finalRules);
    }
}

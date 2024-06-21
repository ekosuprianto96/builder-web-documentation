<?php

namespace App\Http\Controllers\Modules\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    protected $path = 'modules.admin.dashboard';

    public function index() {
        return view($this->path.'.index');
    }

    public function getThumbnail($theme, $filename)
    {
        // Tentukan path lengkap dari gambar
        $path = resource_path("views/themes/{$theme}/assets/images/{$filename}");

        // Cek apakah file tersebut ada
        if (!File::exists($path)) {
            abort(404, 'Image not found');
        }

        // Dapatkan konten dari file
        $file = File::get($path);

        // Dapatkan tipe mime dari file
        $type = File::mimeType($path);

        // Kembalikan response dengan konten file dan tipe mime
        return Response::make($file, 200)->header("Content-Type", $type);
    }
}

<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Http\Request;
use App\Services\LaravelTheme;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DevelController extends Controller
{
    public function index() {
        $fileSystem = new Filesystem();
        $theme = (new LaravelTheme())->getThemes();
        $code = view('themes/TH001/index')->render();
        $basename = 'sample.zip';
        $zip = new ZipArchive;
        $pathTheme = public_path('themes/').'ekotest';
        
        if(!$fileSystem->exists($pathTheme)) {
            $fileSystem->makeDirectory($pathTheme);
            $fileSystem->makeDirectory($pathTheme.'/assets');
            File::put($pathTheme.'/index.html', $code);
            File::put($pathTheme.'/assets/index.css', '');
        }

        if ($zip->open($basename, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            
            $this->addFolderToZip($pathTheme, $zip);

            $zip->close();
            
            $destinationPath = public_path('results/ekotest');
            if (!$fileSystem->exists($destinationPath)) {
                $fileSystem->makeDirectory($destinationPath, 0755, true);
            }

            $sourcePath = public_path($basename);
            $destinationFilePath = $destinationPath . '/' . $basename;
            File::move($sourcePath, $destinationFilePath);

            // $this->compileTailwindCSS();
        } else {
            dd('gagal');
        }
    }

    public function addFolderToZip($dir, $zipArchive, $zipdir = '') {
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                // Add the directory itself in the zip
                if(!empty($zipdir)) {
                    $zipArchive->addEmptyDir($zipdir);
                }
                // Read through the directory
                while (($file = readdir($dh)) !== false) {
                    if ($file !== "." && $file !== "..") {
                        if (is_dir($dir . '/' . $file)) {
                            // If it's a directory, recursively add it
                            $this->addFolderToZip($dir . '/' . $file, $zipArchive, $zipdir . $file . '/');
                        } else if (is_file($dir . '/' . $file)) {
                            // Add the file
                            $zipArchive->addFile($dir . '/' . $file, $zipdir . $file);
                        }
                    }
                }
                closedir($dh);
            }
        }
    }

    private function compileTailwindCSS($buildPath = null)
    {
        $process = new Process(['npm', 'run', 'build']);
        $process->setWorkingDirectory(base_path()); // Pastikan proses berjalan di direktori proyek Laravel
        $process->run();

        // Cek jika proses gagal
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}

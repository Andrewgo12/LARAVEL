<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Mpreventivos;
use ZipArchive;

/**
 * Zip Controller - Migrated from CodeIgniter to Laravel 11
 * Handles ZIP file creation and download functionality
 * Manages compression of preventive maintenance files and other documents
 */
class ZipController extends Controller
{
    protected $mpreventivos;

    public function __construct()
    {
        $this->mpreventivos = new Mpreventivos();
    }

    /**
     * Create ZIP archive and prepare for download
     */
    private function createAndDownloadZip($filename, $files = [])
    {
        $zipPath = public_path('assets/zips/' . $filename);

        // Ensure the zips directory exists
        if (!File::exists(public_path('assets/zips'))) {
            File::makeDirectory(public_path('assets/zips'), 0755, true);
        }

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Add files to zip
            foreach ($files as $file) {
                if (isset($file['data'])) {
                    // Add data directly to zip
                    $zip->addFromString($file['name'], $file['data']);
                } elseif (isset($file['path'])) {
                    // Add file from path
                    if (File::exists($file['path'])) {
                        $zip->addFile($file['path'], $file['name']);
                    }
                }
            }

            $zip->close();

            // Download the zip file
            return Response::download($zipPath, $filename)->deleteFileAfterSend(true);
        } else {
            abort(500, 'No se pudo crear el archivo ZIP');
        }
    }

    /**
     * Create ZIP with simple data files
     */
    public function data()
    {
        $files = [
            [
                'name' => 'name.txt',
                'data' => 'Sajal Soni'
            ],
            [
                'name' => 'profile.txt',
                'data' => 'Web Developer'
            ]
        ];

        return $this->createAndDownloadZip('my_info.zip', $files);
    }

    /**
     * Create ZIP with data from array
     */
    public function dataArray()
    {
        $filesData = [
            'name.txt' => 'Sajal Soni',
            'profile.txt' => 'Web Developer'
        ];

        $files = [];
        foreach ($filesData as $filename => $content) {
            $files[] = [
                'name' => $filename,
                'data' => $content
            ];
        }

        return $this->createAndDownloadZip('my_info.zip', $files);
    }

    /**
     * Create ZIP with subdirectories
     */
    public function dataWithSubdirs()
    {
        $files = [
            [
                'name' => 'info/name.txt',
                'data' => 'Sajal Soni'
            ],
            [
                'name' => 'info/profile.txt',
                'data' => 'Web Developer'
            ]
        ];

        return $this->createAndDownloadZip('my_info.zip', $files);
    }

    /**
     * Create ZIP with files from preventive maintenance
     * Migrated from CodeIgniter POST handling to Laravel Request
     */
    public function files(Request $request)
    {
        if ($request->isMethod('post') && $request->has('data')) {
            try {
                $vector = $this->mpreventivos->DecodificarParaZip($request->all());

                $files = [];
                foreach ($vector as $registro) {
                    $filePath = public_path('assets/upload_preventivos/' . $registro->codificado);
                    if (File::exists($filePath)) {
                        $files[] = [
                            'path' => $filePath,
                            'name' => $registro->nuevo . ".pdf"
                        ];
                    }
                }

                if (!empty($files)) {
                    return $this->createAndDownloadZip('archivos.zip', $files);
                } else {
                    return response()->json(['error' => 'No se encontraron archivos para comprimir'], 404);
                }

            } catch (\Exception $e) {
                return response()->json(['error' => 'Error al procesar archivos: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['error' => 'Datos no válidos'], 400);
    }

    /**
     * Create ZIP with all files from a directory
     */
    public function dir()
    {
        $directoryPath = public_path('assets/zips/images/');

        if (!File::exists($directoryPath)) {
            return response()->json(['error' => 'Directorio no encontrado'], 404);
        }

        try {
            $files = [];
            $allFiles = File::allFiles($directoryPath);

            foreach ($allFiles as $file) {
                $files[] = [
                    'path' => $file->getPathname(),
                    'name' => $file->getFilename()
                ];
            }

            if (!empty($files)) {
                return $this->createAndDownloadZip('dir_images.zip', $files);
            } else {
                return response()->json(['error' => 'No se encontraron archivos en el directorio'], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al procesar directorio: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Create ZIP with specific files by their paths
     */
    public function createZipFromPaths(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'string',
            'filename' => 'required|string'
        ]);

        try {
            $files = [];
            foreach ($request->input('files') as $filePath) {
                $fullPath = public_path($filePath);
                if (File::exists($fullPath)) {
                    $files[] = [
                        'path' => $fullPath,
                        'name' => basename($filePath)
                    ];
                }
            }

            if (!empty($files)) {
                return $this->createAndDownloadZip($request->input('filename'), $files);
            } else {
                return response()->json(['error' => 'No se encontraron archivos válidos'], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear ZIP: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get ZIP file information
     */
    public function getZipInfo($filename)
    {
        $zipPath = public_path('assets/zips/' . $filename);

        if (!File::exists($zipPath)) {
            return response()->json(['error' => 'Archivo ZIP no encontrado'], 404);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipPath) === TRUE) {
            $info = [
                'filename' => $filename,
                'num_files' => $zip->numFiles,
                'size' => File::size($zipPath),
                'files' => []
            ];

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $info['files'][] = $zip->getNameIndex($i);
            }

            $zip->close();
            return response()->json($info);
        } else {
            return response()->json(['error' => 'No se pudo abrir el archivo ZIP'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use App\Models\Mupload;
use Intervention\Image\Facades\Image;

/**
 * Upload Controller - Migrated from CodeIgniter to Laravel 11
 * Handles file uploads for images and documents with thumbnail creation
 */
class UploadController extends Controller
{
    protected $mupload;

    public function __construct()
    {
        $this->mupload = new Mupload();
    }

    /**
     * Display the upload form
     */
    public function index()
    {
        $data = [
            'error' => '',
            'errorArch' => '',
            'estado' => '',
            'archivo' => ''
        ];

        return view('vupload', $data);
    }

    /**
     * Handle image upload with thumbnail creation
     */
    public function subirImagen(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'titImagen' => 'required|string|max:255',
            'fileImagen' => 'required|image|mimes:gif,jpg,jpeg,png|max:2048|dimensions:max_width=2024,max_height=2008'
        ]);

        if ($validator->fails()) {
            $data = [
                'error' => implode('<br>', $validator->errors()->all()),
                'errorArch' => '',
                'estado' => '',
                'archivo' => ''
            ];
            return view('vupload', $data);
        }

        try {
            $file = $request->file('fileImagen');
            $titulo = $request->input('titImagen');

            // Generate unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Ensure imagenes directory exists
            if (!file_exists(public_path('style/imagenes'))) {
                mkdir(public_path('style/imagenes'), 0755, true);
            }

            // Store the image in public/style/imagenes
            $file->move(public_path('style/imagenes'), $filename);

            // Create thumbnail
            $this->crearMiniatura($filename);

            // Save to database using existing model method
            $this->mupload->save_upload($filename, 'imagen');

            $data = [
                'titulo' => $titulo,
                'imagen' => $filename
            ];

            return view('vImagenSubida', $data);

        } catch (\Exception $e) {
            $data = [
                'error' => 'Error al subir la imagen: ' . $e->getMessage(),
                'errorArch' => '',
                'estado' => '',
                'archivo' => ''
            ];
            return view('vupload', $data);
        }
    }

    /**
     * Create thumbnail for uploaded image
     */
    private function crearMiniatura($filename)
    {
        try {
            $sourcePath = public_path('style/imagenes/' . $filename);
            $thumbPath = public_path('style/thumbs/' . $filename);

            // Ensure thumbs directory exists
            if (!file_exists(public_path('style/thumbs'))) {
                mkdir(public_path('style/thumbs'), 0755, true);
            }

            // Create thumbnail using Intervention Image or GD
            if (class_exists('Intervention\Image\Facades\Image')) {
                // Use Intervention Image if available
                $image = Image::make($sourcePath);
                $image->resize(150, 150, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->save($thumbPath);
            } else {
                // Fallback to GD library
                $this->createThumbnailWithGD($sourcePath, $thumbPath, 150, 150);
            }

        } catch (\Exception $e) {
            // Log error but don't fail the upload
            \Log::error('Error creating thumbnail: ' . $e->getMessage());
        }
    }

    /**
     * Create thumbnail using GD library as fallback
     */
    private function createThumbnailWithGD($sourcePath, $thumbPath, $width, $height)
    {
        $imageInfo = getimagesize($sourcePath);
        $mime = $imageInfo['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $source = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $source = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $source = imagecreatefromgif($sourcePath);
                break;
            default:
                return false;
        }

        $sourceWidth = imagesx($source);
        $sourceHeight = imagesy($source);

        // Calculate aspect ratio
        $ratio = min($width / $sourceWidth, $height / $sourceHeight);
        $newWidth = $sourceWidth * $ratio;
        $newHeight = $sourceHeight * $ratio;

        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);

        // Save thumbnail
        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($thumb, $thumbPath, 90);
                break;
            case 'image/png':
                imagepng($thumb, $thumbPath);
                break;
            case 'image/gif':
                imagegif($thumb, $thumbPath);
                break;
        }

        imagedestroy($source);
        imagedestroy($thumb);
    }

    /**
     * Handle document file upload
     */
    public function subirArchivo(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'titImagen' => 'required|string|max:255',
            'fileImagen' => 'required|file|mimes:pdf,xlsx,docx|max:20048'
        ]);

        if ($validator->fails()) {
            $data = [
                'error' => '',
                'errorArch' => implode('<br>', $validator->errors()->all()),
                'estado' => '',
                'archivo' => ''
            ];
            return view('vupload', $data);
        }

        try {
            $file = $request->file('fileImagen');
            $titulo = $request->input('titImagen');

            // Generate unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Ensure archivos directory exists
            if (!file_exists(public_path('style/archivos'))) {
                mkdir(public_path('style/archivos'), 0755, true);
            }

            // Store the file in public/style/archivos
            $file->move(public_path('style/archivos'), $filename);

            // Save to database using existing model method
            $this->mupload->save_upload($filename, 'archivo');

            $data = [
                'error' => '',
                'errorArch' => '',
                'estado' => 'Archivo subido.',
                'archivo' => $filename
            ];

            return view('vupload', $data);

        } catch (\Exception $e) {
            $data = [
                'error' => '',
                'errorArch' => 'Error al subir el archivo: ' . $e->getMessage(),
                'estado' => '',
                'archivo' => ''
            ];
            return view('vupload', $data);
        }
    }

    /**
     * Handle file downloads
     */
    public function downloads($name)
    {
        $filePath = public_path('style/archivos/' . $name);

        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        // Security check - ensure filename doesn't contain path traversal
        if (strpos($name, '..') !== false || strpos($name, '/') !== false || strpos($name, '\\') !== false) {
            abort(403, 'Invalid file name');
        }

        // Return file download response
        return Response::download($filePath, $name);
    }
}
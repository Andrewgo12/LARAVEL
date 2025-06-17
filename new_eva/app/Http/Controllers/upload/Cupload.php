<?php


/**
 * Controlador Cupload - Sistema HUV
 * Gestiona las funcionalidades del módulo correspondiente
 */
class Cupload extends Controller
{
    /**
     * Permisos del controlador
     */
    protected $permisos = [];

    /**
     * Constructor del controlador
     */
    public function __construct()
    {
        $this->permisos = Session::get('permisos', []);
    }

    /**
namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mupload;

/* Sistema HUV */
    public function index()
    {
        if (!Session::get('login')) {
            return redirect()->route('huv.login');
        }

        $data = [
            'permisos' => $this->permisos,
            'acciones' => Session::get('acciones', [])
        ];

        return view('laravel.upload.list', $data);
    }

    /* Sistema HUV */
    public function uploadFile(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mupload::uploadFile($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en uploadFile: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function uploadImage(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mupload::uploadImage($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en uploadImage: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function uploadDocument(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mupload::uploadDocument($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en uploadDocument: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function deleteFile(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mupload::deleteFile($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en deleteFile: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getFiles(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mupload::getFiles($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getFiles: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function downloadFile(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mupload::downloadFile($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en downloadFile: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function getByType(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mupload::getByType($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en getByType: ' . $e->getMessage()], 500);
        }
    }

    /* Sistema HUV */
    public function validateFile(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $result = Mupload::validateFile($data);

            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en validateFile: ' . $e->getMessage()], 500);
        }
    }

}

}

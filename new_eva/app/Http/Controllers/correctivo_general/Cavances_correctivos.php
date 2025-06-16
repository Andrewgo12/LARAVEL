<?php

namespace App\Http\Controllers\correctivo_general;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mavances_correctivos;
use App\Models\Mcorrectivos_generales;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class Cavances_correctivos extends Controller
{
    private $Mavances_correctivos;
    private $Mcorrectivos_generales;
    
    public function __construct()
    {
        $this->Mavances_correctivos = new Mavances_correctivos();
        $this->Mcorrectivos_generales = new Mcorrectivos_generales();
    }
    
    public function get()
    {
        // Implementar según necesidad
    }
    
    public function getAll()
    {
        // Implementar según necesidad
    }
    
    public function getOne()
    {
        // Implementar según necesidad
    }
    
    public function GetByDevice(Request $request): JsonResponse
    {
        return response()->json($this->Mavances_correctivos->GetByDevice($request->all()));
    }
    
    public function GetByOrden(Request $request): JsonResponse
    {
        return response()->json($this->Mavances_correctivos->GetByOrden($request->all()));
    }
    
    public function add(Request $request): JsonResponse
    {
        $data = $request->all();
        $data["usuario_id"] = Session::get("id");
        unset($data["origen"]);
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/upload_correctivos_generales'), $fileName);
            $data["file"] = $fileName;
        }
        
        if ($this->Mavances_correctivos->add($data)) {
            return response()->json(1);
        } else {
            if (isset($data["file"])) {
                File::delete(public_path('assets/upload_correctivos_generales/' . $data["file"]));
            }
            return response()->json(0);
        }
    }
    
    public function update()
    {
        // Implementar según necesidad
    }
    
    public function delete(Request $request)
    {
        $this->Mavances_correctivos->delete($request->all());
    }
    
    public function show(): View
    {
        $vector = [
            'correctivos' => $this->Mcorrectivos_generales->getCorrectivosModal()
        ];
        
        return view("correctivos_generales.detail", $vector);
    }
}

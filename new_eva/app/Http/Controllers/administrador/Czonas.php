<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mzonas;
use App\Models\Musuarios;
use Illuminate\Http\JsonResponse;

class Czonas extends Controller
{
  private $permisos;
  private Mzonas $Mzonas;
  private Musuarios $Musuarios;
  
  public function __construct()
  {
    $this->Mzonas = new Mzonas();
    $this->Musuarios = new Musuarios();
  }
  
  public function index()
  {
  }

  public function ServiceGetAll(): JsonResponse
  {
    return response()->json($this->Mzonas->getAllZones());
  }
  
  public function getAll(): JsonResponse
  {
    return response()->json($this->Mzonas->getAll());
  }

  public function getOne(Request $request): JsonResponse
  {
    return response()->json($this->Musuarios->getOne($request->input('id')));
  }
}


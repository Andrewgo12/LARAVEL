<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mempresas;
use Illuminate\Http\JsonResponse;

class Cempresas extends Controller
{
  private $permisos;
  private Mempresas $Mempresas;
  
  public function __construct()
  {
    $this->Mempresas = new Mempresas();
    //$this->permisos = app('backend_lib')->control();
  }
  
  public function index()
  {
  }

  public function add()
  {
  }
  
  public function update()
  {
  }
  
  public function delete()
  {
  }

  public function getAll(): JsonResponse
  {
    return response()->json($this->Mempresas->getAll());
  }

  public function getOne()
  {
  }
}


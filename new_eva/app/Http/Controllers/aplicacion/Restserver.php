<?php

namespace App\Http\Controllers\aplicacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mequipos;
use Illuminate\Http\JsonResponse;

class Restserver extends Controller
{
  private Mequipos $Mequipos;
  
  public function __construct()
  {
    $this->Mequipos = new Mequipos();
  }

  public function test(): JsonResponse
  {
    $array = $this->Mequipos->get_some();
    //header("Access-Control-Origin: http://localhost:8100");
    //header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    return response()->json($array);
  }
  
  public function user(Request $request): JsonResponse
  {
    $data = "algo";
    return response()->json($data);
  }
  
  public function indext(): JsonResponse
  {
    $data = "algo";
    return response()->json($data, 200);
  }
}


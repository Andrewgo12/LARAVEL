<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Musuarios;
use App\Models\Musuarios_zonas;
use App\Models\Mcentros;
use App\Models\Macciones;
use App\Models\Mmodulos;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;

class Cusuarios extends Controller
{
  private Musuarios $Musuarios;
  private Musuarios_zonas $Musuarios_zonas;
  private Mcentros $Mcentros;
  private Macciones $Macciones;
  private Mmodulos $Mmodulos;
  
  public function __construct()
  {
    $this->Musuarios = new Musuarios();
    $this->Musuarios_zonas = new Musuarios_zonas();
    $this->Mcentros = new Mcentros();
    $this->Macciones = new Macciones();
    $this->Mmodulos = new Mmodulos();
  }
  
  public function index()
  {
    if (!Session::has('login')) {
      return redirect('Cauth');
    }
    
    Session::put('controlador', request()->segment(2));
    
    return view('usuarios.list', [
      'modulos' => $this->Mmodulos->getWithAccount()
    ]);
  }
  
  public function ServiceGetAll(): JsonResponse
  {
    return response()->json($this->Musuarios->getAllUsers());
  }
  
  public function ServiceGetOne($id): JsonResponse
  {
    return response()->json($this->Musuarios->getOneUser($id));
  }

  public function getAll(): JsonResponse
  {
    return response()->json($this->Musuarios->getAll());
  }
  
  public function get_server_side(Request $request): JsonResponse
  {
    $vector = $this->Musuarios->get_server_side($request->all());
    $respuesta = [
      'draw' => intval($request->input('draw')),
      'recordsTotal' => $vector['num_filas_limit'],
      'recordsFiltered' => $vector['num_filas'],
      'data' => $vector['datos']
    ];
    
    return response()->json($respuesta);
  }
  
  public function getRoles(): JsonResponse
  {
    return response()->json($this->Musuarios->getRoles());
  }
  
  public function add(Request $request): JsonResponse
  {
    $validator = Validator::make($request->all(), [
      'username' => 'required|unique:usuarios,username',
      'email' => 'required|unique:usuarios,email|email',
      'password' => 'required|min:4',
    ]);
    
    if (!$validator->fails()) {
      $data = $request->all();
      $data['password'] = sha1(md5($data['password']));
      $this->Musuarios->add($data);
      return response()->json(1);
    } else {
      $error = [
        'username' => $validator->errors()->first('username'),
        'email' => $validator->errors()->first('email'),
        'password' => $validator->errors()->first('password'),
      ];
      return response()->json($error);
    }
  }
  
  public function update(Request $request): JsonResponse
  {
    $usuarioActual = $this->Musuarios->getOne($request->input('id'));
    
    $rules = [
      'username' => [
        'required',
        Rule::unique('usuarios')->ignore($request->input('id'))
      ],
      'email' => [
        'required',
        'email',
        Rule::unique('usuarios')->ignore($request->input('id'))
      ]
    ];
    
    if ($request->input('password') != '') {
      $rules['password'] = 'min:4';
    }
    
    $validator = Validator::make($request->all(), $rules);
    
    if (!$validator->fails()) {
      $data = $request->all();
      
      if ($request->input('password') != '') {
        $data['password'] = sha1(md5($data['password']));
      } else {
        unset($data['password']);
      }
      
      $this->Musuarios->update($data);
      return response()->json(1);
    } else {
      $error = [
        'username' => $validator->errors()->first('username'),
        'email' => $validator->errors()->first('email')
      ];
      
      if ($request->input('password') != '') {
        $error['password'] = $validator->errors()->first('password');
      }
      
      return response()->json($error);
    }
  }
  
  public function delete(Request $request)
  {
    $array = ['estado' => 0];
    $this->Musuarios->delete($request->all(), $array);
    
    return response()->json(['success' => true]);
  }
  
  public function show(Request $request)
  {
    $result = $this->Musuarios->getOne($request->input('id'));
    $param = [
      'usuario' => $result
    ];
    
    return view('usuarios.detail', $param);
  }
  
  public function getOne(Request $request): JsonResponse
  {
    return response()->json($this->Musuarios->getOne($request->input('id')));
  }
  
  public function getOneWithActions(Request $request): JsonResponse
  {
    $usuario = $this->Musuarios->getOne($request->input('id'));
    $acciones = $this->Macciones->getByUser($request->input('id'));
    $vector = [
      'usuario' => $usuario,
      'acciones' => $acciones
    ];
    
    return response()->json($vector);
  }
  
  public function getCentros(): JsonResponse
  {
    return response()->json($this->Mcentros->get());
  }
  
  public function CambiarSede(Request $request): JsonResponse
  {
    $usuario = $this->Musuarios->getOne($request->input('id'));
    
    if ($usuario->sede_id == 1) {
      $param = [
        'id' => $request->input('id'),
        'caso' => 1
      ];
    } else {
      $param = [
        'id' => $request->input('id'),
        'caso' => 2
      ];
    }
    
    $this->Musuarios->CambiarSede($param);
    $usuario = $this->Musuarios->getOne($request->input('id'));
    Session::put('sede_id', $usuario->sede_id);
    
    return response()->json($usuario->sede);
  }
  
  public function cambiar_sede_general(Request $request): JsonResponse
  {
    $this->Musuarios->update([
      'id' => $request->input('usuario_id'), 
      'sede_id' => $request->input('sede_id')
    ]);
    
    Session::put('sede_id', $request->input('sede_id'));
    
    return response()->json('');
  }

  public function getUsuarios_zonas(): JsonResponse
  {
    return response()->json($this->Musuarios->getUsuarios_zonas());
  }
  
  public function delete_usuario_zona(Request $request): JsonResponse
  {
    return response()->json($this->Musuarios->delete_usuario_zona($request->all()));
  }
  
  public function add_usuario_zona(Request $request): JsonResponse
  {
    return response()->json($this->Musuarios_zonas->add($request->all()));
  }
  
  public function getUsuariosFromEmpresa(Request $request): JsonResponse
  {
    return response()->json($this->Musuarios->getUsuariosFromEmpresa($request->all()));
  }
  
  public function CambiarAnio(Request $request): JsonResponse
  {
    $usuario_id = $request->input('id');
    $usuario = $this->Musuarios->getOne($usuario_id);
    
    $this->Musuarios->CambiarAnio([
      'id' => $usuario->id, 
      'anio_plan' => $request->input('anio')
    ]);
    
    $usuario = $this->Musuarios->getOne($usuario_id);
    Session::put('anio_plan', $usuario->anio_plan);
    
    return response()->json($usuario->anio_plan);
  }
}


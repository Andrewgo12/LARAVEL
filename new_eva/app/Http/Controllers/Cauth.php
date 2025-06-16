<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Musuarios;
use App\Models\Mcentros;
use App\Models\Macciones;
use App\Models\Mequipos;
use App\Models\Madquisiciones;
use App\Models\Mfuentes;
use App\Models\Mtecnologias;
use App\Models\Mcbiomedicas;
use App\Models\Mcriesgos;
use App\Models\Mfrecuencias;
use App\Models\Mzonas;
use App\Models\Mpreventivos;
use App\Models\Mcalibraciones;
use App\Models\Mespecificaciones;
use App\Models\Mequipo_especificaciones;
use App\Models\Mcontactos;
use App\Models\Mequipo_contactos;
use App\Models\Mordenes;
use App\Models\Mcorrectivos_generales;
use App\Models\Mequipo_archivos;
use App\Models\Marchivos;
use App\Models\Mupload;

class CauthController extends Controller
{
    public function __construct()
    {
        // No middleware de auth para este controlador ya que maneja la autenticación
    }
    public function index(Request $request)
    {
        if (!$request->has('variable')) {
            if (Session::get('login')) {
                return redirect()->route('home');
            } else {
                $mcentros = app(Mcentros::class);
                $param = [
                    'centros' => $mcentros->getAllCentros()
                ];
                return view('auth.login', $param);
            }
        } else {
            return response()->json(['message' => 'existe']);
        }
    }
    public function reg(Request $request): JsonResponse
    {
        $control = [
            "respuesta" => "",
            "valor" => ""
        ];

        $data = $request->all();

        $rules = [
            'nombre' => 'required|min:5',
            'username' => 'required|unique:usuarios,username',
            'email' => 'required|email|unique:usuarios,email',
            'password1' => 'required|min:4',
            'password2' => 'required|same:password1'
        ];

        $messages = [
            'nombre.required' => 'Los nombres son obligatorios',
            'nombre.min' => 'Los nombres deben tener al menos 5 caracteres',
            'username.required' => 'El nombre de usuario es obligatorio',
            'username.unique' => 'El nombre de usuario ya se encuentra en la base de datos',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico debe ser válido',
            'email.unique' => 'El correo electrónico ya se encuentra en la base de datos',
            'password1.required' => 'La contraseña es obligatoria',
            'password1.min' => 'La contraseña debe tener al menos 4 caracteres',
            'password2.required' => 'Confirmar contraseña es obligatorio',
            'password2.same' => 'Las contraseñas no coinciden'
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->passes()) {
            $password_original = $data["password1"];
            $data['password'] = sha1(md5($data["password1"]));
            unset($data['password1']);
            unset($data['password2']);

            // Generar código aleatorio
            $code = Str::random(12);
            $data['code'] = $code;
            $data['active'] = "false";

            $musuarios = app(Musuarios::class);
            $id_ultimo_usuario = $musuarios->add($data);

            $control["respuesta"] = 1;
            $control["valor"] = $id_ultimo_usuario;
            $control["password"] = $password_original;
        } else {
            $control["respuesta"] = 0;
            $control["valor"] = $validator->errors()->all();
        }

        return response()->json($control);
    }
    public function email_registro(Request $request): JsonResponse
    {
        $data = $request->all();
        $password = $data["password"];
        unset($data["password"]);

        $musuarios = app(Musuarios::class);
        $usuario = $musuarios->getOne($data["id"]);

        $vector_usuario = [
            "usuario" => $usuario,
            "password" => $password
        ];

        try {
            Mail::send('usuarios.email_reg', $vector_usuario, function ($message) use ($usuario) {
                $message->from('evagestionahuv@gmail.com', 'Electromedicina HUV');
                $message->to($usuario->email, $usuario->nombre . ' ' . $usuario->apellido);
                $message->subject('Creación de cuenta exitosa');
            });

            return response()->json([
                'success' => true,
                'message' => 'Email enviado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el email: ' . $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->all();

        $control = [
            "existe" => "si",
            "confirmo" => "si"
        ];

        $musuarios = app(Musuarios::class);
        $macciones = app(Macciones::class);

        $usuario = $musuarios->login($data);

        if ($usuario == false) {
            $control["existe"] = "no";
        } else {
            if ($usuario->active == "true") {
                $acciones = $macciones->getByUser($usuario->id);

                $sessionData = [
                    'id' => $usuario->id,
                    'nombre' => $usuario->nombre,
                    'apellido' => $usuario->apellido,
                    'telefono' => $usuario->telefono,
                    'email' => $usuario->email,
                    'username' => $usuario->username,
                    'rol_id' => $usuario->rol_id,
                    'login' => true,
                    'sede_id' => $usuario->sede_id,
                    'acciones' => $acciones,
                    'anio_plan' => $usuario->anio_plan,
                    'id_empresa' => $usuario->id_empresa
                ];

                // Guardar en sesión de Laravel
                foreach ($sessionData as $key => $value) {
                    Session::put($key, $value);
                }
            } else {
                $control["confirmo"] = "no";
            }
        }

        return response()->json($control);
    }
    public function logout()
    {
        Session::flush();
        return redirect()->route('auth.login');
    }

    public function hoja_de_vida($var = "")
    {
        $vector = [
            "id" => $var,
            "equipo_id" => $var
        ];

        $mequipos = app(Mequipos::class);
        $mpreventivos = app(Mpreventivos::class);
        $mcalibraciones = app(Mcalibraciones::class);
        $mequipo_especificaciones = app(Mequipo_especificaciones::class);
        $mequipo_contactos = app(Mequipo_contactos::class);
        $mordenes = app(Mordenes::class);
        $mcorrectivos_generales = app(Mcorrectivos_generales::class);
        $mequipo_archivos = app(Mequipo_archivos::class);

        $equipo = $mequipos->getOne($vector);
        unset($vector["id"]);
        $preventivos = $mpreventivos->get($vector);
        $calibraciones = $mcalibraciones->get($vector);
        $especificaciones = $mequipo_especificaciones->get($vector);
        $contactos = $mequipo_contactos->get($vector);
        $correctivos = $mordenes->get($vector);
        $correctivos_generales = $mcorrectivos_generales->get($vector);
        $vector["id"] = $vector["equipo_id"];
        $archivos = $mequipo_archivos->get($vector);

        $param = [
            'equipo' => $equipo,
            'preventivos' => $preventivos,
            'calibraciones' => $calibraciones,
            'especificaciones' => $especificaciones,
            'contactos' => $contactos,
            'correctivos' => $correctivos,
            'correctivos_generales' => $correctivos_generales,
            'archivos' => $archivos
        ];

        $identificador = [
            "identificador" => $var
        ];

        return view("detalle.detalle", $param);
    }

    public function activate($id, $code)
    {
        $musuarios = app(Musuarios::class);
        $macciones = app(Macciones::class);

        // Obtener los detalles del usuario
        $usuario = $musuarios->getOne($id);

        // Si el código coincide
        if ($usuario && $usuario->code == $code) {
            // Actualizar el estado activo del usuario
            $data = ['active' => "true"];
            $query = $musuarios->activate($data, $id);

            if ($query) {
                Session::flash('message', 'Cuenta activada exitosamente');

                // Asignar permisos básicos al usuario
                $macciones->add($id, 1, 1, 0, 0, 0); // equipos
                $macciones->add($id, 2, 0, 0, 0, 0); // usuarios
                $macciones->add($id, 3, 0, 0, 0, 0); // servicios
                $macciones->add($id, 4, 1, 0, 0, 0); // equipos industriales
                $macciones->add($id, 5, 0, 0, 0, 0); // bajas equipos biomedicos
                $macciones->add($id, 6, 0, 0, 0, 0); // invimas
                $macciones->add($id, 7, 0, 0, 0, 0); // soportes compra
                $macciones->add($id, 8, 0, 0, 0, 0); // repuestos
                $macciones->add($id, 9, 0, 0, 0, 0); // estado equipos
                $macciones->add($id, 10, 0, 0, 0, 0); // contactos
                $macciones->add($id, 11, 0, 0, 0, 0); // reportes
                $macciones->add($id, 12, 0, 0, 0, 0); // planes mantenimiento
                $macciones->add($id, 13, 0, 0, 0, 0); // capacitaciones
                $macciones->add($id, 14, 0, 0, 0, 0); // equipo archivos
                $macciones->add($id, 15, 1, 1, 0, 0); // tickets propios
                $macciones->add($id, 16, 0, 0, 0, 0); // tickets activos
                $macciones->add($id, 17, 0, 0, 0, 0); // tickets cerrados
                $macciones->add($id, 18, 0, 0, 0, 0); // observaciones
                $macciones->add($id, 20, 0, 0, 0, 0); // areas
                $macciones->add($id, 21, 0, 0, 0, 0); // contingencias
                $macciones->add($id, 22, 0, 0, 0, 0); // guias rapidas
            } else {
                Session::flash('message', 'Hubo un problema durante el proceso de activación de la cuenta');
            }
        } else {
            Session::flash('message', 'No se pudo activar la cuenta. Código no coincide');
        }

        return redirect()->route('auth.login');
    }
}
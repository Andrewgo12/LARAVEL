<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Modelo de Usuarios - Sistema HUV
 */
class Musuarios extends Model
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $fillable = [
        'username', 'password', 'nombre', 'email', 'rol_id', 'centro_id',
        'id_empresa', 'sede_id', 'estado', 'anio_plan'
    ];

    protected $hidden = ['password'];

    // Relaciones
    public function rol()
    {
        return $this->belongsTo(Mroles::class, 'rol_id');
    }

    public function centro()
    {
        return $this->belongsTo(Mcentros::class, 'centro_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Mempresas::class, 'id_empresa');
    }

    public function sede()
    {
        return $this->belongsTo(Msedes::class, 'sede_id');
    }
    // Métodos convertidos a Laravel Eloquent
    public static function getOneUser($id)
    {
        return self::select('usuarios.*')
            ->leftJoin('roles', 'usuarios.rol_id', '=', 'roles.id')
            ->where('usuarios.estado', 1)
            ->where('usuarios.id', $id)
            ->orderBy('usuarios.nombre', 'asc')
            ->first();
    }

    public static function getAllUsers()
    {
        return self::select('usuarios.*')
            ->leftJoin('roles', 'usuarios.rol_id', '=', 'roles.id')
            ->where('usuarios.estado', 1)
            ->orderBy('usuarios.nombre', 'asc')
            ->get();
    }

    public static function get()
    {
        return self::all();
    }

    public static function getAll()
    {
        return self::all();
    }

    public static function getUsuariosZonas()
    {
        return DB::select("
            SELECT
                usuarios_zonas.*,
                usuarios.nombre AS usuario,
                usuarios.email AS email,
                zonas.name AS zona
            FROM
                usuarios_zonas
            LEFT JOIN usuarios ON usuarios.id = usuarios_zonas.usuario_id
            LEFT JOIN zonas ON zonas.id = usuarios_zonas.zona_id
            ORDER BY zonas.name asc, usuarios.nombre asc
        ");
    }

    public static function deleteUsuarioZona($param)
    {
        return DB::table('usuarios_zonas')->where('id', $param['id'])->delete();
    }

    public static function login($param)
    {
        $user = self::where('username', $param['username'])
            ->where('password', sha1(md5($param['password'])))
            ->where('estado', 1)
            ->first();

        return $user ?: false;
    }
    public static function getServerSide($param)
    {
        if ($param['length'] < 0) {
            $param['length'] = 999999999;
        }

        $searchValue = $param['search']['value'] ?? '';

        $query = self::select('usuarios.*', 'roles.nombre as rol', 'centros.name as centro')
            ->leftJoin('roles', 'roles.id', '=', 'usuarios.rol_id')
            ->leftJoin('centros', 'centros.id', '=', 'usuarios.centro_id')
            ->where('usuarios.estado', '!=', 0);

        if ($searchValue) {
            $query->where(function($q) use ($searchValue) {
                $q->where('usuarios.username', 'like', "%{$searchValue}%")
                  ->orWhere('usuarios.nombre', 'like', "%{$searchValue}%");
            });
        }

        $totalRecords = $query->count();
        $datos = $query->offset($param['start'])->limit($param['length'])->get();

        return [
            'datos' => $datos,
            'num_filas_limit' => count($datos),
            'num_filas' => $totalRecords
        ];
    }

    public static function getRoles()
    {
        return DB::table('roles')->get();
    }

    public static function getUsuariosFromEmpresa($param)
    {
        return self::where('id_empresa', $param['empresa_id'])->get();
    }

    public static function add($param)
    {
        $user = self::create($param);
        return $user->id;
    }

    public static function updateUser($param)
    {
        $id = $param['id'];
        unset($param['id']);
        return self::where('id', $id)->update($param);
    }

    public static function deleteUser($param, $array)
    {
        return self::where('id', $param['id'])->update($array);
    }

    public static function getOne($param)
    {
        return self::select(
                'usuarios.*',
                'roles.nombre as rol',
                'centros.name as centro',
                'empresas.name as empresa',
                'sedes.name as sede'
            )
            ->leftJoin('roles', 'roles.id', '=', 'usuarios.rol_id')
            ->leftJoin('centros', 'centros.id', '=', 'usuarios.centro_id')
            ->leftJoin('empresas', 'empresas.id', '=', 'usuarios.id_empresa')
            ->leftJoin('sedes', 'sedes.id', '=', 'usuarios.sede_id')
            ->where('usuarios.id', $param)
            ->first();
    }

    public static function activate($data, $id)
    {
        return self::where('id', $id)->update($data);
    }

    public static function cambiarSede($param)
    {
        $sedeId = ($param['caso'] == 1) ? 2 : 1;
        return self::where('id', $param['id'])->update(['sede_id' => $sedeId]);
    }

    public static function cambiarAnio($param)
    {
        return self::where('id', $param['id'])->update(['anio_plan' => $param['anio_plan']]);
    }
}

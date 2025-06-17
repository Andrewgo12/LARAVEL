<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Modelo Mservicios - Sistema HUV
 * Gestiona los datos para el módulo servicios
 */
class Mservicios extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo
     */
    protected $table = 'servicios';

    /**
     * Campos que se pueden asignar masivamente
     */
    protected $fillable = [
        'nombre', 'descripcion', 'estado', 'usuario_id', 'created_at', 'updated_at'
    ];

    /**
     * Campos que deben ser tratados como fechas
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * Obtener todos los registros
     */
    public static function getAll()
    {
        return self::where('estado', '!=', 0)->get();
    }

    /**
     * Obtener registros para DataTables
     */
    public static function getServerSide($params)
    {
        $query = self::where('estado', '!=', 0);
        
        if (isset($params['search']['value']) && $params['search']['value']) {
            $search = $params['search']['value'];
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }
        
        $totalRecords = $query->count();
        $datos = $query->offset($params['start'])->limit($params['length'])->get();
        
        return [
            'datos' => $datos,
            'num_filas' => $totalRecords,
            'num_filas_limit' => count($datos)
        ];
    }

    /**
     * Obtener un registro específico
     */
    public static function getOne($id)
    {
        return self::find($id);
    }

    /**
     * Agregar nuevo registro
     */
    public static function add($data)
    {
        $item = self::create($data);
        return $item->id;
    }

    /**
     * Actualizar registro
     */
    public static function edit($data)
    {
        $id = $data['id'];
        unset($data['id']);
        return self::where('id', $id)->update($data);
    }

    /**
     * Eliminar registro (cambiar estado)
     */
    public static function remove($id)
    {
        return self::where('id', $id)->update(['estado' => 0]);
    }
}

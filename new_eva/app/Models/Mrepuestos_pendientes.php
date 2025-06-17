<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

/**
 * Mrepuestos_pendientes - Sistema HUV (Convertido automáticamente)
 */
class Mrepuestos_pendientes extends Model
{
    use HasFactory;

    protected $table = 'repuestos_pendientes';
    protected $fillable = [];

    // Métodos básicos
    public static function getAll()
    {
        return self::all();
    }

    public static function getOne($id)
    {
        return self::find($id);
    }

    public static function add($data)
    {
        return self::create($data);
    }

    public static function edit($data)
    {
        $id = $data['id'];
        unset($data['id']);
        return self::where('id', $id)->update($data);
    }

    public static function remove($id)
    {
        return self::destroy($id);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

/**
 * Mavances_correctivos - Sistema HUV (Convertido automáticamente)
 */
class Mavances_correctivos extends Model
{
    use HasFactory;

    protected $table = 'avances_correctivos';
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

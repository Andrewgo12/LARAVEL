<?php

namespace App\Http\Controllers\administrador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Macciones;

class Cacciones extends Controller
{
    protected Macciones $Macciones;

    public function __construct()
    {
        $this->Macciones = new Macciones();
    }

    public function getAll()
    {
        // Aquí puedes retornar todas las acciones si es necesario
        // return response()->json($this->Macciones->all());
    }

    public function getByUser()
    {
        // Si necesitas recibir ID por request, agrégalo como argumento
        // return response()->json($this->Macciones->getByUser($userId));
    }

    public function edit(Request $request)
    {
        $registro_acciones = $this->Macciones->getOne($request->all());

        $accion = $request->input('accion');

        switch ($accion) {
            case 1:
                $request->merge([
                    'leer' => $registro_acciones->leer == 1 ? 0 : 1,
                ]);
                break;
            case 2:
                $request->merge([
                    'insertar' => $registro_acciones->insertar == 1 ? 0 : 1,
                ]);
                break;
            case 3:
                $request->merge([
                    'editar' => $registro_acciones->editar == 1 ? 0 : 1,
                ]);
                break;
            case 4:
                $request->merge([
                    'eliminar' => $registro_acciones->eliminar == 1 ? 0 : 1,
                ]);
                break;
        }

        $data = $request->except('accion');
        $this->Macciones->edit($data);

        return response()->json(
            $this->Macciones->getByUser($registro_acciones->usuario_id)
        );
    }
}

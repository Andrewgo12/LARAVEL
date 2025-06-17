<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Support\Facades\Validator;

use Illuminate\Http\JsonResponse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Czonas - Sistema HUV (Convertido automáticamente)
 */
class Czonas extends Controller
{
    public function __construct()
    {
        // Constructor Laravel
    }

    public function index()
    {
        // Método index convertido
        return view('laravel.dashboard');
    }
}

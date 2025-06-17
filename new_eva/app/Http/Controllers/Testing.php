<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Testing - Sistema HUV (Convertido automáticamente)
 */
class Testing extends Controller
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

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/**
 * Zip - Sistema HUV (Convertido automáticamente)
 */
class Zip extends Controller
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

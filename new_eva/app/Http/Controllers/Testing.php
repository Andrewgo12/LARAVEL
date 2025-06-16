<?php

namespace App\Http\Controllers;

class TestingController extends Controller
{
    public function __construct()
    {
        // No se requiere autenticación ni otras verificaciones
    }
    
    public function index()
    {
        return view('layouts.adminlte3.header')
            ->nest('aside', 'layouts.adminlte3.aside')
            ->nest('content', 'layouts.adminlte3.body')
            ->nest('footer', 'layouts.adminlte3.footer');
            
        // Alternativa usando una vista completa:
        // return view('layouts.adminlte3.completo');
    }
}
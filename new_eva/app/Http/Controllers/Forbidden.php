<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class ForbiddenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        if (!Session::has('id')) {
            redirect('auth');
        }
    }
    
    public function index()
    {
        return view('layouts.header')
            ->nest('aside', 'layouts.aside')
            ->nest('content', 'admin.forbidden')
            ->nest('footer', 'layouts.footer');
    }
}
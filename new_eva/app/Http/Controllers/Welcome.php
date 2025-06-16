<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

/**
 * Welcome Controller - Migrated from CodeIgniter to Laravel 11
 * Handles welcome pages and test views
 * Originally used Smarty templates, now uses Laravel Blade
 */
class WelcomeController extends Controller
{
    /**
     * Display the main welcome page
     * Migrated from Smarty template to Laravel Blade
     */
    public function index()
    {
        $data = [
            'id' => 1,
            'name' => "Juan Sebastian",
            'email' => "test@example.com",
        ];

        // Set session data (Laravel equivalent of CodeIgniter session)
        Session::put($data);

        // Cache the view for performance (equivalent to Smarty caching)
        $cacheKey = 'welcome_index_' . md5(serialize($data));
        $cachedView = Cache::remember($cacheKey, 3600, function () use ($data) {
            return view('welcome.index', compact('data'))->render();
        });

        // Return the view with data
        return view('welcome.index', compact('data'));
    }

    /**
     * Test method for manuales list
     * Migrated from Smarty template to Laravel Blade
     */
    public function test()
    {
        // Check if the view exists, fallback to a default if not
        if (View::exists('manuales.list')) {
            return view('manuales.list');
        } else {
            // Fallback view or create a simple response
            return view('welcome.test', [
                'message' => 'Vista de prueba para manuales',
                'template_original' => 'manuales/list.tpl'
            ]);
        }
    }

    /**
     * Test method 2 for list2 template
     * Migrated from Smarty template to Laravel Blade
     */
    public function test2()
    {
        // Clean up the template name (remove extra space)
        $templateName = trim('list2.tpl');

        // Check if the view exists, fallback to a default if not
        if (View::exists('welcome.list2')) {
            return view('welcome.list2');
        } else {
            // Fallback view or create a simple response
            return view('welcome.test2', [
                'message' => 'Vista de prueba 2',
                'template_original' => $templateName
            ]);
        }
    }

    /**
     * Additional method to clear session data if needed
     */
    public function clearSession()
    {
        Session::flush();
        return redirect()->route('welcome.index')->with('success', 'Sesión limpiada correctamente');
    }

    /**
     * Method to display session data for debugging
     */
    public function showSession()
    {
        $sessionData = Session::all();

        return view('welcome.session', [
            'session_data' => $sessionData,
            'session_count' => count($sessionData)
        ]);
    }
}

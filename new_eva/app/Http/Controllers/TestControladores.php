<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\File;

/**
 * Pruebas automáticas para controladores
 * Ejecuta este archivo con PHPUnit o inclúyelo en tu framework de pruebas
 */
class TestControladores
{
    public function run()
    {
        $controllers = [
            'ApiController', 
            'AuthController', 
            'ChartsController', 
            'EmailController', 
            'ModulosController', 
            'UploadController', 
            'DashboardController', 
            'ForbiddenController', 
            'HomeController', 
            'TestingController', 
            'WelcomeController', 
            'ZipController'
        ];
        
        $results = [];
        
        foreach ($controllers as $ctrl) {
            $className = "App\\Http\\Controllers\\$ctrl";
            
            if (!class_exists($className)) {
                $results[] = "[FALTA] $ctrl";
                continue;
            }
            
            try {
                $obj = app()->make($className);
                $results[] = "[OK] $ctrl instanciado correctamente";
            } catch (Exception $e) {
                $results[] = "[ERROR] $ctrl: " . $e->getMessage();
            }
        }
        
        return $results;
    }
    
    /**
     * Ejecuta las pruebas y muestra los resultados en consola
     */
    public static function console()
    {
        $tester = new self();
        $results = $tester->run();
        
        foreach ($results as $result) {
            echo $result . PHP_EOL;
        }
    }
    
    /**
     * Ejecuta las pruebas y devuelve los resultados como JSON
     */
    public static function json()
    {
        $tester = new self();
        return response()->json($tester->run());
    }
}

// Si se ejecuta directamente desde la línea de comandos
if (php_sapi_name() === 'cli') {
    TestControladores::console();
}
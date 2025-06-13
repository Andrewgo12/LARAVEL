<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class TestController extends Controller
{
    public function testDatabase()
    {
        try {
            // Test de conexión a la base de datos
            $pdo = DB::connection()->getPdo();
            
            // Información de la base de datos
            $dbInfo = [
                'driver' => DB::connection()->getDriverName(),
                'database' => DB::connection()->getDatabaseName(),
                'status' => 'Conectado exitosamente'
            ];
            
            // Verificar tablas existentes
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
            $tableData = [];
            
            foreach ($tables as $table) {
                $tableName = $table->name;
                if ($tableName !== 'sqlite_sequence') {
                    try {
                        $count = DB::table($tableName)->count();
                        $tableData[] = ['name' => $tableName, 'count' => $count];
                    } catch (\Exception $e) {
                        $tableData[] = ['name' => $tableName, 'count' => 'Error'];
                    }
                }
            }
            
            // Verificar usuarios
            $users = DB::table('users')->get();
            
            return Inertia::render('test-database', [
                'status' => 'success',
                'message' => 'Conexión a base de datos exitosa',
                'database_info' => $dbInfo,
                'tables' => $tableData,
                'users' => $users,
                'users_count' => count($users)
            ]);
            
        } catch (\Exception $e) {
            return Inertia::render('test-database', [
                'status' => 'error',
                'message' => 'Error de conexión: ' . $e->getMessage(),
                'database_info' => null,
                'tables' => [],
                'users' => [],
                'users_count' => 0
            ]);
        }
    }
    
    public function createTestUsers()
    {
        try {
            $createdUsers = [];
            
            // Usuarios de prueba
            $testUsers = [
                ['name' => 'Usuario de Prueba', 'email' => 'test@example.com'],
                ['name' => 'Admin User', 'email' => 'admin@example.com'],
                ['name' => 'John Doe', 'email' => 'john@example.com'],
                ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            ];
            
            foreach ($testUsers as $userData) {
                $existing = DB::table('users')->where('email', $userData['email'])->first();
                if (!$existing) {
                    $userId = DB::table('users')->insertGetId([
                        'name' => $userData['name'],
                        'email' => $userData['email'],
                        'email_verified_at' => now(),
                        'password' => Hash::make('password123'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $createdUsers[] = [
                        'id' => $userId, 
                        'name' => $userData['name'], 
                        'email' => $userData['email'], 
                        'status' => 'created'
                    ];
                } else {
                    $createdUsers[] = [
                        'id' => $existing->id, 
                        'name' => $existing->name, 
                        'email' => $existing->email, 
                        'status' => 'already_exists'
                    ];
                }
            }
            
            // Obtener todos los usuarios
            $allUsers = DB::table('users')->orderBy('created_at', 'desc')->get();
            
            return Inertia::render('test-users', [
                'status' => 'success',
                'message' => 'Usuarios de prueba procesados',
                'created_users' => $createdUsers,
                'all_users' => $allUsers,
                'login_info' => [
                    'message' => 'Puedes usar cualquiera de estos usuarios para hacer login',
                    'credentials' => 'Email: test@example.com | Contraseña: password123'
                ]
            ]);
            
        } catch (\Exception $e) {
            return Inertia::render('test-users', [
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
                'created_users' => [],
                'all_users' => [],
                'login_info' => null
            ]);
        }
    }
}

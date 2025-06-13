import { Head } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface DatabaseInfo {
    driver: string;
    database: string;
    status: string;
}

interface Table {
    name: string;
    count: number | string;
}

interface User {
    id: number;
    name: string;
    email: string;
    created_at: string;
}

interface Props {
    status: 'success' | 'error';
    message: string;
    database_info: DatabaseInfo | null;
    tables: Table[];
    users: User[];
    users_count: number;
}

export default function TestDatabase({ 
    status, 
    message, 
    database_info, 
    tables, 
    users, 
    users_count 
}: Props) {
    return (
        <>
            <Head title="Test Base de Datos" />
            
            <div className="min-h-screen bg-gray-50 py-12">
                <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="bg-white shadow rounded-lg p-6">
                        <h1 className="text-3xl font-bold text-gray-900 mb-6">
                            🚀 Test de Conexión a Base de Datos - Laravel
                        </h1>
                        
                        {/* Estado de la conexión */}
                        <div className={`p-4 rounded-md mb-6 ${
                            status === 'success' 
                                ? 'bg-green-50 border border-green-200' 
                                : 'bg-red-50 border border-red-200'
                        }`}>
                            <div className={`text-sm font-medium ${
                                status === 'success' ? 'text-green-800' : 'text-red-800'
                            }`}>
                                {status === 'success' ? '✅' : '❌'} {message}
                            </div>
                        </div>
                        
                        {/* Información de la base de datos */}
                        {database_info && (
                            <div className="mb-6">
                                <h2 className="text-xl font-semibold text-gray-900 mb-3">
                                    📋 Información de la Base de Datos
                                </h2>
                                <div className="bg-blue-50 border border-blue-200 rounded-md p-4">
                                    <p><strong>Driver:</strong> {database_info.driver}</p>
                                    <p><strong>Base de datos:</strong> {database_info.database}</p>
                                    <p><strong>Estado:</strong> {database_info.status}</p>
                                </div>
                            </div>
                        )}
                        
                        {/* Tablas */}
                        {tables.length > 0 && (
                            <div className="mb-6">
                                <h2 className="text-xl font-semibold text-gray-900 mb-3">
                                    📊 Tablas en la Base de Datos
                                </h2>
                                <div className="overflow-x-auto">
                                    <table className="min-w-full divide-y divide-gray-200">
                                        <thead className="bg-gray-50">
                                            <tr>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Nombre de la Tabla
                                                </th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Registros
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody className="bg-white divide-y divide-gray-200">
                                            {tables.map((table, index) => (
                                                <tr key={index}>
                                                    <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {table.name}
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {table.count}
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        )}
                        
                        {/* Usuarios */}
                        <div className="mb-6">
                            <h2 className="text-xl font-semibold text-gray-900 mb-3">
                                👥 Usuarios en el Sistema ({users_count})
                            </h2>
                            
                            {users.length > 0 ? (
                                <div className="overflow-x-auto">
                                    <table className="min-w-full divide-y divide-gray-200">
                                        <thead className="bg-gray-50">
                                            <tr>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    ID
                                                </th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Nombre
                                                </th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Email
                                                </th>
                                                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Creado
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody className="bg-white divide-y divide-gray-200">
                                            {users.map((user) => (
                                                <tr key={user.id}>
                                                    <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {user.id}
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {user.name}
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {user.email}
                                                    </td>
                                                    <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {user.created_at}
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            ) : (
                                <div className="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                                    <p className="text-yellow-800">
                                        No hay usuarios registrados en el sistema.
                                    </p>
                                    <p className="text-yellow-700 mt-2">
                                        <strong>¿Quieres crear usuarios de prueba?</strong>
                                    </p>
                                </div>
                            )}
                        </div>
                        
                        {/* Enlaces útiles */}
                        <div className="border-t pt-6">
                            <h2 className="text-xl font-semibold text-gray-900 mb-3">
                                🔗 Enlaces Útiles
                            </h2>
                            <div className="flex flex-wrap gap-3">
                                <Button asChild>
                                    <a href="/">🏠 Página Principal</a>
                                </Button>
                                <Button asChild variant="outline">
                                    <a href="/create-test-users">👤 Crear Usuarios</a>
                                </Button>
                                <Button asChild variant="outline">
                                    <a href="/login">🔐 Login</a>
                                </Button>
                                <Button asChild variant="outline">
                                    <a href="/register">📝 Registro</a>
                                </Button>
                                <Button asChild variant="outline">
                                    <a href="/dashboard">📊 Dashboard</a>
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

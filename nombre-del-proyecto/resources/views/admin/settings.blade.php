<x-app-layout>
    <div class="flex flex-col min-h-screen">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Inicio') }}
            </h2>
        </x-slot>
        <div class="flex-grow">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="container mx-auto px-4 py-8">
                            <h1 class="text-3xl font-semibold text-gray-800 mb-8">Configuración del Administrador</h1>

                            <div class="bg-white shadow rounded-lg p-6">
                                <h2 class="text-2xl font-semibold text-gray-700 mb-6">Gestión de Usuarios</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">Usuarios</h3>
                                        <p class="text-gray-600">Visualiza, edita y elimina usuarios de la plataforma.</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            Gestionar Usuarios
                                        </a>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">Roles y Permisos</h3>
                                        <p class="text-gray-600">Configura los roles y permisos de los usuarios.</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            Gestionar Roles
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white shadow rounded-lg p-6 mt-8">
                                <h2 class="text-2xl font-semibold text-gray-700 mb-6">Configuración del Sistema</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">Configuraciones Generales</h3>
                                        <p class="text-gray-600">Ajusta las configuraciones generales del sistema.</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            Ajustes Generales
                                        </a>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">Preferencias de Notificación</h3>
                                        <p class="text-gray-600">Configura cómo y cuándo deseas recibir notificaciones.</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            Ajustes de Notificación
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white shadow rounded-lg p-6 mt-8">
                                <h2 class="text-2xl font-semibold text-gray-700 mb-6">Ajustes de Perfil</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">Información del Perfil</h3>
                                        <p class="text-gray-600">Actualiza tu información personal y detalles del perfil.</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            Editar Perfil
                                        </a>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">Seguridad</h3>
                                        <p class="text-gray-600">Gestiona la seguridad de tu cuenta incluyendo contraseñas y autenticación de dos factores.</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            Configuración de Seguridad
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
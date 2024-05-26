<x-app-layout>
    <div class="container mt-5">
        <div class="flex justify-center">
            <div class="p-6 lg:p-8 grid grid-cols-1 gap-6 mt-6 w-full max-w-7xl">
                <div class="bg-white shadow-md rounded-lg p-4 lg:p-10 mx-auto w-full">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">Menú de Opciones</h3>
                    <a href="{{ url('/menu/gestionar') }}" class="block bg-gray-100 py-4 px-12 rounded hover:bg-indigo-300 transition duration-150 mb-4">
                        <div class="flex items-center">
                            <img src="{{ asset('images/editar.png') }}" alt="Icono de Creación de Tablas" class="w-6 h-6">
                            <h2 class="ms-3 text-m font-semibold text-gray-600">
                                Gestionar Tablas
                            </h2>
                        </div>
                    </a>
                    <a href="#" class="block bg-gray-100 py-4 px-12 rounded hover:bg-gray-300 transition duration-150 mb-4">
                        <div class="flex items-center">
                            <img src="{{ asset('images/crear.png') }}" alt="Icono de Creación de Tablas" class="w-6 h-6">
                            <h2 class="ms-3 text-m font-semibold text-gray-600">
                                Crear Tablas
                            </h2>
                        </div>
                    </a>
                    <a href="{{ url('/menu/importar') }}" class="block bg-gray-100 py-4 px-12 rounded hover:bg-indigo-300 transition duration-150 mb-4">
                        <div class="flex items-center">
                            <img src="{{ asset('images/compartir.png') }}" alt="Icono de Creación de Tablas" class="w-6 h-6">
                            <h2 class="ms-3 text-m font-semibold text-gray-600">
                                Importar Tablas
                            </h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

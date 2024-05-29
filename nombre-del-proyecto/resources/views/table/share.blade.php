<x-app-layout>
    <div class="flex flex-col min-h-screen">
        <div class="container mt-5 flex-grow">
            <div class="bg-white shadow-md rounded-lg p-6 lg:p-8 mx-auto w-full max-w-7xl">
                <div class="mb-4">
                    <h3 class="text-2xl font-semibold text-gray-900">Compartir Tabla: {{ $table }}</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <!-- Formulario para compartir la tabla -->
                    <form action="{{ route('table.processShare', ['table' => $table]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="user_id" class="block text-sm font-medium text-gray-700">ID del Usuario</label>
                            <input type="text" id="user_id" name="user_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                        </div>
                        <div class="mb-4">
                            <label for="permission" class="block text-sm font-medium text-gray-700">Permiso</label>
                            <select id="permission" name="permission" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="ver">Ver</option>
                                <option value="editar">Editar</option>
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 text-white hover:bg-green-600 transition duration-150 rounded-md">Compartir</button>
                        </div>
                    </form>

                    <!-- Tabla de datos compartidos -->
                    <div class="mt-6 overflow-x-auto">
                        <h4 class="text-xl font-semibold text-gray-900">Usuarios con acceso</h4>
                        @php
                            $filteredSharedData = $sharedData->filter(function ($data) {
                                return $data->propietario == Auth::user()->id;
                            });
                        @endphp
                        @if ($filteredSharedData->isEmpty())
                            <p class="text-gray-600">No se ha compartido esta tabla con ningún usuario.</p>
                        @else
                            <table class="min-w-full divide-y divide-gray-200 mt-4">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Usuario</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre del Usuario</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de la Tabla Compartida</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permiso</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($filteredSharedData as $data)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $data->usuario_compartido }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $data->user_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ str_replace('_', ' ', $data->tipo_tabla) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if ($data->editar)
                                                    Editar
                                                @elseif ($data->visualizar)
                                                    Ver
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <form action="{{ route('table.deleteSharedAccess', ['id' => $data->id]) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white hover:bg-red-600 transition duration-150 rounded-md">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <a href="{{ route('menu.gestionar') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        Volver a Gestionar Tablas
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Añadir el script para Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<x-app-layout>
    <div class="flex flex-col min-h-screen">
        <div class="container mt-5 flex-grow">
            <div class="bg-white shadow-md rounded-lg p-6 lg:p-8 mx-auto w-full max-w-7xl">
                <!-- Migas de pan -->
                <nav class="mb-4 text-sm text-gray-700" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center">
                            <a href="{{ route('table.gestionar') }}" class="text-blue-500 hover:text-blue-700">Gestionar Tablas</a>
                            <svg class="fill-current w-3 h-3 mx-3" viewBox="0 0 320 512"><path d="M285.5 272H12c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h273.5c4.7 0 9.2-2.7 11.3-7l96-176c3.9-7.1 1-15.8-6.2-19.8l-14.6-8.2c-7.2-4.1-15.9-1-19.8 6.2l-96 176c-2.1 4.3-6.6 7-11.3 7z"/></svg>
                        </li>
                        <li class="flex items-center">
                            <a href="{{ route('table.view', ['table' => $table]) }}" class="text-blue-500 hover:text-blue-700">{{ str_replace('_', ' ', $table) }}</a>
                            <svg class="fill-current w-3 h-3 mx-3" viewBox="0 0 320 512"><path d="M285.5 272H12c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h273.5c4.7 0 9.2-2.7 11.3-7l96-176c3.9-7.1 1-15.8-6.2-19.8l-14.6-8.2c-7.2-4.1-15.9-1-19.8 6.2l-96 176c-2.1 4.3-6.6 7-11.3 7z"/></svg>
                        </li>
                        <li class="flex items-center">
                            <span class="text-gray-700">Compartir</span>
                        </li>
                    </ol>
                </nav>
                <!-- Fin de migas de pan -->
                <div class="mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Compartir Tabla: <span class="uppercase">{{ str_replace('_', ' ', $table) }}</span></h3>
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
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-200 text-green-600 hover:bg-green-300 transition duration-150 rounded-md">Compartir</button>
                        </div>
                    </form>

                    <!-- Tabla de datos compartidos -->
                    <div class="mt-6 overflow-x-auto">
                        <h4 class="text-l font-semibold text-gray-900">Usuarios con acceso</h4>
                        @php
                        $filteredSharedData = $sharedData->filter(function ($data) {
                        return $data->propietario == Auth::user()->id;
                        });
                        @endphp
                        @if ($filteredSharedData->isEmpty())
                        <p class="text-gray-600">No se ha compartido esta tabla con ningún usuario.</p>
                        @else
                        <table class="min-w-full divide-y divide-gray-200 mt-4 border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">ID Usuario</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre del Usuario</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de la Tabla Compartida</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Permiso</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($filteredSharedData as $data)
                                <tr>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $data->usuario_compartido }}</td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ $data->user_name }}</td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">{{ str_replace('_', ' ', $data->tipo_tabla) }}</td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        @if ($data->editar)
                                        Editar
                                        @elseif ($data->visualizar)
                                        Ver
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <form action="{{ route('table.deleteSharedAccess', ['id' => $data->id]) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-200 text-red-600 hover:bg-red-300 transition duration-150 rounded-md">
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
                    <a href="{{ route('table.gestionar') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Añadir el script para Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

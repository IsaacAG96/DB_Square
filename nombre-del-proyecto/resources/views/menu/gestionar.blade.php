<x-app-layout>
    <div class="flex flex-col min-h-screen">
        <div class="container mt-5 flex-grow">
            <div class="bg-white shadow-md rounded-lg p-6 lg:p-8 mx-auto w-full max-w-7xl">
                <div class="mb-4">
                    <h3 class="text-2xl font-semibold text-gray-900">Lista de Tablas</h3>
                </div>
                <div class="card-body">
                    @if ($tables->isEmpty())
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                        No hay tablas disponibles para mostrar.
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre de la Tabla</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nº Registros</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($tables as $table => $count)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-extrabold text-gray-800 text-base uppercase">{{ str_replace('_', ' ', $table) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('table.view', ['table' => $table]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-200 text-indigo-600 hover:bg-indigo-300 transition duration-150 rounded-md">Ver</a>
                                        <a href="{{ route('table.edit', ['table' => $table]) }}" class="inline-flex items-center px-4 py-2 bg-yellow-200 text-yellow-600 hover:bg-yellow-300 transition duration-150 rounded-md ml-4">Editar</a>
                                        <form action="{{ route('table.delete', ['table' => $table]) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-200 text-red-600 hover:bg-red-300 transition duration-150 rounded-md ml-4">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Añadir la paginación -->
                    <div class="mt-4">
                        {{ $tables->links('vendor.pagination.bootstrap-4') }}
                    </div>
                    @endif
                </div>
                <div class="mt-4 text-right">
                    <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        Volver al Menú
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
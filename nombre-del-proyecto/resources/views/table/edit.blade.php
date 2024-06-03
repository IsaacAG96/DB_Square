<x-app-layout>
    <div class="container mt-5 mb-5">
        <div class="bg-white shadow-md rounded-lg p-6 mx-auto w-full max-w-7xl">
            <div class="mb-4 flex justify-between items-center">
                <h3 class="text-xl font-semibold text-gray-900">Editar <span class="uppercase">{{ str_replace('_', ' ', $table) }}</span></h3>
                <a href="{{ route('table.create', ['table' => $table]) }}" class="px-4 py-2 bg-green-500 text-white rounded">Añadir datos</a>
            </div>
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
            @endif
            @if ($data->isEmpty())
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                No hay registros disponibles para mostrar.
            </div>
            @else
            <form method="GET" action="{{ route('table.edit', ['table' => $table]) }}">
                <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach (array_keys((array) $data->first()) as $column)
                    @if ($column != 'id')
                    <div>
                        <label for="{{ $column }}" class="block text-sm font-medium text-gray-700">{{ $column == 'id_propietario' ? 'Propietario' : $column }}</label>
                        <input type="text" name="{{ $column }}" id="{{ $column }}" value="{{ $filters[$column] ?? '' }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Filtrar {{ $column }}">
                    </div>
                    @endif
                    @endforeach
                    <div class="flex items-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-500 text-white hover:bg-indigo-700 transition duration-300 rounded">Filtrar</button>
                    </div>
                </div>
            </form><br>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead class="bg-gray-100">
                        <tr>
                            @foreach (array_keys((array) $data->first()) as $column)
                            @if ($column != 'id')
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-800 uppercase tracking-wider">
                                {{ $column == 'id_propietario' ? 'Propietario' : $column }}
                                <a href="{{ route('table.edit', ['table' => $table, 'sort_field' => $column, 'sort_order' => ($sortField == $column && $sortOrder == 'asc') ? 'desc' : 'asc'] + request()->except(['sort_field', 'sort_order', 'page'])) }}">
                                    @if ($sortField == $column)
                                    @if ($sortOrder == 'asc')
                                    ↑
                                    @else
                                    ↓
                                    @endif
                                    @else
                                    ↑↓
                                    @endif
                                </a>
                            </th>
                            @endif
                            @endforeach
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-800 uppercase tracking-wider" colspan="2">
                                Acción
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($data as $row)
                        <tr>
                            <form method="POST" action="{{ route('table.update', ['table' => $table, 'id' => $row->id]) }}">
                                @csrf
                                @method('PUT')
                                @foreach ($row as $key => $value)
                                @if ($key != 'id')
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if ($key == 'id_propietario')
                                    {{ $owners[$value] }}#{{ $value }}
                                    @else
                                    <input type="text" name="{{ $key }}" value="{{ $value }}" class="input-adjust-width w-full px-2 py-1 border border-gray-300 rounded" oninput="adjustWidth(this)">
                                    @endif
                                </td>
                                @endif
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900" colspan="2">
                                    <div class="flex space-x-4">
                                        <button type="submit" class="px-4 py-2 bg-blue-200 text-blue-600 hover:bg-blue-300 transition duration-150 rounded-md">Actualizar</button>
                                        <form method="POST" action="{{ route('table.deleteRecord', ['table' => $table, 'id' => $row->id]) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este registro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 bg-red-200 text-red-600 hover:bg-red-300 transition duration-150 rounded-md">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </form>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            <div class="mt-4 text-right">
                <a href="{{ route('table.gestionar') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                    Volver
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ajusta el ancho de los inputs según el contenido
            document.querySelectorAll('.input-adjust-width').forEach(function(input) {
                adjustWidth(input);
            });
        });

        function adjustWidth(input) {
            input.style.width = (input.value.length + 2) + 'ch';
        }
    </script>
</x-app-layout>

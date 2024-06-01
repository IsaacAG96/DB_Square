<x-app-layout>
    <div class="container mt-5">
        <div class="bg-white shadow-md rounded-lg p-6 mx-auto w-full max-w-7xl">
            <div class="mb-4">
                <h3 class="text-2xl font-semibold text-gray-900">{{ str_replace('_', ' ', $table) }}</h3>
            </div>
            @if ($data->isEmpty())
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    No hay registros disponibles para mostrar.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach (array_keys((array) $data->first()) as $column)
                                    @if ($column != 'id')
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ $column == 'id_propietario' ? 'Propietario' : $column }}
                                            <a href="{{ route('table.view', ['table' => $table, 'sort_field' => $column, 'sort_order' => ($sortField == $column && $sortOrder == 'asc') ? 'desc' : 'asc']) }}">
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
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($data as $row)
                                <tr>
                                    @foreach ($row as $key => $value)
                                        @if ($key != 'id')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                @if ($key == 'id_propietario')
                                                    {{ $owners[$value] }}#{{ $value }}
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
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
</x-app-layout>

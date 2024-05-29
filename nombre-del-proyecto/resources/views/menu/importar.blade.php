<x-app-layout>
    <div class="flex flex-col min-h-screen">
        <div class="container mt-5 flex-grow">
            <div class="bg-white shadow-md rounded-lg p-6 lg:p-8 mx-auto w-full max-w-7xl">
                <div class="mb-4">
                    <h3 class="text-2xl font-semibold text-gray-900">Importar Tablas</h3>
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
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tabla</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Campos</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($tables as $table => $columns)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-extrabold text-gray-800 text-sm uppercase">{{ ucfirst(str_replace('_', ' ', $table)) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ implode(' | ', array_map('ucfirst', array_map('str_replace', array_fill(0, count($columns), '_'), array_fill(0, count($columns), ' '), $columns))) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        @if ($importedTables[$table])
                                        <span class="text-green-500 font-bold">&#10003;</span>
                                        @else
                                        <form method="POST" action="{{ route('menu.importTable') }}" class="inline-block">
                                            @csrf
                                            <input type="hidden" name="table" value="{{ $table }}">
                                            <button type="submit" class="bg-indigo-500 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700 transition duration-150">Importar</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mt-4 text-left">
                    {{ $tables->links('vendor.pagination.bootstrap-4') }}
                </div>
                <div class="mt-6 text-right">
                    <a href="{{ route('menu.index') }}" class="items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-800 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        Volver al Menú
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
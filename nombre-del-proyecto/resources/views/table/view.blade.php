<x-app-layout>
    <div class="container mt-5 mb-5">
        <div class="bg-white shadow-md rounded-lg p-6 mx-auto w-full max-w-7xl">
            <!-- Migas de pan -->
            <nav class="mb-4 text-sm text-gray-700" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">{{__('Home')}}</a>
                        <svg class="fill-current w-3 h-3 mx-3" viewBox="0 0 320 512">
                            <path d="M285.5 272H12c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h273.5c4.7 0 9.2-2.7 11.3-7l96-176c3.9-7.1 1-15.8-6.2-19.8l-14.6-8.2c-7.2-4.1-15.9-1-19.8 6.2l-96 176c-2.1 4.3-6.6 7-11.3 7z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('menu.index') }}" class="text-blue-500 hover:text-blue-700">{{__('Options Menu')}}</a>
                        <svg class="fill-current w-3 h-3 mx-3" viewBox="0 0 320 512">
                            <path d="M285.5 272H12c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h273.5c4.7 0 9.2-2.7 11.3-7l96-176c3.9-7.1 1-15.8-6.2-19.8l-14.6-8.2c-7.2-4.1-15.9-1-19.8 6.2l-96 176c-2.1 4.3-6.6 7-11.3 7z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('table.gestionar') }}" class="text-blue-500 hover:text-blue-700">{{__('Manage Tables')}}</a>
                        <svg class="fill-current w-3 h-3 mx-3" viewBox="0 0 320 512">
                            <path d="M285.5 272H12c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h273.5c4.7 0 9.2-2.7 11.3-7l96-176c3.9-7.1 1-15.8-6.2-19.8l-14.6-8.2c-7.2-4.1-15.9-1-19.8 6.2l-96 176c-2.1 4.3-6.6 7-11.3 7z" />
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <span class="text-gray-700">{{__('View Table')}}: {{ ucfirst(str_replace('_', ' ', $table)) }}</span>
                    </li>
                </ol>
            </nav>
            <!-- Fin de migas de pan -->

            <div class="mb-4">
                <h3 class="text-xl font-semibold text-gray-900 uppercase">{{ str_replace('_', ' ', $table) }}</h3>
            </div>
            @if ($data->isEmpty())
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                {{__('No records available to show.')}}
            </div>
            @else
            <form method="GET" action="{{ route('table.view', ['table' => $table]) }}">
                <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach (array_keys((array) $data->first()) as $column)
                    @if ($column != 'id')
                    <div>
                        <label for="{{ $column }}" class="block text-sm font-medium text-gray-700">{{ $column == 'id_propietario' ? __('Owner') : $column }}</label>
                        <input type="text" name="{{ $column }}" id="{{ $column }}" value="{{ $filters[$column] ?? '' }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="{{ __('Filter') }} {{ $column }}">
                    </div>
                    @endif
                    @endforeach
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="px-4 py-2 bg-indigo-500 text-white hover:bg-indigo-700 transition duration-300 rounded">{{__('Filter')}}</button>
                        <a href="{{ route('table.view', ['table' => $table]) }}" class="px-4 py-2 bg-gray-500 text-white hover:bg-gray-700 transition duration-300 rounded">{{__('Reset')}}</a>
                    </div>
                </div>
            </form><br>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-auto border">
                    <thead class="bg-gray-100">
                        <tr>
                            @foreach (array_keys((array) $data->first()) as $column)
                            @if ($column != 'id')
                            <th scope="col" class="px-2 py-2 text-center text-xs font-medium text-gray-900 uppercase tracking-wider">
                                {{ $column == 'id_propietario' ? __('Owner') : $column }}
                                <a href="{{ route('table.view', ['table' => $table, 'sort_field' => $column, 'sort_order' => ($sortField == $column && $sortOrder == 'asc') ? 'desc' : 'asc'] + request()->except(['sort_field', 'sort_order', 'page'])) }}">
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
                        @foreach ($data as $index => $row)
                        <tr class="{{ $index % 2 == 0 ? 'bg-indigo-100' : '' }} text-center">
                            @foreach ($row as $key => $value)
                            @if ($key != 'id')
                            <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-600">
                                @if ($key == 'owner_id')
                                @php
                                $owner = $owners[$value];
                                @endphp
                                <div class="flex items-center">
                                    {{ $owner->name }}#{{ $value }}
                                    @if ($owner->profile_photo_path)
                                        <img src="{{ asset('storage/' . $owner->profile_photo_path) }}" alt="Profile Photo" class="ml-2 mr-1 w-10 h-10 rounded-full border">
                                    @endif
                                </div>
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
                <div class="mt-4">
                    {{ $data->links() }}
                </div>
            </div>
            @endif
            <div class="mt-4 text-left">
                <a href="{{ route('table.export.excel', ['table' => $table] + request()->except(['page'])) }}" class="inline-flex items-center px-4 py-2 bg-green-200 text-green-600 hover:bg-green-300 transition duration-150 rounded-md">
                    {{__('Export to Excel')}}
                </a>
                <a href="{{ route('table.export.csv', ['table' => $table] + request()->except(['page'])) }}" class="inline-flex items-center px-4 py-2 bg-yellow-200 text-yellow-600 hover:bg-yellow-300 transition duration-150 rounded-md">
                    {{__('Export to CSV')}}
                </a>
                <a href="{{ route('table.export.pdf', ['table' => $table] + request()->except(['page'])) }}" class="inline-flex items-center px-4 py-2 bg-red-200 text-red-600 hover:bg-red-300 transition duration-150 rounded-md">
                    {{__('Export to PDF')}}
                </a>
            </div>
            <div class="mt-4 text-right">
                <a href="{{ route('table.gestionar') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                    {{__('Back')}}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

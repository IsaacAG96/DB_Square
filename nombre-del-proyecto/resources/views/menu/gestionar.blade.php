<x-app-layout>
    <div class="flex flex-col min-h-screen">
        <div class="container mt-5 flex-grow">
            <div class="bg-white shadow-md rounded-lg p-6 lg:p-8 mx-auto w-full max-w-7xl">
                <!-- Breadcrumbs -->
                <nav class="mb-4 text-sm text-gray-700" aria-label="Breadcrumb">
                    <ol class="list-none p-0 inline-flex">
                        <li class="flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">{{ __('Home') }}</a>
                            <svg class="fill-current w-3 h-3 mx-3" viewBox="0 0 320 512">
                                <path d="M285.5 272H12c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h273.5c4.7 0 9.2-2.7 11.3-7l96-176c3.9-7.1 1-15.8-6.2-19.8l-14.6-8.2c-7.2-4.1-15.9-1-19.8 6.2l-96 176c-2.1 4.3-6.6 7-11.3 7z" />
                            </svg>
                        </li>
                        <li class="flex items-center">
                            <a href="{{ route('menu.index') }}" class="text-blue-500 hover:text-blue-700">{{ __('Options Menu') }}</a>
                            <svg class="fill-current w-3 h-3 mx-3" viewBox="0 0 320 512">
                                <path d="M285.5 272H12c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h273.5c4.7 0 9.2-2.7 11.3-7l96-176c3.9-7.1 1-15.8-6.2-19.8l-14.6-8.2c-7.2-4.1-15.9-1-19.8 6.2l-96 176c-2.1 4.3-6.6 7-11.3 7z" />
                            </svg>
                        </li>
                        <li class="flex items-center">
                            <span class="text-gray-700">{{ __('Table List') }}</span>
                        </li>
                    </ol>
                </nav>
                <!-- End of Breadcrumbs -->

                <div class="mb-4">
                    <h3 class="text-2xl font-semibold text-gray-900">{{ __('Table List') }}</h3>
                </div>
                <div class="card-body">
                    @if ($tables->isEmpty())
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                        {{ __('There are no tables available to display.') }}
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Table Name') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($tables as $table)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-extrabold text-gray-800 text-sm uppercase flex items-center">
                                        @if($table == 'accounts_list')
                                        <img src="{{ asset('images/icons/accounts_list.png') }}" class="w-10 h-10 mr-2" alt="Accounts List">
                                        @elseif($table == 'contacts')
                                        <img src="{{ asset('images/icons/contacts.png') }}" class="w-10 h-10 mr-2" alt="Contacts">
                                        @elseif($table == 'disc_collection')
                                        <img src="{{ asset('images/icons/disc_collection.png') }}" class="w-10 h-10 mr-2" alt="Disc Collection">
                                        @elseif($table == 'program_list')
                                        <img src="{{ asset('images/icons/program_list.png') }}" class="w-10 h-10 mr-2" alt="Program List">
                                        @elseif($table == 'shopping_list')
                                        <img src="{{ asset('images/icons/shopping_list.png') }}" class="w-10 h-10 mr-2" alt="Program List">
                                        @elseif($table == 'travel_collection')
                                        <img src="{{ asset('images/icons/travel_collection.png') }}" class="w-10 h-10 mr-2" alt="Program List">
                                        @else
                                        {{ str_replace('_', ' ', $table) }}
                                        @endif
                                        {{ str_replace('_', ' ', $table) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                        <a href="{{ route('table.view', ['table' => $table]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-200 text-indigo-600 hover:bg-indigo-300 transition duration-150 rounded-md">{{ __('View') }}</a>
                                        <a href="{{ route('table.edit', ['table' => $table]) }}" class="inline-flex items-center px-4 py-2 bg-yellow-200 text-yellow-600 hover:bg-yellow-300 transition duration-150 rounded-md">{{ __('Edit') }}</a>
                                        <a href="{{ route('table.share', ['table' => $table]) }}" class="inline-flex items-center px-4 py-2 bg-green-200 text-green-600 hover:bg-green-300 transition duration-150 rounded-md">{{ __('Share') }}</a>
                                        <form action="{{ route('table.delete', ['table' => $table]) }}" method="POST" class="delete-form" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-200 text-red-600 hover:bg-red-300 transition duration-150 rounded-md">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Add pagination -->
                    <div class="mt-4">
                        {{ $tables->links('vendor.pagination.bootstrap-4') }}
                    </div>
                    @endif
                </div>

                <!-- Custom Tables Section -->
                <div class="mb-4">
                    <h3 class="text-2xl font-semibold text-gray-900">{{ __('Custom Tables') }}</h3>
                </div>
                <div class="card-body">
                    @if (empty($customTables))
                    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                        {{ __('There are no custom tables available to display.') }}
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Table Name') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($customTables as $table)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-extrabold text-gray-800 text-sm uppercase">
                                        {{ str_replace('_', ' ', \Illuminate\Support\Str::beforeLast($table, '_')) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap space-x-2">
                                        <a href="{{ route('table.view', ['table' => $table]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-200 text-indigo-600 hover:bg-indigo-300 transition duration-150 rounded-md">{{ __('View') }}</a>
                                        <a href="{{ route('table.edit', ['table' => $table]) }}" class="inline-flex items-center px-4 py-2 bg-yellow-200 text-yellow-600 hover:bg-yellow-300 transition duration-150 rounded-md">{{ __('Edit') }}</a>
                                        <form action="{{ route('table.custom-delete', ['table' => $table]) }}" method="POST" class="delete-form" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-200 text-red-600 hover:bg-red-300 transition duration-150 rounded-md">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>

                <div class="mt-4 text-right">
                    <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        {{ __('Back to Menu') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="delete-modal" class="hidden fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            {{ __('Confirm Deletion') }}
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ __('Are you sure you want to delete this table and all its records?') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                    <button id="confirm-delete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __('Delete') }}
                    </button>
                    <button id="cancel-delete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        {{ __('Cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Add Font Awesome script -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Confirmation script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForms = document.querySelectorAll('.delete-form');
        const deleteModal = document.getElementById('delete-modal');
        const confirmDeleteButton = document.getElementById('confirm-delete');
        const cancelDeleteButton = document.getElementById('cancel-delete');
        let formToSubmit;

        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                formToSubmit = form;
                deleteModal.classList.remove('hidden');
            });
        });

        confirmDeleteButton.addEventListener('click', function() {
            formToSubmit.submit();
        });

        cancelDeleteButton.addEventListener('click', function() {
            deleteModal.classList.add('hidden');
        });
    });
</script>

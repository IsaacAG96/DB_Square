<x-app-layout>
    <div class="container mt-5 flex-grow">
        <div class="flex justify-center">
            <div class="p-6 lg:p-8 grid grid-cols-1 gap-6 mt-6 w-full max-w-7xl">
                <div class="bg-white shadow-md rounded-lg p-4 lg:p-10 mx-auto w-full">
                    <!-- Breadcrumbs -->
                    <nav class="mb-4 text-sm text-gray-700" aria-label="Breadcrumb">
                        <ol class="list-none p-0 inline-flex">
                            <li class="flex items-center">
                                <a href="{{ route('dashboard') }}" class="text-blue-500 hover:text-blue-700">{{ __('Home') }}</a>
                                <svg class="fill-current w-3 h-3 mx-3" viewBox="0 0 320 512">
                                    <path d="M285.5 272H12c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h273.5c4.7 0 9.2-2.7 11.3-7l96-176c3.9-7.1 1-15.8-6.2-19.8l-14.6-8.2c-7.2-4.1-15.9-1-19.8 6.2l-96 176c-2.1 4.3-6.6 7-11.3 7z"/>
                                </svg>
                            </li>
                            <li class="flex items-center">
                                <a href="{{ route('menu.index') }}" class="text-blue-500 hover:text-blue-700">{{ __('Menu Options') }}</a>
                                <svg class="fill-current w-3 h-3 mx-3" viewBox="0 0 320 512">
                                    <path d="M285.5 272H12c-6.6 0-12-5.4-12-12v-8c0-6.6 5.4-12 12-12h273.5c4.7 0 9.2-2.7 11.3-7l96-176c3.9-7.1 1-15.8-6.2-19.8l-14.6-8.2c-7.2-4.1-15.9-1-19.8 6.2l-96 176c-2.1 4.3-6.6 7-11.3 7z"/>
                                </svg>
                            </li>
                            <li class="flex items-center">
                                <span class="text-gray-700">{{ __('Create Table') }}</span>
                            </li>
                        </ol>
                    </nav>
                    <!-- End Breadcrumbs -->

                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">{{ __('Create Table') }}</h3>
                    
                    <!-- Display success message -->
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Display error message -->
                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Form to create table -->
                    <form action="{{ route('menu.store') }}" method="POST" id="createTableForm">
                        @csrf
                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700">{{ __('Table Name') }}</label>
                            <input type="text" id="nombre" name="nombre" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                        </div>
                        <div class="mb-4 flex items-center">
                            <label for="numCampos" class="block text-sm font-medium text-gray-700 mr-3">{{ __('Number of Fields') }}</label>
                            <select id="numCampos" name="numCampos" class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                @for ($i = 1; $i <= 7; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div id="fieldsContainer"></div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 transition duration-150 rounded-md">
                            {{ __('Create') }}
                        </button>
                        <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white hover:bg-gray-700 transition duration-150 rounded-md">
                            {{ __('Back') }}
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('numCampos').addEventListener('change', function () {
            const numCampos = this.value;
            const fieldsContainer = document.getElementById('fieldsContainer');
            fieldsContainer.innerHTML = ''; // Clear previous fields

            for (let i = 0; i < numCampos; i++) {
                const fieldSet = document.createElement('div');
                fieldSet.className = 'mb-4';

                const fieldTitle = document.createElement('h4');
                fieldTitle.className = 'text-lg font-semibold text-gray-700 mb-2';
                fieldTitle.textContent = `Field ${i + 1}:`;
                fieldSet.appendChild(fieldTitle);

                const fieldNameLabel = document.createElement('label');
                fieldNameLabel.className = 'block text-sm font-medium text-gray-700';
                fieldNameLabel.textContent = `{{ __('Name:') }}`;
                fieldSet.appendChild(fieldNameLabel);

                const fieldNameInput = document.createElement('input');
                fieldNameInput.type = 'text';
                fieldNameInput.name = `field_name_${i}`;
                fieldNameInput.className = 'mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md';
                fieldSet.appendChild(fieldNameInput);

                const fieldTypeLabel = document.createElement('label');
                fieldTypeLabel.className = 'block text-sm font-medium text-gray-700 mt-4';
                fieldTypeLabel.textContent = `{{ __('Type:') }}`;
                fieldSet.appendChild(fieldTypeLabel);

                const fieldTypeSelect = document.createElement('select');
                fieldTypeSelect.name = `field_type_${i}`;
                fieldTypeSelect.className = 'mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md';
                const fieldTypes = ['integer', 'boolean', 'string', 'float', 'date', 'datetime'];
                fieldTypes.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type;
                    option.textContent = type.charAt(0).toUpperCase() + type.slice(1);
                    fieldTypeSelect.appendChild(option);
                });
                fieldSet.appendChild(fieldTypeSelect);

                const nullableLabel = document.createElement('label');
                nullableLabel.className = 'block text-sm font-medium text-gray-700 mt-4';
                nullableLabel.textContent = `{{ __('Nullable:') }}`;
                fieldSet.appendChild(nullableLabel);

                const nullableCheckbox = document.createElement('input');
                nullableCheckbox.type = 'checkbox';
                nullableCheckbox.name = `field_nullable_${i}`;
                nullableCheckbox.className = 'mt-1';
                fieldSet.appendChild(nullableCheckbox);

                fieldsContainer.appendChild(fieldSet);
            }
        });

        // Trigger the change event to initialize the form with one field by default
        document.getElementById('numCampos').dispatchEvent(new Event('change'));
    </script>
</x-app-layout>

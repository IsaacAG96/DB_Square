<!-- resources/views/table/create.blade.php -->

<x-app-layout>
    <div class="container mt-5">
        <div class="bg-white shadow-md rounded-lg p-6 mx-auto w-full max-w-7xl">
            <h3 class="text-2xl font-semibold text-gray-900 mb-4">Añadir nuevo registro a {{ str_replace('_', ' ', $table) }}</h3>
            
            @if ($errors->any())
                <div class="mb-4">
                    <div class="text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            
            <form method="POST" action="{{ route('table.store', ['table' => $table]) }}" id="createForm">
                @csrf
                @foreach ($columnsInfo as $column => $isNullable)
                    <div class="mb-4">
                        <label for="{{ $column }}" class="block text-sm font-medium text-gray-700">
                            {{ ucwords(str_replace('_', ' ', $column)) }}
                            @if (!$isNullable)
                                <span class="text-red-500">*</span>
                            @endif
                        </label>
                        <input type="text" name="{{ $column }}" id="{{ $column }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error($column) border-red-500 @enderror" value="{{ old($column) }}" @if (!$isNullable) required @endif>
                        @error($column)
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                @endforeach
                <div class="mb-4 flex justify-between">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Guardar</button>
                    <a href="{{ route('table.gestionar') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Volver</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('createForm').addEventListener('submit', function(event) {
            let formIsValid = true;
            const requiredFields = document.querySelectorAll('#createForm [required]');

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    formIsValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            if (!formIsValid) {
                event.preventDefault();
                alert('Por favor, rellena todos los campos obligatorios.');
            }
        });
    </script>
</x-app-layout>

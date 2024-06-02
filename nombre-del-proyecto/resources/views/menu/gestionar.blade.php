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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($tables as $table)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-extrabold text-gray-800 text-base uppercase">{{ str_replace('_', ' ', $table) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                        <a href="{{ route('table.view', ['table' => $table]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-200 text-indigo-600 hover:bg-indigo-300 transition duration-150 rounded-md">Ver</a>
                                        <a href="{{ route('table.edit', ['table' => $table]) }}" class="inline-flex items-center px-4 py-2 bg-yellow-200 text-yellow-600 hover:bg-yellow-300 transition duration-150 rounded-md">Editar</a>
                                        <a href="{{ route('table.share', ['table' => $table]) }}" class="inline-flex items-center px-4 py-2 bg-green-200 text-green-600 hover:bg-green-300 transition duration-150 rounded-md">Compartir</a>
                                        <form action="{{ route('table.delete', ['table' => $table]) }}" method="POST" class="delete-form" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-200 text-red-600 hover:bg-red-300 transition duration-150 rounded-md">Eliminar</button>
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

    <!-- Modal de confirmación -->
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
                            Confirmar Eliminación
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                ¿Estás seguro de que deseas eliminar esta tabla y todos sus registros?
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                    <button id="confirm-delete" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Eliminar
                    </button>
                    <button id="cancel-delete" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Añadir el script para Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Script de confirmación -->
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
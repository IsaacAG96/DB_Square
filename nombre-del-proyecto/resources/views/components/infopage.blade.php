<div class="p-6 lg:p-8 bg-white border-b border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-application-logo class="block h-24 w-auto" />
        <h1 class="mt-8 text-2xl font-medium text-gray-900">
            ¡Bienvenido al Panel de Control del Administrador!
        </h1>
        <p class="mt-6 text-gray-500 leading-relaxed">
            Gestiona y supervisa todas las actividades de la aplicación desde aquí.
        </p>
    </div>
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
    <!-- Resumen de la Actividad -->
    <div>
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ms-1 w-5 h-5 fill-indigo-500">
                <path fill="#d3d3d3" d="m4 22a2.982 2.982 0 0 1 -2.122-.879l-1.544-1.374a1 1 0 0 1 1.332-1.494l1.585 1.414a1 1 0 0 0 1.456.04l3.6-3.431a1 1 0 1 1 1.378 1.448l-3.585 3.414a2.964 2.964 0 0 1 -2.1.862zm19-1h-10a1 1 0 0 1 0-2h10a1 1 0 0 1 0 2zm-19-7a2.982 2.982 0 0 1 -2.122-.879l-1.585-1.585a1 1 0 0 1 1.414-1.414l1.586 1.585a1.023 1.023 0 0 0 1.414 0l3.6-3.431a1 1 0 1 1 1.382 1.448l-3.589 3.414a2.964 2.964 0 0 1 -2.1.862zm19-1h-10a1 1 0 0 1 0-2h10a1 1 0 0 1 0 2zm-19-7a2.982 2.982 0 0 1 -2.122-.879l-1.544-1.374a1 1 0 0 1 1.332-1.494l1.585 1.414a1 1 0 0 0 1.456.04l3.604-3.431a1 1 0 0 1 1.378 1.448l-3.589 3.414a2.964 2.964 0 0 1 -2.1.862zm19-1h-10a1 1 0 0 1 0-2h10a1 1 0 0 1 0 2z" />
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                Resumen de la Actividad
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            Visión general de las actividades recientes, incluyendo el número de usuarios, ventas y visitas.
        </p>

        <p class="mt-4 text-sm">
            <button onclick="openModal('modal-actividad')" class="inline-flex items-center font-semibold text-indigo-700">
                Mostrar más

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </p>
    </div>

    <!-- Gestión de Contenidos -->
    <div>
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ms-1 w-5 h-5">
            <path fill="#d3d3d3" d="m12,12h4.242l6.879-6.879c1.17-1.17,1.17-3.072,0-4.242s-3.072-1.17-4.242,0l-6.879,6.879v4.242Zm2-3.414l6.293-6.293c.391-.391,1.023-.391,1.414,0s.39,1.024,0,1.414l-6.293,6.293h-1.414v-1.414Zm6,8.414v-5.93l-2,2v3.93h-8v3.5c0,.827-.673,1.5-1.5,1.5s-1.5-.673-1.5-1.5V3.5c0-.539-.133-1.044-.351-1.5h8.281L16.89.039c-.13-.015-.257-.039-.39-.039H3.5C1.57,0,0,1.57,0,3.5v3.5h5v13.5c0,1.93,1.57,3.5,3.5,3.5h12c1.93,0,3.5-1.57,3.5-3.5v-3.5h-4ZM5,5h-3v-1.5c0-.827.673-1.5,1.5-1.5s1.5.673,1.5,1.5v1.5Zm17,15.5c0,.827-.673,1.5-1.5,1.5h-8.838c.217-.455.338-.964.338-1.5v-1.5h10v1.5Z"/>
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                Gestión de Contenidos
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            Supervisa y administra el contenido del sitio, incluyendo publicaciones, comentarios y más.
        </p>

        <p class="mt-4 text-sm">
            <button onclick="openModal('modal-contenidos')" class="inline-flex items-center font-semibold text-indigo-700">
                Mostrar más

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </p>
    </div>
   
</div>

<!-- Modal Templates -->
<!-- Modal Resumen de la Actividad -->
<div id="modal-actividad" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <img src="{{ asset('images/actividad.png') }}" alt="Icono de Resumen de Actividad" class="h-6 w-6">
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Resumen de la Actividad</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Visión general de las actividades recientes en la aplicación.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('modal-actividad')">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Gestión de Contenidos -->
<div id="modal-contenidos" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <img src="{{ asset('images/contenidos.png') }}" alt="Icono de Gestión de Contenidos" class="h-6 w-6">
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Gestión de Contenidos</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Administra el contenido del sitio, incluyendo publicaciones y comentarios.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('modal-contenidos')">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>
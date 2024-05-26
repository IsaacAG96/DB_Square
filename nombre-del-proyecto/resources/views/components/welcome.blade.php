<div class="p-6 lg:p-8 bg-white border-b border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-application-logo class="block h-24 w-auto" />
        <h1 class="mt-8 text-2xl font-medium text-gray-900">
            ¡Bienvenido a DB SQUARE!
        </h1>
        <p class="mt-6 text-gray-500 leading-relaxed">
            Tu solución integral para la creación y gestión de tablas.
        </p>
    </div>
    <div class="flex items-center justify-center md:justify-center">
        <a href="{{ route('register') }}" class="bg-indigo-600 text-white font-bold py-4 px-16 rounded-lg text-xl hover:bg-indigo-700 transition duration-300">
            Registrarse
        </a>
    </div>
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
    <div>
        <div class="flex items-center">
            <img src="{{ asset('images/crear.png') }}" alt="Icono de Creación de Tablas" class="w-6 h-6">
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                Creación de Tablas Simplificada
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            Crea tablas de manera rápida y sencilla con nuestra intuitiva interfaz. Define nombres de columnas, tipos de datos, claves primarias y más con solo unos clics, permitiéndote estructurar tus datos de forma eficiente.
        </p>

        <p class="mt-4 text-sm">
            <button onclick="openModal('modal-crear')" class="inline-flex items-center font-semibold text-indigo-700">
                Mostrar más

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <img src="{{ asset('images/editar.png') }}" alt="Icono de Creación de Tablas" class="w-6 h-6">
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                Gestión Integral de Tablas
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            Gestiona tus tablas con total control y flexibilidad. Realiza operaciones CRUD (Crear, Leer, Actualizar, Eliminar) de forma eficiente y mantén la integridad de tus datos con nuestras herramientas avanzadas de gestión.
        </p>

        <p class="mt-4 text-sm">
            <button onclick="openModal('modal-gestionar')" class="inline-flex items-center font-semibold text-indigo-700">
                Mostrar más

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <img src="{{ asset('images/guardar.png') }}" alt="Icono de Creación de Tablas" class="w-6 h-6">
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                Sincronización en Tiempo Real
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            Mantén todos tus datos actualizados en tiempo real. Nuestra tecnología de sincronización asegura que cualquier cambio realizado se refleje instantáneamente en todos tus dispositivos, permitiéndote trabajar sin interrupciones.
        </p>

        <p class="mt-4 text-sm">
            <button onclick="openModal('modal-sincronizar')" class="inline-flex items-center font-semibold text-indigo-700">
                Mostrar más

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <img src="{{ asset('images/compartir.png') }}" alt="Icono de Creación de Tablas" class="w-6 h-6">
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                Compartir Archivos de Forma Segura
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            Comparte tus archivos y tablas de manera segura y eficiente. Controla quién puede ver o editar tus datos con opciones avanzadas de permisos y enlaces protegidos, facilitando la colaboración sin comprometer la seguridad.
        </p>

        <p class="mt-4 text-sm">
            <button onclick="openModal('modal-compartir')" class="inline-flex items-center font-semibold text-indigo-700">
                Mostrar más

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </p>
    </div>
</div>

<!--Modal Creacion de Tablas-->
<div id="modal-crear" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <img src="{{ asset('images/crear.png') }}" alt="Icono de Creación de Tablas" class="h-6 w-6">
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Creación de Tablas Simplificada</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Nuestra interfaz intuitiva te permite crear tablas rápidamente. Define nombres de columnas, tipos de datos, claves primarias y más con solo unos clics. Optimiza tu flujo de trabajo y estructura tus datos de manera eficiente con nuestras herramientas avanzadas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('modal-crear')">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>


<!--Modal Gestion de Tablas-->
<div id="modal-gestionar" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <img src="{{ asset('images/editar.png') }}" alt="Icono de Creación de Tablas" class="h-6 w-6">
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Gestión Integral de Tablas</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Gestiona tus tablas con total control y flexibilidad. Realiza operaciones CRUD (Crear, Leer, Actualizar, Eliminar) de forma eficiente y mantén la integridad de tus datos con nuestras herramientas avanzadas de gestión.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('modal-gestionar')">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<!--Modal Sincronizar-->
<div id="modal-sincronizar" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <img src="{{ asset('images/guardar.png') }}" alt="Icono de Creación de Tablas" class="h-6 w-6">
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Sincronización en Tiempo Real</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Mantén todos tus datos actualizados en tiempo real. Nuestra tecnología de sincronización asegura que cualquier cambio realizado se refleje instantáneamente en todos tus dispositivos, permitiéndote trabajar sin interrupciones.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('modal-sincronizar')">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>


<!--Modal Compartir de Tablas-->
<div id="modal-compartir" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <img src="{{ asset('images/compartir.png') }}" alt="Icono de Creación de Tablas" class="h-6 w-6">
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Compartir Archivos de Forma Segura</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Comparte tus archivos y tablas de manera segura y eficiente. Controla quién puede ver o editar tus datos con opciones avanzadas de permisos y enlaces protegidos, facilitando la colaboración sin comprometer la seguridad.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('modal-compartir')">
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
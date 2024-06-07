<div class="p-6 lg:p-8 bg-white border-b border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <x-application-logo class="block h-24 w-auto" />
        <h1 class="mt-8 text-2xl font-medium text-gray-900">
            {{ __('Welcome to DB SQUARE!') }}
        </h1>
        <p class="mt-6 text-gray-500 leading-relaxed">
            {{ __('Your all-in-one solution for creating and managing tables.') }}
        </p>
    </div>
    <div class="flex items-center justify-center md:justify-center">
        @guest
        <a href="{{ route('register') }}" class="bg-indigo-500 text-white font-bold py-4 px-16 rounded-lg text-xl hover:bg-indigo-700 transition duration-300">
            {{ __('Register') }}
        </a>
        @else
        <a href="{{ route('menu.index') }}" class="bg-indigo-500 text-white font-bold py-4 px-16 rounded-lg text-xl hover:bg-indigo-700 transition duration-300">
            {{ __('Go to Menu') }}
        </a>
        @endguest
    </div>
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
    <div>
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ms-1 w-5 h-5">
                <path fill="#d3d3d3" d="m19,0H5C2.243,0,0,2.243,0,5v14c0,2.757,2.243,5,5,5h14c2.757,0,5-2.243,5-5V5c0-2.757-2.243-5-5-5Zm3,19c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V5c0-1.654,1.346-3,3-3h14c1.654,0,3,1.346,3,3v14Zm-9-3c0,.552-.448,1-1,1h-1c-.552,0-1-.448-1-1s.448-1,1-1h1c.552,0,1,.448,1,1Zm0-8c0,.552-.448,1-1,1h-1c-.552,0-1-.448-1-1s.448-1,1-1h1c.552,0,1,.448,1,1Zm7,8.5c0,1.381-1.119,2.5-2.5,2.5s-2.5-1.119-2.5-2.5,1.119-2.5,2.5-2.5,2.5,1.119,2.5,2.5Zm.47-9.171c.072.197.013.419-.148.554l-1.183.964.489,1.396c.067.202,0,.424-.169.553-.169.129-.4.138-.578.023l-1.377-.897-1.354.906c-.084.056-.181.084-.278.084-.106,0-.211-.033-.3-.1-.17-.127-.241-.348-.177-.55l.47-1.413-1.189-.967c-.16-.136-.218-.357-.146-.553.072-.197.26-.328.469-.328h1.5l.531-1.49c.073-.196.26-.325.469-.325s.396.13.469.325l.531,1.49h1.5c.21,0,.398.131.47.329Zm-13.97,8.671c-.828,0-1.5-.672-1.5-1.5s.672-1.5,1.5-1.5,1.5.672,1.5,1.5-.672,1.5-1.5,1.5Zm-1.5-9.5c0-.828.672-1.5,1.5-1.5s1.5.672,1.5,1.5-.672,1.5-1.5,1.5-1.5-.672-1.5-1.5Zm3.978,4.043c.09.222-.108.457-.375.457h-4.205c-.268,0-.466-.235-.375-.457.366-.899,1.333-1.543,2.478-1.543s2.112.644,2.478,1.543Zm0,8c.09.222-.108.457-.375.457h-4.205c-.268,0-.466-.235-.375-.457.366-.899,1.333-1.543,2.478-1.543s2.112.644,2.478,1.543Z" />
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                {{ __('Simplified Table Creation') }}
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            {{ __('Create tables quickly and easily with our intuitive interface. Define column names, data types, primary keys, and more with just a few clicks, allowing you to structure your data efficiently.') }}
        </p>

        <p class="mt-4 text-sm">
            <button onclick="openModal('modal-crear')" class="inline-flex items-center font-semibold text-indigo-700">
                {{ __('Show more') }}

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ms-1 w-5 h-5">
                <path fill="#d3d3d3" d="M24,18.586c0,1.068-.416,2.072-1.172,2.828l-1.414,1.414c-.755,.756-1.76,1.172-2.828,1.172s-2.073-.416-2.829-1.172l-2.69-2.69c-.391-.391-.391-1.023,0-1.414s1.023-.391,1.414,0l2.69,2.69c.756,.756,2.073,.756,2.829,0l1.414-1.414c.378-.378,.586-.88,.586-1.414s-.208-1.036-.586-1.414l-1.931-1.932-1.415,1.414c-.391,.391-1.023,.391-1.414,0s-.391-1.023,0-1.414l2.122-2.121c.391-.391,1.023-.391,1.414,0l2.638,2.639c.756,.755,1.172,1.759,1.172,2.828ZM3.862,10.933c.195,.195,.451,.293,.707,.293s.512-.098,.707-.293c.391-.391,.391-1.023,0-1.414l-2.69-2.69c-.378-.378-.586-.88-.586-1.414s.208-1.036,.586-1.414l1.414-1.414c.756-.756,2.073-.756,2.829,0l1.932,1.932-1.415,1.414c-.391,.391-.391,1.023,0,1.414s1.023,.391,1.414,0l2.122-2.121c.188-.188,.293-.441,.293-.707s-.105-.52-.293-.707l-2.639-2.639C6.732-.34,4.097-.34,2.586,1.172l-1.414,1.414c-.756,.756-1.172,1.76-1.172,2.828s.416,2.073,1.172,2.828l2.69,2.69ZM22.925,6.269L6.95,22.242c-1.132,1.134-2.639,1.758-4.242,1.758H1c-.552,0-1-.447-1-1v-1.708c0-1.603,.624-3.109,1.757-4.242L17.731,1.075c1.431-1.431,3.761-1.433,5.193,0,1.431,1.432,1.431,3.762,0,5.193Zm-5.2,2.371l-2.365-2.365L3.171,18.464c-.755,.756-1.171,1.76-1.171,2.828v.708h.708c1.069,0,2.073-.416,2.828-1.172l12.19-12.189Zm3.785-6.15c-.652-.652-1.712-.651-2.365,0l-2.371,2.371,2.365,2.365,2.371-2.371c.651-.652,.651-1.713,0-2.365Z" />
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                {{ __('Comprehensive Table Management') }}
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            {{ __('Manage your tables with total control and flexibility. Perform CRUD (Create, Read, Update, Delete) operations efficiently and maintain data integrity with our advanced management tools.') }}
        </p>

        <p class="mt-4 text-sm">
            <button onclick="openModal('modal-gestionar')" class="inline-flex items-center font-semibold text-indigo-700">
                {{ __('Show more') }}

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ms-1 w-5 h-5">
                <path fill="#d3d3d3" d="M.061,10.293h0c.162-1.135,.485-2.239,.962-3.281l2.729,1.248s0,0,0,.001h0c-.357,.78-.599,1.606-.72,2.455h0s0,0,0,0L.061,10.294s0,0,0,0ZM7.074,4.427l-1.624-2.522c-.962,.62-1.83,1.372-2.58,2.238l2.267,1.965c.563-.65,1.215-1.215,1.938-1.68ZM3.75,15.738h0c-.357-.78-.599-1.606-.72-2.455h0s0,0,0,0L.061,13.706s0,0,0,0h0c.162,1.135,.485,2.239,.962,3.281l2.729-1.248s0,0,0-.001Zm1.387,2.154l-2.267,1.965c.75,.866,1.618,1.618,2.58,2.238l1.624-2.522c-.722-.465-1.374-1.03-1.938-1.68ZM12,0c-1.164,0-2.317,.167-3.427,.497l.854,2.875c.833-.247,1.699-.372,2.573-.372,4.962,0,9,4.037,9,9s-4.038,9-9,9c-.875,0-1.74-.125-2.573-.372l-.854,2.875c1.11,.33,2.263,.497,3.427,.497,6.617,0,12-5.383,12-12S18.617,0,12,0Zm1.5,18v-7h4l-4.636-4.531c-.477-.477-1.251-.477-1.728,0l-4.636,4.531h4v7h3Z" />
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                {{ __('Real-time Synchronization') }}
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            {{ __('Keep all your data updated in real-time. Our synchronization technology ensures that any changes made are instantly reflected across all your devices, allowing you to work without interruptions.') }}
        </p>

        <p class="mt-4 text-sm">
            <button onclick="openModal('modal-sincronizar')" class="inline-flex items-center font-semibold text-indigo-700">
                {{ __('Show more') }}

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </p>
    </div>

    <div>
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ms-1 w-5 h-5">
                <path fill="#d3d3d3" d="m21,0H3C1.346,0,0,1.346,0,3v21h24V3c0-1.654-1.346-3-3-3Zm1,22H2V3c0-.551.448-1,1-1h18c.552,0,1,.449,1,1v19Zm-6-12c1.654,0,3-1.346,3-3s-1.346-3-3-3-3,1.346-3,3c0,.17.015.337.042.5l-4.057,2.254c-.529-.468-1.224-.753-1.985-.753-1.654,0-3,1.346-3,3s1.346,3,3,3c.761,0,1.456-.285,1.985-.753l4.057,2.254c-.027.163-.042.329-.042.5,0,1.654,1.346,3,3,3s3-1.346,3-3-1.346-3-3-3c-.761,0-1.456.285-1.985.753l-4.057-2.254c.027-.163.042-.329.042-.5s-.015-.337-.042-.5l4.057-2.254c.529.468,1.224.753,1.985.753Zm0-4c.552,0,1,.449,1,1s-.448,1-1,1-1-.449-1-1,.448-1,1-1Zm-9,7c-.552,0-1-.449-1-1s.448-1,1-1,1,.449,1,1-.448,1-1,1Zm9,3c.552,0,1,.449,1,1s-.448,1-1,1-1-.449-1-1,.448-1,1-1Z" />
            </svg>
            <h2 class="ms-3 text-xl font-semibold text-gray-900">
                {{ __('Secure File Sharing') }}
            </h2>
        </div>

        <p class="mt-4 text-gray-500 text-sm leading-relaxed">
            {{ __('Share your files and tables securely and efficiently. Control who can view or edit your data with advanced permissions and protected links, facilitating collaboration without compromising security.') }}
        </p>

        <p class="mt-4 text-sm">
            <button onclick="openModal('modal-compartir')" class="inline-flex items-center font-semibold text-indigo-700">
                {{ __('Show more') }}

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="ms-1 w-5 h-5 fill-indigo-500">
                    <path fill-rule="evenodd" d="M5 10a.75.75 0 01.75-.75h6.638L10.23 7.29a.75.75 0 111.04-1.08l3.5 3.25a.75.75 0 010 1.08l-3.5 3.25a.75.75 0 11-1.04-1.08l2.158-1.96H5.75A.75.75 0 015 10z" clip-rule="evenodd" />
                </svg>
            </button>
        </p>
    </div>
</div>

<!--Modal Table Creation-->
<div id="modal-crear" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ms-1 w-5 h-5">
                            <path fill="#d3d3d3" d="m19,0H5C2.243,0,0,2.243,0,5v14c0,2.757,2.243,5,5,5h14c2.757,0,5-2.243,5-5V5c0-2.757-2.243-5-5-5Zm3,19c0,1.654-1.346,3-3,3H5c-1.654,0-3-1.346-3-3V5c0-1.654,1.346-3,3-3h14c1.654,0,3,1.346,3,3v14Zm-9-3c0,.552-.448,1-1,1h-1c-.552,0-1-.448-1-1s.448-1,1-1h1c.552,0,1,.448,1,1Zm0-8c0,.552-.448,1-1,1h-1c-.552,0-1-.448-1-1s.448-1,1-1h1c.552,0,1,.448,1,1Zm7,8.5c0,1.381-1.119,2.5-2.5,2.5s-2.5-1.119-2.5-2.5,1.119-2.5,2.5-2.5,2.5,1.119,2.5,2.5Zm.47-9.171c.072.197.013.419-.148.554l-1.183.964.489,1.396c.067.202,0,.424-.169.553-.169.129-.4.138-.578.023l-1.377-.897-1.354.906c-.084.056-.181.084-.278.084-.106,0-.211-.033-.3-.1-.17-.127-.241-.348-.177-.55l.47-1.413-1.189-.967c-.16-.136-.218-.357-.146-.553.072-.197.26-.328.469-.328h1.5l.531-1.49c.073-.196.26-.325.469-.325s.396.13.469.325l.531,1.49h1.5c.21,0,.398.131.47.329Zm-13.97,8.671c-.828,0-1.5-.672-1.5-1.5s.672-1.5,1.5-1.5,1.5.672,1.5,1.5-.672,1.5-1.5,1.5Zm-1.5-9.5c0-.828.672-1.5,1.5-1.5s1.5.672,1.5,1.5-.672,1.5-1.5,1.5-1.5-.672-1.5-1.5Zm3.978,4.043c.09.222-.108.457-.375.457h-4.205c-.268,0-.466-.235-.375-.457.366-.899,1.333-1.543,2.478-1.543s2.112.644,2.478,1.543Zm0,8c.09.222-.108.457-.375.457h-4.205c-.268,0-.466-.235-.375-.457.366-.899,1.333-1.543,2.478-1.543s2.112.644,2.478,1.543Z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">{{ __('Simplified Table Creation') }}</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ __('Our intuitive interface allows you to create tables quickly. Define column names, data types, primary keys, and more with just a few clicks. Optimize your workflow and structure your data efficiently with our advanced tools.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('modal-crear')">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>


<!--Modal Table Management-->
<div id="modal-gestionar" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ms-1 w-5 h-5">
                            <path fill="#d3d3d3" d="M24,18.586c0,1.068-.416,2.072-1.172,2.828l-1.414,1.414c-.755,.756-1.76,1.172-2.828,1.172s-2.073-.416-2.829-1.172l-2.69-2.69c-.391-.391-.391-1.023,0-1.414s1.023-.391,1.414,0l2.69,2.69c.756,.756,2.073,.756,2.829,0l1.414-1.414c.378-.378,.586-.88,.586-1.414s-.208-1.036-.586-1.414l-1.931-1.932-1.415,1.414c-.391,.391-1.023,.391-1.414,0s-.391-1.023,0-1.414l2.122-2.121c.391-.391,1.023-.391,1.414,0l2.638,2.639c.756,.755,1.172,1.759,1.172,2.828ZM3.862,10.933c.195,.195,.451,.293,.707,.293s.512-.098,.707-.293c.391-.391,.391-1.023,0-1.414l-2.69-2.69c-.378-.378-.586-.88-.586-1.414s.208-1.036,.586-1.414l1.414-1.414c.756-.756,2.073-.756,2.829,0l1.932,1.932-1.415,1.414c-.391,.391-.391,1.023,0,1.414s1.023,.391,1.414,0l2.122-2.121c.188-.188,.293-.441,.293-.707s-.105-.52-.293-.707l-2.639-2.639C6.732-.34,4.097-.34,2.586,1.172l-1.414,1.414c-.756,.756-1.172,1.76-1.172,2.828s.416,2.073,1.172,2.828l2.69,2.69ZM22.925,6.269L6.95,22.242c-1.132,1.134-2.639,1.758-4.242,1.758H1c-.552,0-1-.447-1-1v-1.708c0-1.603,.624-3.109,1.757-4.242L17.731,1.075c1.431-1.431,3.761-1.433,5.193,0,1.431,1.432,1.431,3.762,0,5.193Zm-5.2,2.371l-2.365-2.365L3.171,18.464c-.755,.756-1.171,1.76-1.171,2.828v.708h.708c1.069,0,2.073-.416,2.828-1.172l12.19-12.189Zm3.785-6.15c-.652-.652-1.712-.651-2.365,0l-2.371,2.371,2.365,2.365,2.371-2.371c.651-.652,.651-1.713,0-2.365Z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">{{ __('Comprehensive Table Management') }}</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ __('Manage your tables with total control and flexibility. Perform CRUD (Create, Read, Update, Delete) operations efficiently and maintain data integrity with our advanced management tools.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('modal-gestionar')">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>

<!--Modal Synchronization-->
<div id="modal-sincronizar" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ms-1 w-5 h-5">
                            <path fill="#d3d3d3" d="M.061,10.293h0c.162-1.135,.485-2.239,.962-3.281l2.729,1.248s0,0,0,.001h0c-.357,.78-.599,1.606-.72,2.455h0s0,0,0,0L.061,10.294s0,0,0,0ZM7.074,4.427l-1.624-2.522c-.962,.62-1.83,1.372-2.58,2.238l2.267,1.965c.563-.65,1.215-1.215,1.938-1.68ZM3.75,15.738h0c-.357-.78-.599-1.606-.72-2.455h0s0,0,0,0L.061,13.706s0,0,0,0h0c.162,1.135,.485,2.239,.962,3.281l2.729-1.248s0,0,0-.001Zm1.387,2.154l-2.267,1.965c.75,.866,1.618,1.618,2.58,2.238l1.624-2.522c-.722-.465-1.374-1.03-1.938-1.68ZM12,0c-1.164,0-2.317,.167-3.427,.497l.854,2.875c.833-.247,1.699-.372,2.573-.372,4.962,0,9,4.037,9,9s-4.038,9-9,9c-.875,0-1.74-.125-2.573-.372l-.854,2.875c1.11,.33,2.263,.497,3.427,.497,6.617,0,12-5.383,12-12S18.617,0,12,0Zm1.5,18v-7h4l-4.636-4.531c-.477-.477-1.251-.477-1.728,0l-4.636,4.531h4v7h3Z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">{{ __('Real-time Synchronization') }}</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ __('Keep all your data updated in real-time. Our synchronization technology ensures that any changes made are instantly reflected across all your devices, allowing you to work without interruptions.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('modal-sincronizar')">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>


<!--Modal Secure Sharing-->
<div id="modal-compartir" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ms-1 w-5 h-5">
                            <path fill="#d3d3d3" d="m21,0H3C1.346,0,0,1.346,0,3v21h24V3c0-1.654-1.346-3-3-3Zm1,22H2V3c0-.551.448-1,1-1h18c.552,0,1,.449,1,1v19Zm-6-12c1.654,0,3-1.346,3-3s-1.346-3-3-3-3,1.346-3,3c0,.17.015.337.042.5l-4.057,2.254c-.529-.468-1.224-.753-1.985-.753-1.654,0-3,1.346-3,3s1.346,3,3,3c.761,0,1.456-.285,1.985-.753l4.057,2.254c-.027.163-.042.329-.042.5,0,1.654,1.346,3,3,3s3-1.346,3-3-1.346-3-3-3c-.761,0-1.456.285-1.985.753l-4.057-2.254c.027-.163.042-.329.042-.5s-.015-.337-.042-.5l4.057-2.254c.529.468,1.224.753,1.985.753Zm0-4c.552,0,1,.449,1,1s-.448,1-1,1-1-.449-1-1,.448-1,1-1Zm-9,7c-.552,0-1-.449-1-1s.448-1,1-1,1,.449,1,1-.448,1-1,1Zm9,3c.552,0,1,.449,1,1s-.448,1-1,1-1-.449-1-1,.448-1,1-1Z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">{{ __('Secure File Sharing') }}</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                {{ __('Share your files and tables securely and efficiently. Control who can view or edit your data with advanced permissions and protected links, facilitating collaboration without compromising security.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('modal-compartir')">
                    {{ __('Close') }}
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

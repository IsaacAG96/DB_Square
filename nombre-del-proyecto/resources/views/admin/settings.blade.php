<x-app-layout>
    <div class="flex flex-col min-h-screen">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Home') }}
            </h2>
        </x-slot>
        <div class="flex-grow">
            <div class="py-12">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="container mx-auto px-4 py-8">
                            <div class="flex items-center pb-6">
                                <h1 class="ms-3 text-2xl font-semibold text-gray-900">{{ __('Admin Settings') }}</h1>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="ms-1 pl-1 w-5 h-5">
                                    <path fill="#d3d3d3" d="m12,12h4.242l6.879-6.879c1.17-1.17,1.17-3.072,0-4.242s-3.072-1.17-4.242,0l-6.879,6.879v4.242Zm2-3.414l6.293-6.293c.391-.391,1.023-.391,1.414,0s.39,1.024,0,1.414l-6.293,6.293h-1.414v-1.414Zm6,8.414v-5.93l-2,2v3.93h-8v3.5c0,.827-.673,1.5-1.5,1.5s-1.5-.673-1.5-1.5V3.5c0-.539-.133-1.044-.351-1.5h8.281L16.89.039c-.13-.015-.257-.039-.39-.039H3.5C1.57,0,0,1.57,0,3.5v3.5h5v13.5c0,1.93,1.57,3.5,3.5,3.5h12c1.93,0,3.5-1.57,3.5-3.5v-3.5h-4ZM5,5h-3v-1.5c0-.827.673-1.5,1.5-1.5s1.5.673,1.5,1.5v1.5Zm17,15.5c0,.827-.673,1.5-1.5,1.5h-8.838c.217-.455.338-.964.338-1.5v-1.5h10v1.5Z" />
                                </svg>
                            </div>
                            <div class="bg-white shadow rounded-lg p-6">
                                <h2 class="text-l font-semibold text-gray-700 mb-8 uppercase">{{ __('User Management') }}</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">{{ __('Users') }}</h3>
                                        <p class="text-gray-600">{{ __('View, edit, and delete platform users.') }}</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            {{ __('Manage Users') }}
                                        </a>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">{{ __('Roles and Permissions') }}</h3>
                                        <p class="text-gray-600">{{ __('Configure user roles and permissions.') }}</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            {{ __('Manage Roles') }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white shadow rounded-lg p-6 mt-8">
                                <h2 class="text-l font-semibold text-gray-700 mb-8 uppercase">{{ __('System Settings') }}</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">{{ __('General Settings') }}</h3>
                                        <p class="text-gray-600">{{ __('Adjust general system settings.') }}</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            {{ __('General Settings') }}
                                        </a>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">{{ __('Notification Preferences') }}</h3>
                                        <p class="text-gray-600">{{ __('Configure how you want to receive notifications.') }}</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            {{ __('Notification Settings') }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white shadow rounded-lg p-6 mt-8">
                                <h2 class="text-l font-semibold text-gray-700 mb-8 uppercase">{{ __('Profile Settings') }}</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">{{ __('Profile Information') }}</h3>
                                        <p class="text-gray-600">{{ __('Update your personal information and profile details.') }}</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            {{ __('Edit Profile') }}
                                        </a>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-500">{{ __('Security') }}</h3>
                                        <p class="text-gray-600">{{ __('Manage your account security including passwords and two-factor authentication.') }}</p>
                                        <a href="#" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo transition ease-in-out duration-150">
                                            {{ __('Security Settings') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
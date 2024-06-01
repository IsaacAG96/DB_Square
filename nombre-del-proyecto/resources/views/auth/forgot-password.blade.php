<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}" id="password-reset-form">
            @csrf

            <div>
                <x-label for="email" value="{{ ('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ ('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>

        <!-- Mensaje de confirmación -->
        <div id="confirmation-message" style="display:none; margin-top: 1rem; color: green;">
            Se ha mandado el correo. Por favor, comprueba tu correo electrónico.
        </div>
    </x-authentication-card>

    <!-- Script para manejar el envío del formulario -->
    <script>
        document.getElementById('password-reset-form').addEventListener('submit', function(event) {
            // Aquí puedes hacer cualquier validación adicional si es necesario
            // Una vez que se envíe el formulario, mostramos el mensaje de confirmación
            event.preventDefault();
            document.getElementById('confirmation-message').style.display = 'block';
            // Luego de mostrar el mensaje, enviamos el formulario
            this.submit();
        });
    </script>
</x-guest-layout>
<head>
<title>Pobles de Catalunya</title>

<link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
</head>
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <div style="text-align: center; color: white; background-color: red; border-radius: 10px; padding: 7rem; font-size: 28px; display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column;">
                <button  onclick="window.location.href='{{ url('/') }}'">
                    <img src="{{ asset('build/assets/iconoError.png') }}" style="background: red;" alt="Error Icon">
                </button>    
                <p style="font-family: fantasy; font-size: 50px; color: white;">ERROR 500 </p>
                <p style="font-family: fantasy; font-size: 50px; color: white;">NO POTS DONAR D'ALTA A UN USUARI, SIUSPLAU CONSULTA AMB UN ADMINISTRADOR !</p>
                <p style="font-family: fantasy; font-size: 50px; color: white;">CLICKA A LA ICONA PER TORNA</p>
            </div>
        </x-slot>

        <x-validation-errors class="mb-4" />
        <!--
        <form method="POST" action="{{ route('register') }}">
            @csrf

             <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div> -->

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <!-- <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div> -->
        @endif

        <!-- <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div> 
        </form>-->
    </x-authentication-card>
</x-guest-layout>
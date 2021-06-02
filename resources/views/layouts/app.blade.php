<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> este funciona sin problemas--}}
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">    {{-- supuestamente va este --}}
        {{-- iconos y estilos bajados de https://fontawesome.com/download --}}
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

        {{--slot para definir estilos desde plantillas. Es para que funcione Dropzone, etc. --}}
        @if (isset($mi_css))
            {{ $mi_css }}
        @endif

        @livewireStyles                         {{-- estilos de livewire --}}

        {{-- aqui puedo incluir codigo 'css' con la sintaxis push('css') de blade, desde mi {{ $slot }} principal --}}
        @stack('css')

        <!-- Scripts. -->
        {{-- <script src="{{ asset('js/app.js') }}" defer></script> este funciona sin problemas--}} 
        <script src="{{ mix('js/app.js') }}" defer></script>    {{-- supuestamente va este --}}
        {{-- include de cualquier cuadro de dialog desde https://sweetalert2.github.io/ --}}
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">

<!-- instancio el componente de livewire 'navigation-menu' que esta en views\navigation-menu.blade.php -->
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}                 {{--aqui va todo el contenido de quien lo invoca o instancia--}}
            </main>
        </div>

        @stack('modals')

        @livewireScripts                     {{-- scripts de livewire --}}

        {{-- slot para ejecutar scripts desde cualquier plantilla --}}
        @if (isset($mi_js))
            {{ $mi_js }}        {{-- slot para ejecutar scripts desde cualquier plantilla --}}
        @endif

        {{-- aqui puedo incluir codigo 'js' con la sintaxis push('js') de blade, desde mi {{ $slot }} principal --}}
        @stack('js')

        <script>
            {{-- escucho el evento 'CartelExito' y levanto cartel de https://sweetalert2.github.io/ --}}
            Livewire.on('CartelExito', function( message){
                Swal.fire(
                    'Exito!',
                    message,
                    'success'                       {{-- icono --}}
                )
            })
        </script>


    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @include('parts.meta')

        <title>
            @hasSection('head')
                @yield('head')
            @else
                Dodoworkout
            @endif
        </title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles

        @hasSection('head')
            @yield('head')
        @endif
    </head>
    <body class="font-sans antialiased">
        @hasSection("header")
            @yield('header')
        @else
            @include('parts.header')
        @endif

        @yield('body')

        @hasSection("footer")
            @yield('footer')
        @else
            @include('parts.footer')
        @endif

        @livewireScripts
    </body>
</html>

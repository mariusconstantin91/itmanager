<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>It Manager</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Khula&family=Poppins&family=Nunito+Sans&display=swap"
        rel="stylesheet"
    >

    {{-- Icons --}}
    <link
        rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css"
    >
    <!-- Styles -->
    @livewireStyles
    <link
        href="{{ mix('css/app.css') }}"
        rel="stylesheet"
    >
</head>
<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<body class="font-poppins min-h-screen bg-neutral-100">
    @guest
        <div class="relative mx-auto">
            @livewire('layouts.navbar')
            {{ $slot }}
        </div>
        @livewire('layouts.footer')
    @endguest
    @auth
        <div
            class="relative mx-auto min-h-full"
            x-data="{ activeSidebar: true }"
        >
            @livewire('layouts.header')
            <div class="content flex flex-nowrap">
                @livewire('layouts.sidebar')
                <div class="p-8 flex-1 " x-bind:class="activeSidebar ? 'w-10/12' : 'w-[95%]'">
                    {{ $slot }}
                </div>
            </div>
        </div>

    @endauth

    @livewireScripts
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('js')
</body>

</html>

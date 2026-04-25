<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <title>Home</title> -->
    <!-- မူရင်း title နေရာမှာ ဒါလေး အစားထိုးပါ -->
<title>@yield('title', 'School Admin')</title>
    <link rel="stylesheet" href="">
    <!-- {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}} -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="{{ asset('js/chart.umd.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="min-h-screen flex flex-col">

    <div class="flex flex-1 flex-col md:flex-row">
        <div class=" flex justify-center">
            <!-- Sidebar -->
            @include('layouts.sidebar')
        </div>

        <!-- Body -->
        <main class="flex-1 bg-gray-100 p-6">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    @include('layouts.footer')
</body>

</html>
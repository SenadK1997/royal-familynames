<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.cdnfonts.com/css/futura-pt" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    {{-- <link rel="stylesheet" href="path/to/bootstrap.min.css"> --}}
    <!-- Include Select2 CSS and JavaScript -->
    {{-- <link rel="stylesheet" href="path/to/select2.min.css"> --}}
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet"> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="flex flex-col justify-between h-full">
        <div>
            @include('partials.navbar')
        </div>
        <div class="content__height justify-center items-baseline flex overflow-y-hidden h-full">
            @yield('content')
        </div>
        <div>
            @include('partials.footer')
        </div>
    </div>
</body>
@stack('script')
{{-- <script src="{{ asset('assets/js/navbar.js') }}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</html>
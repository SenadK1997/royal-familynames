<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Explore the history and origins of royal family names from around the world. Learn about the fascinating stories behind these names.">
    <meta name="keywords" content="royal family names, history, origins, genealogy, royalty">
    <meta property="og:title" content="Royal Family Names">
    <meta property="og:description" content="Explore the history and origins of royal family names from around the world. Learn about the fascinating stories behind these names.">
    <meta property="og:image" content="{{ asset('storage/images/royalfamilynames.png') }}">
    <link href="https://fonts.cdnfonts.com/css/futura-pt" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta property="og:image" content="https://i.ibb.co/x6nW8fZ/rsz-royalfamilynames-removebg-preview.png">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://www.paypalobjects.com/donate/sdk/donate-sdk.js" charset="UTF-8"></script> --}}
</head>
<body>
    <div class="flex flex-col justify-between h-full">
        <div>
            @include('partials.navbar')
        </div>
        <div class="content__height justify-center items-baseline flex overflow-y-hidden bg-gray-100">
            @yield('content')
        </div>
        <div>
            @include('partials.footer')
        </div>
    </div>
</body>
@stack('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
</html>
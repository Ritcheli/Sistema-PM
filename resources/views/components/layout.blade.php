<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title id="page-title" >{{ $title }}</title>
    @php
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    @endphp
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <section>   
        {{ $modal }} 
    </section>

    <x-sidebar></x-sidebar>
    <x-navbar></x-navbar>


    {{ $other_objects }}

    <section class="content-CM p-5"> 
        {{ $container_form }}
    </section>

    @include('sweetalert::alert')
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <section>   
        {{ $modal }} 
    </section>

    <x-sidebar></x-sidebar>
    <x-navbar></x-navbar>

    <section class="content-CM p-5"> 
        {{ $container_form }}
    </section>
</body>
</html>
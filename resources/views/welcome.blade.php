<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <x-sidebar :user="'Moranguinha'"></x-sidebar>
    <x-navbar> </x-navbar>

    <section class="content"> 
        DASHBOARD
    </section>
</body>
</html>
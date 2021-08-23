<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Controle de vendas</title>
</head>

<body>
    <div id="app">
        <app-layout user="{{ Auth::user() }}"></app-layout>
    </div>
    <script>
        window.Laravel = {
            api_token: '{{ Auth::user()->api_token }}'
        }
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>

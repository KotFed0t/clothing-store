<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Магазин одежды</title>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/starter-template.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
</head>
<body>

<header class="d-flex justify-content-center py-3 bg-light">
    <ul class="nav nav-pills">
        <li class="nav-item"><a href="{{route('admin.home')}}" class="nav-link active" aria-current="page">Админ панель</a>
        </li>
        <li class="nav-item"><a href="{{route('index')}}" class="nav-link">На главную магазина</a></li>
        <li class="nav-item"><a href="{{route('admin.categories')}}" class="nav-link">Категории</a></li>
        <li class="nav-item"><a href="{{route('admin.products')}}" class="nav-link">Товары</a></li>
        <li class="nav-item"><a href="{{route('admin.properties')}}" class="nav-link">Свойства</a></li>
        <li class="nav-item"><a href="{{route('admin.orders')}}" class="nav-link">Заказы</a></li>
        <li class="nav-item"><a href="{{route('admin.tickets')}}" class="nav-link">Обращения</a></li>
        <li class="nav-item"><a href="{{route('logout')}}" class="nav-link">Выход</a></li>


    </ul>
</header>
<div class="container">
    <div class="starter-template">
        @if(session()->has('success'))
            <div class="alert alert-success w-50 m-auto mt-3" role="alert">
                {{session('success')}}
            </div>
        @elseif(session()->has('warning'))
            <div class="alert alert-danger w-50 m-auto mt-3" role="alert">
                {{session('warning')}}
            </div>
        @endif

        @yield('content')

    </div>
</div>


</body>
</html>

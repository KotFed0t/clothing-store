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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

{{--<header class="d-flex justify-content-center py-3 bg-light">--}}
{{--    <ul class="nav nav-pills">--}}
{{--        <li class="nav-item"><a href="{{route('index')}}" class="nav-link active" aria-current="page">Магазин одежды</a>--}}
{{--        </li>--}}
{{--        <li class="nav-item dropdown">--}}
{{--            <a class="nav-link dropdown-toggle" href="{{route('categoryGender', 'man')}}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Мужчинам</a>--}}
{{--            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
{{--                <a class="dropdown-item" href="{{route('category', ['man', 'jacket'])}}">Куртки</a>--}}
{{--                <a class="dropdown-item" href="{{route('category', ['man', 'coat'])}}">Пальто</a>--}}
{{--                <a class="dropdown-item" href="{{route('category', ['man', 't-shirts'])}}">Футболки</a>--}}
{{--                <a class="dropdown-item" href="{{route('category', ['man', 'pants'])}}">Брюки</a>--}}
{{--                <a class="dropdown-item" href="{{route('category', ['man', 'sweaters'])}}">Свитеры</a>--}}
{{--            </div>--}}
{{--        </li>--}}
{{--        <li class="nav-item dropdown">--}}
{{--            <a class="nav-link dropdown-toggle" href="{{route('categoryGender', 'woman')}}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Женщинам</a>--}}
{{--            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">--}}
{{--                <a class="dropdown-item" href="{{route('category', ['woman', 'jacket'])}}">Куртки</a>--}}
{{--                <a class="dropdown-item" href="{{route('category', ['woman', 'coat'])}}">Пальто</a>--}}
{{--                <a class="dropdown-item" href="{{route('category', ['woman', 't-shirts'])}}">Футболки</a>--}}
{{--                <a class="dropdown-item" href="{{route('category', ['woman', 'pants'])}}">Брюки</a>--}}
{{--                <a class="dropdown-item" href="{{route('category', ['woman', 'sweaters'])}}">Свитеры</a>--}}
{{--            </div>--}}
{{--        </li>--}}
{{--        <li class="nav-item"><a href="{{route('basket')}}" class="nav-link">Корзина</a></li>--}}
{{--        <li class="nav-item"><a href="{{route('showFeedback')}}" class="nav-link">Обратная связь</a></li>--}}

{{--        @auth()--}}
{{--            <li class="nav-item"><a href="{{route('orders')}}" class="nav-link">История заказов</a></li>--}}
{{--        @endauth--}}

{{--        @guest()--}}
{{--            <li class="nav-item"><a href="{{route('login')}}" class="nav-link">Вход / Регистрация</a></li>--}}
{{--        @endguest--}}

{{--        @can('admin-manager-support')--}}
{{--            <li class="nav-item"><a href="{{route('admin.home')}}" class="nav-link">Админ панель</a></li>--}}
{{--        @endcan--}}

{{--        @auth()--}}
{{--            <li class="nav-item"><a href="{{route('logout')}}" class="nav-link">Выход</a></li>--}}
{{--        @endauth--}}

{{--    </ul>--}}
{{--</header>--}}
<header class="header bg-white">
    <div class="container px-lg-3">
        <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand" href="{{route('index')}}"><span class="fw-bold text-uppercase text-dark">Boutique</span></a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{route('categoryGender', 'man')}}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fw-bold ">Мужчинам</span></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{route('category', ['man', 'jacket'])}}">Куртки</a>
                            <a class="dropdown-item" href="{{route('category', ['man', 'coat'])}}">Пальто</a>
                            <a class="dropdown-item" href="{{route('category', ['man', 't-shirts'])}}">Футболки</a>
                            <a class="dropdown-item" href="{{route('category', ['man', 'pants'])}}">Брюки</a>
                            <a class="dropdown-item" href="{{route('category', ['man', 'sweaters'])}}">Свитеры</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{route('categoryGender', 'woman')}}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fw-bold ">Женщинам</span></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{route('category', ['woman', 'jacket'])}}">Куртки</a>
                            <a class="dropdown-item" href="{{route('category', ['woman', 'coat'])}}">Пальто</a>
                            <a class="dropdown-item" href="{{route('category', ['woman', 't-shirts'])}}">Футболки</a>
                            <a class="dropdown-item" href="{{route('category', ['woman', 'pants'])}}">Брюки</a>
                            <a class="dropdown-item" href="{{route('category', ['woman', 'sweaters'])}}">Свитеры</a>
                        </div>
                    </li>
                    <li class="nav-item"><a href="{{route('showFeedback')}}" class="nav-link"><i class="fa-regular fa-comment-dots"></i> <span class="fw-bold ">Обратная связь</span></a></li>
                    <i class="bi bi-gear-fill"></i>

                </ul>

                <ul class="navbar-nav ms-auto">
                    <form class="" action="{{route('search')}}">
                        <input name="search" type="text" class="form-control" placeholder="Найти товар..." aria-label="Пример группы ввода" aria-describedby="basic-addon1">
                    </form>
                    @auth()
                        <li class="nav-item"><a href="{{route('orders')}}" class="nav-link"><i class="fa-solid fa-clipboard-list"></i> <span class="fw-bold ">Заказы</span></a></li>
                    @endauth
                    <li class="nav-item"><a class="nav-link" href="{{route('basket')}}"> <i class="fas fa-dolly-flatbed me-1 text-gray"></i><span class="fw-bold ">Корзина</span><small class="text-gray fw-normal"></small></a></li>
                    @guest()
                        <li class="nav-item"><a class="nav-link" href="{{route('login')}}"> <i class="fas fa-user me-1 text-gray fw-normal"></i><span class="fw-bold ">Войти</span></a></li>
                    @endguest
                    @can('admin-manager-support')
                        <li class="nav-item"><a href="{{route('admin.home')}}" class="nav-link"><i class="fa-solid fa-screwdriver-wrench"></i> <span class="fw-bold ">Админ панель</span></a></li>
                    @endcan
                    @auth()
                        <li class="nav-item"><a href="{{route('logout')}}" class="nav-link"><i class="fas fa-user me-1 text-gray fw-normal"></i><span class="fw-bold ">Выход</span></a></li>
                    @endauth
                </ul>
            </div>
        </nav>
    </div>
</header>

<div class="container mb-5">
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

<footer class="footer navbar-fixed-bottom">
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <h2 class="footer-heading"><span class="fw-bold text-uppercase text-white">Boutique</span></h2>

            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <p class>
                    Copyright ©2022 All rights reserved | This site is made by true developer Vyacheslav Suchilin
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
{{--<script src="https://kit.fontawesome.com/7f724dbb77.js" crossorigin="anonymous"></script>--}}
</body>
</html>

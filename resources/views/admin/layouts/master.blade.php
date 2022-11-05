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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- gLightbox gallery-->
    {{--    <link rel="stylesheet" href="public/vendor/glightbox/css/glightbox.min.css">--}}
    <link rel="stylesheet" href="{{asset('vendor//glightbox/css/glightbox.min.css')}}">
    <!-- Range slider-->
    {{--    <link rel="stylesheet" href="public/vendor/nouislider/nouislider.min.css">--}}
    <link rel="stylesheet" href="{{asset('vendor/nouislider/nouislider.min.css')}}">
    <!-- Choices CSS-->
    {{--    <link rel="stylesheet" href="public/vendor/choices.js/public/assets/styles/choices.min.css">--}}
    <link rel="stylesheet" href="{{asset('vendor/choices.js/public/assets/styles/choices.min.css')}}">
    <!-- Swiper slider-->
    {{--    <link rel="stylesheet" href="public/vendor/swiper/swiper-bundle.min.css">--}}
    <link rel="stylesheet" href="{{asset('vendor/swiper/swiper-bundle.min.css')}}">
</head>
<body>

<header class="header bg-white">
    <div class="container px-lg-3">
        <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand" href="{{route('index')}}"><span class="fw-bold text-uppercase text-dark">Boutique</span></a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item mx-3"><a href="{{route('admin.categories')}}" class="nav-link"><span class="fw-bold "><i class="fa-solid fa-pen-to-square"></i> Категории</span></a></li>
                    <li class="nav-item mx-3"><a href="{{route('admin.products')}}" class="nav-link"><span class="fw-bold "><i class="fa-solid fa-shirt"></i> Товары</span></a></li>
                    @can('admin-manager')
                        <li class="nav-item mx-3"><a href="{{route('admin.properties')}}" class="nav-link"><span class="fw-bold "><i class="fa-solid fa-list-check"></i> Свойства</span></a></li>
                    @endcan

                    @can('admin')
                        <li class="nav-item mx-3"><a href="{{route('admin.roles')}}" class="nav-link"><span class="fw-bold "><i class="fa-solid fa-users-gear"></i> Роли</span></a></li>
                    @endcan

                    <li class="nav-item mx-3"><a href="{{route('admin.orders')}}" class="nav-link"><i class="fa-solid fa-clipboard-list"></i> <span class="fw-bold ">Заказы</span></a></li>

                    @can('admin-support')
                        <li class="nav-item mx-3"><a href="{{route('admin.tickets')}}" class="nav-link"><i class="fa-regular fa-comment-dots"></i> <span class="fw-bold ">Обращения</span></a></li>
                    @endcan

                    <li class="nav-item mx-3"><a href="{{route('logout')}}" class="nav-link"><i class="fas fa-user me-1 text-gray fw-normal"></i> <span class="fw-bold ">Выход</span></a></li>
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

<!-- JavaScript files-->
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('vendor/glightbox/js/glightbox.min.js')}}"></script>
<script src="{{asset('vendor/nouislider/nouislider.min.js')}}"></script>
<script src="{{asset('vendor/swiper/swiper-bundle.min.js')}}"></script>
<script src="{{asset('vendor/choices.js/public/assets/scripts/choices.min.js')}}"></script>
<script src="{{asset('js/front.js')}}"></script>
<script>
    // ------------------------------------------------------- //
    //   Inject SVG Sprite -
    //   see more here
    //   https://css-tricks.com/ajaxing-svg-sprite/
    // ------------------------------------------------------ //
    function injectSvgSprite(path) {

        var ajax = new XMLHttpRequest();
        ajax.open("GET", path, true);
        ajax.send();
        ajax.onload = function(e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
        }
    }
    // this is set to BootstrapTemple website as you cannot
    // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
    // while using file:// protocol
    // pls don't forget to change to your domain :)
    injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');

</script>
</body>
</html>

{{--<header class="d-flex justify-content-center py-3 bg-light">--}}
{{--    <ul class="nav nav-pills">--}}
{{--        <li class="nav-item"><a href="{{route('admin.home')}}" class="nav-link active" aria-current="page">Админ панель</a>--}}
{{--        </li>--}}
{{--        <li class="nav-item"><a href="{{route('index')}}" class="nav-link">На главную магазина</a></li>--}}
{{--        <li class="nav-item"><a href="{{route('admin.categories')}}" class="nav-link">Категории</a></li>--}}
{{--        <li class="nav-item"><a href="{{route('admin.products')}}" class="nav-link">Товары</a></li>--}}
{{--        @can('admin-manager')--}}
{{--            <li class="nav-item"><a href="{{route('admin.properties')}}" class="nav-link">Свойства</a></li>--}}
{{--        @endcan--}}

{{--        @can('admin')--}}
{{--            <li class="nav-item"><a href="{{route('admin.roles')}}" class="nav-link">Роли</a></li>--}}
{{--        @endcan--}}

{{--        <li class="nav-item"><a href="{{route('admin.orders')}}" class="nav-link">Заказы</a></li>--}}

{{--        @can('admin-support')--}}
{{--            <li class="nav-item"><a href="{{route('admin.tickets')}}" class="nav-link">Обращения</a></li>--}}
{{--        @endcan--}}

{{--        <li class="nav-item"><a href="{{route('logout')}}" class="nav-link">Выход</a></li>--}}


{{--    </ul>--}}
{{--</header>--}}
{{--<div class="container">--}}
{{--    <div class="starter-template">--}}
{{--        @if(session()->has('success'))--}}
{{--            <div class="alert alert-success w-50 m-auto mt-3" role="alert">--}}
{{--                {{session('success')}}--}}
{{--            </div>--}}
{{--        @elseif(session()->has('warning'))--}}
{{--            <div class="alert alert-danger w-50 m-auto mt-3" role="alert">--}}
{{--                {{session('warning')}}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        @yield('content')--}}

{{--    </div>--}}
{{--</div>--}}


{{--</body>--}}
{{--</html>--}}

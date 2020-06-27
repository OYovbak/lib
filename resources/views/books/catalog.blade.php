<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item nav-link navbar-text">
                        <a class="menu_link" href="{{route('main')}}">HOME</a>
                    </li>
                    <li class="nav-item nav-link navbar-text">
                        <a class="menu_link" href="{{route('aboutUs')}}">ABOUT</a>
                    </li>
                    <li class="nav-item nav-link navbar-text">
                        <a class="menu_link active_link" href="{{route('catalog')}}">CATALOG</a>
                    </li>
                    <li class="nav-item nav-link navbar-text">
                        <a class="menu_link" href="{{route('contact')}}">CONTACT</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                <a class="dropdown-item menu_link" href="{{url('profile', Auth::user()->login)}}">
                                    {{ __('Profile') }}
                                </a>

                                @if(Auth::user()->is_admin)
                                    <a class="dropdown-item" href="{{route('admin.catalog')}}">
                                        {{ __('Admin Catalog') }}
                                    </a>
                                @endif

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <div class="wrapper">
                <div class="page_title">CATALOG</div>
                <input type="text" class="input-group-text search" placeholder="Search by name ...">

                </div>
            <div class="row">
                <div class="category_wrapper">
                @foreach(\App\Category::all() as $category)
                    <div class="form-group category_chekbox">
                        <div >
                            <input type="checkbox" name="category[]" value="{{$category->id}}" class="custom-checkbox filter">
                        </div>
                        <label class="category_text control-label col-md-4">{{$category->title}}</label>
                    </div>
                @endforeach
                </div>

                <table class="categ_list" style="width: 85%;">
                    <tbody class="catalog_wrapper">

                    </tbody>
                </table>

                {{ csrf_field() }}


            </div>
        </div>
    </main>
</div>
</body>
</html>

<script>
$(document).ready(function () {
    $('input:checked').prop('checked', false);
    var _token = $('input[name="_token"]').val();
    var str = '';
    var search_line = '';

    show_book_list();

    function show_book_list(categories = '', search = '') {
        $.ajax({
            url:"{{ route('catalog.show') }}",
            method:"POST",
            data:{categories:categories, search:search, _token:_token},
            dataType:"json",
            success:function (data) {
                var output = '';

                for(var count = 0; count < data.length; count++){

                    output += '<div class="catalog_book">';
                    output += '<div class="item_book">'+ '<div class="img_wpapper"><img class="img_book" src="'+ data[count].url_img +' "/></div>' + '<div class="info_book"><div class="writer_book">' + data[count].writer + '</div><div class="title_book">"'+ data[count].title + '"</div><div class="category_book">'+ data[count].categ +'</div>';
                    output += '<div class="year_book"> | ' + data[count].year + '</div>' + '<a class="title_book_link" href="'+data[count].link+'">Read more</a>' + '</div></div></div>';
                }

                $('tbody').html(output);
            }
        });
    }

    var filterCheck = [];
    $('.filter').click(
        function (event) {
            if(!filterCheck.includes(event.currentTarget.value)) {
                filterCheck.push(event.currentTarget.value);
            }
            else{
                filterCheck = filterCheck.filter(value => value != event.currentTarget.value);
            }
             str = filterCheck.toString();
            show_book_list(str, search_line);
        }
    );

        $(document).on('keyup', '.search', function () {
             search_line = $('.search').val();
            show_book_list(str, search_line);
        });
});
</script>

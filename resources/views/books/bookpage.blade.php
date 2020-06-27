<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/0744516b30.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
                    <li class="nav-item nav-link navbar-text"><a class="menu_link" href="{{route('main')}}">HOME</a></li>
                    <li class="nav-item nav-link navbar-text"><a class="menu_link" href="{{route('aboutUs')}}">ABOUT</a></li>
                    <li class="nav-item nav-link navbar-text"><a class="menu_link active_link" href="{{route('catalog')}}">CATALOG</a></li>
                    <li class="nav-item nav-link navbar-text"><a class="menu_link" href="{{route('contact')}}">CONTACT</a></li>
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

                                <a class="dropdown-item" href="{{url('profile', Auth::user()->login)}}">
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
        <div class="bookpage_wrapper">

            <div class="bookpage_title"><span class="bookpage_writer">{{$book->writer}}</span> ''{{$book->title}}''</div>
            <div class="bookpage_content">
                <div class="book_main">
                    <div class="bookpage_img_wrapper .exmpl">
                        <img class="bookpage_img" src="{{$book->url_img}}" >

                    </div>
                   <div class="book_description"> {{$book->description}}
                    <div class="book_btn">
                        <a style="text-align: center; margin-top: 25px;" href="{{route('book.download', $book->id)}}" class="title_book_link download" id="download">Download</a>
                        {{ csrf_field() }}
                        <input type="checkbox" id="read" class="input_read">
                        <label style="text-align: center; margin-top: 25px; cursor: pointer;"class="title_book_link read_btn" for="read">Read online</label>
                        <label class="close_btn" for="read"><i class="fas fa-window-close"></i></label>
                        <div class="book_read">
                            <iframe src = "/ViewerJS/#..{{$book->url_book}}" class="book_iframe" height="500" width="100%" allowfullscreen webkitallowfullscreen></iframe>
                        </div>

                    </div>
                    </div>
                   <div id="add_delete">

                    </div>
                </div>
                  <div class="bookpage_info">@foreach($book->categories as $category)
                                    {{$category->title}}
                                @endforeach | {{$book->year}}</div>

            </div>

        </div>
    </div>
    </main>
</div>
</body>
</html>
<script>
    $(document).ready(function () {
        var id = '{{$book->id}}';
        var _token = $('input[name="_token"]').val();
        inFavorite();
        function inFavorite(doAction = '') {

            $.ajax({
                url:"{{route('book.favorite')}}",
                method: "POST",
                data:{id:id, doAction:doAction, _token:_token},
                dataType:"json",
                success:function (data) {

                    var output = '';
                    if(data.canDelete == '1'){
                        output += '<a class="btn_favorite action" id="action_btn"><i class="fas fa-heart"></i></a>';
                    }
                    else{
                        output += '<a class="btn_favorite action" id="action_btn"><i class="far fa-heart"></i></a>';
                    }
                    $('#add_delete').html(output);
                }
            });
        }
        $(document).on('click', '.action', function () {
           var val = this.id;
           inFavorite(val);
        });

    });

</script>

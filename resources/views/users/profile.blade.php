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
                        <a class="menu_link" href="{{route('catalog')}}">CATALOG</a>
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
            <div class="profile_wrapper">
                <div class="profile_header">
                    <div class="page_title">FAVORITE LIST</div>
                    <div class="user_info_wrapper">
                        <div id="user_info"  class="user_info_content">

                        </div>

                        <button type="button" name="profileChng" id="profileChng" class="edit_btn">
                            <i class="fas fa-pen-square"></i>
                        </button>
                    </div>
                </div>
                <div id="changeProfile" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Change Profile</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <span id="form_profile_result"></span>
                                <form method="post" id="changeProfileForm" class="form-horizontal" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input placeholder="New Name" type="text" name="mew_name" id="new_name" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input placeholder="New Surname" type="text" name="new_surname" id="new_surname" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input placeholder="New Login" type="text" name="new_login" id="new_login" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input placeholder="New Email" type="email" name="new_email" id="new_email" class="form-control" />
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 form_name">New img:</label>
                                        <div class="col-md-12">
                                            <input type="file" name="new_img" id="new_img"/>
                                        </div>
                                    </div>
                                    <hr>

                                    <button class="col-md-12 profile_btn_pass" type="button" name="chengePassOpen" id="chengePassOpen">Change pass</button>

                                    <div class="form-group" align="center">
                                        <input type="hidden" name="hidden_id" id="hidden_id">
                                        <input type="submit" name="action_button" id="action_button" class="col-md-12 ok_btn" value="OK" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="chengePass" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Change pass</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <span id="form_pass_result"></span>
                                <form method="post" id="chengePassForm" class="form-horizontal" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input placeholder="Current password" type="password" name="current_password" id="current_password" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input placeholder="New password" type="password" name="new_password" id="new_password" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input placeholder="Confirm password" type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group" align="center">
                                        <input type="hidden" name="hidden_id" id="hidden_id">
                                        <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="save change" />
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <div id="user_favorite" class="user_favorite">

                </div>
                {{ csrf_field() }}


            </div>
        </div>
    </main>
</div>
</body>
</html>
<script>
    $(document).ready(function () {
        $('#changeProfileForm')[0].reset();
        $('#chengePassForm')[0].reset();

        var _token = $('input[name="_token"]').val();
        showUserInfo();
        showUserFavorite();
        function showUserInfo() {
            $.ajax({
                url:"{{ route('profile.info') }}",
                method:"POST",
                data:{_token:_token},
                dataType:"json",
                success:function (data) {
                    var output = '';
                    output += '<div class="user_img_wrapper exmpl"><img class="user_img" src="'+data.url_img+'"></div>';
                    output += '<div class="user_name">'+data.name+'</div>';
                    output += '<div class="user_lastname">'+data.surname+'</div>';
                    $('#user_info').html(output);
                }
            });
        }
        function showUserFavorite() {
            $.ajax({
                url:"{{ route('profile.favorite') }}",
                method:"POST",
                data:{_token:_token},
                dataType:"json",
                success:function (data) {
                    var output = '';
                    for(var count = 0; count < data.length; count++) {
                        output += '<div class="catalog_book"><div class="item_book">' + '<div class="img_wpapper"><img class="img_book" src="'+ data[count].url_img +' "/></div>' + '<div class="info_book"><div class="writer_book">' + data[count].writer + '</div><div class="title_book">"'+ data[count].title + '"</div><div class="category_book">' + data[count].categ + '</div><div class="year_book"> | ' + data[count].year + '</div>' + '<a class="title_book_link" href="'+data[count].link+'">Read more</a>';
                        output += '<a class="book_delete delete" id="'+data[count].id+'">delete</a></div></div></div>';
                    }
                    $('#user_favorite').html(output);
                }
            });
        }
        $(document).on('click', '.delete', function () {
            var id = this.id;
            $.ajax({
                url:"{{route('favorite.delete')}}",
                method:"POST",
                data:{id:id, _token:_token},
                dataType:"json",
                success:function (data) {
                    alert(data.success);
                    showUserFavorite();
                }
            });
        });

        $('#profileChng').click(function () {
            $('#changeProfile').modal('show');
        });

       $('#changeProfileForm').on('submit', function (event) {
           event.preventDefault();
           var form_data = new FormData();
           form_data.append('new_name', $('#new_name').val());
           form_data.append('new_surname', $('#new_surname').val());
           form_data.append('new_login', $('#new_login').val());
           form_data.append('new_mail', $('#new_email').val());
          if($('#new_img')[0].files[0]) {
              form_data.append('new_img', $('#new_img')[0].files[0]);
          }
           form_data.append('_token', _token);
           $.ajax({
               url:"{{ route('change.info') }}",
               method:"POST",
               data: form_data,
               contentType: false,
               cache: false,
               processData: false,
               dataType:"json",
               success:function (data) {
                   var result = '';
                   if(data.errors){
                       result = '<div class="alert alert-danger"';
                       for(var count=0; count < data.errors.length; count++){
                           result += '<p>' + data.errors[count] + '</p>';
                       }
                       result += '</div>';
                   }
                   if(data.success){
                       result = '<div class="alert alert-success">' + data.success + '</div>';
                       $('#changeProfileForm')[0].reset();
                       showUserInfo();
                   }
                   $('#form_profile_result').html(result);
               }
           });
       });

        $('#chengePassOpen').click(function () {
            $('#chengePass').modal('show');
        });

        $('#chengePassForm').on('submit', function (event) {

            event.preventDefault();
            var current_password = $('#current_password').val();
            var new_password = $('#new_password').val();
            var new_password_confirmation = $('#new_password_confirmation').val();
            $.ajax({
                url:"{{ route('change.pass') }}",
                method:"POST",
                data:{current_password:current_password, new_password:new_password, new_password_confirmation:new_password_confirmation, _token:_token},
                dataType:"json",
                success:function (data) {
                    var result = '';
                    if(data.errors){
                        result = '<div class="alert alert-danger"';
                        for(var count=0; count < data.errors.length; count++){
                            result += '<p>' + data.errors[count] + '</p>';
                        }
                        result += '</div>';
                    }
                    if(data.success){
                        result = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#chengePassForm')[0].reset();
                    }
                    $('#form_pass_result').html(result);
                }
            });
        });

    });

</script>

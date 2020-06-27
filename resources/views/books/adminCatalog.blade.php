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
                    <li class="nav-item nav-link navbar-text"><a class="menu_link" href="{{route('main')}}">HOME</a></li>
                    <li class="nav-item nav-link navbar-text"><a class="menu_link" href="{{route('aboutUs')}}">ABOUT</a></li>
                    <li class="nav-item nav-link navbar-text"><a class="menu_link" href="{{route('catalog')}}">CATALOG</a></li>
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
            <div class="wrapper">
                <div class="page_title">CATALOG</div>
                <input type="text" class="input-group-text search" placeholder="Search by name ...">


            </div>
            <div class="row">
                <div class="category_wrapper">
                 @foreach(\App\Category::all() as $category)
                    <div class="form-group category_chekbox">
                        <div>
                            <input type="checkbox" name="category[]" value="{{$category->id}}" class="filter">
                        </div>
                        <label class="category_text control-label col-md-4">{{$category->title}}</label>
                    </div>
                @endforeach
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header"><b>Book Catalog</b></div>
                        <div id="formModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title lib_title">Add new book</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <span id="form_result"></span>
                                            <form method="post" id="addNew" class="form-horizontal" enctype="multipart/form-data">

                                                <div class="form-group">
                                                    <div class="col-md-11">
                                                        <input placeholder="Title.." type="text" name="title" id="title" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-11">
                                                        <input placeholder="Writer.." type="text" name="writer" id="writer" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-11">
                                                        <input placeholder="Year.." type="text" name="year" id="year" class="form-control" maxlength="4"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-11">
                                                        <textarea placeholder="Description.." type="text" name="description" id="description" class="form-control" ></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-11">
                                                        <input placeholder="Number of pages.." type="text" name="num_of_pages" id="num_of_pages" class="form-control" />
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 form_name"><b>Book link:</b></label>
                                                    <div class="col-md-11">
                                                        <input type="file" name="book" id="book"/>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 form_name"><b>IMG:</b></label>
                                                    <div class="col-md-11">
                                                        <input type="file" name="img" id="img"/>
                                                    </div>
                                                </div>
                                                <hr>
                                                <label class="control-label col-md-12" style="display: flex; justify-content: space-between;"><b>Choose category</b><button type="button" name="addNewCateg" id="addNewCateg" class="admin_categ_btn"><i class="fas fa-plus-square plus_icon"></i></button></label>
                                                <div id="categories" class="admin_categ_wrapper">
                                              </div>
                                              <hr>

                                                <br />
                                                <div class="form-group" align="center">
                                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="categModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title lib_title">Add new category</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <span id="form_addCateg_result"></span>
                                            <form method="post" id="addCateg" class="form-horizontal" enctype="multipart/form-data">

                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <input placeholder="Category..." type="text" name="titleCateg" id="titleCateg" class="form-control" />
                                                    </div>
                                                </div>

                                                <br />
                                                <div class="form-group" align="center">
                                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="editModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title lib_title">Edit a book</h4>
                                            <button type="button" class="close closeEdit" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <span id="form_edit_result"></span>
                                            <form method="post" id="editForm" class="form-horizontal" enctype="multipart/form-data">

                                                <div class="form-group">
                                                    <label class="control-label col-md-4 form_name">Title:</label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="newTitle" id="newTitle" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 form_name">Writer:</label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="newWriter" id="newWriter" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 form_name">Year:</label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="mewYear" id="newYear" class="form-control" maxlength="4"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 form_name">Description:</label>
                                                    <div class="col-md-12">
                                                        <textarea type="text" name="newDescription" id="newDescription" class="form-control" ></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 form_name">Number of pages:</label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="newNum_of_pages" id="newNum_of_pages" class="form-control" />
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 form_name">Book link:</label>
                                                    <div class="col-md-12">
                                                        <input type="file" name="newBook" id="newBook"/>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 form_name">New IMG</label>
                                                    <div id="oldImg"></div> <br>
                                                    <div class="col-md-12">
                                                        <input type="file" name="newImg" id="newImg"/>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 form_name">Add Category</label>
                                                    <div id="addCategsToEdit" class="admin_categ_wrapper">

                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group">
                                                    <label class="control-label col-md-4 form_name">Delete Category</label>
                                                    <div id="delCategsToEdit" class="admin_categ_wrapper" style="max-height: 100px;">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-group" align="center">
                                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                                    <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Change" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <button type="button" name="open" id="open" class="btn_add_book">Add new Book</button>
                            {{ csrf_field() }}
                        <div class="card-body">

                            <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th width="35%">Book</th>
                                    <th width="50%">Writer</th>
                                    <th width="15%">Year</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>

<script>
    $(document).ready(function () {

        $('#addNew')[0].reset();
        $('input:checked').prop('checked', false);
        var _token = $('input[name="_token"]').val();
        var str = '';
        var search_line = '';

        show_book_list();
        showCategList();
        var books;

        function show_book_list(categories = '', search = '') {

            $.ajax({
                url:"{{ route('catalog.show') }}",
                method:"POST",
                data:{categories:categories, search:search, _token:_token},
                dataType:"json",
                success:function (data) {
                    books = data;
                    var output = '';
                    $('#total_records').text(data.length);
                    for(var count = 0; count < data.length; count++){

                        output += '<tr>';
                        output += '<td style="vertical-align: middle;"><a href="'+data[count].link+'">' + data[count].title + '</a><p>'+ data[count].categ +'</p></td>';
                        output += '<td style="vertical-align: middle;">' + data[count].writer + '</td>';
                        output += '<td style="vertical-align: middle;">' + data[count].year + '</td>';
                        output += '<td style="vertical-align: middle;"><a class="delete" id="'+data[count].id+'"><i style="color: #e3342f; font-size: 1.7rem; cursor: pointer;" class="fas fa-trash-alt"></i></a></td></th>';
                        output += '<td style="vertical-align: middle;"><a class="edit" id="'+data[count].id+'"><i class="fas fa-edit"></i></a></td></th>';
                    }

                    $('tbody').html(output);
                }
            });
        }

        $(document).on('click', '.delete', function () {

            var id = this.id;
            $.ajax({
                url:"{{route('catalog.delete')}}",
                method:"POST",
                data:{id:id, _token:_token},
                dataType:"json",
                success:function (data) {
                    alert(data.success);
                    show_book_list();
                }
            });
        });

        $('#open').click(function () {
          $('#formModal').modal('show');
            $('input:checked').prop('checked', false);
        });


        $('#addNew').on('submit', function (event) {
            event.preventDefault();

                var form_data = new FormData();
                categoryAdd.toString();
                form_data.append('title', $('#title').val());
                form_data.append('year', $('#year').val());
                form_data.append('writer', $('#writer').val());
                form_data.append('description', $('#description').val());
                form_data.append('num_of_pages', $('#num_of_pages').val());
                form_data.append('url_img', $('#img')[0].files[0]);
                form_data.append('url_book', $('#book')[0].files[0]);
                form_data.append('categories', categoryAdd);
                form_data.append('_token', _token);

                $.ajax({
                    url:"{{ route('admin.add_book') }}",
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
                            $('#addNew')[0].reset();
                            show_book_list();
                        }
                        $('#form_result').html(result);
                    }
                });
        });
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


        var categoryAdd = [];

        $(document).on('click', '.category', function () {
            var checked = [];
            $('input:checkbox:checked').each(function() {
                checked.push($(this).val());
            });
            categoryAdd = checked;
        });

        var allCategs;

        function showCategList() {
            $.ajax({
                url: "{{ route('take.categories') }}",
                method: "POST",
                data: {_token: _token},
        dataType: "json",
                success: function (data) {
                    var output = '';
                    allCategs = data;
                    for (var i = 0; i < data.length; i++) {
                        output += '<div class="form-group"> ' +
                            '<div class="admin_categ_label col-md-8">' +
                            '<input type="checkbox" name="category[]" value="'+data[i].id+'" class="category">'
                             + '<label class="control-label col-md-4">' + data[i].title + '</lable></div></div>';
                    }
                    $('#categories').html(output);
                }
            });
        }


        $('#addNewCateg').click(function () {
            $('#categModal').modal('show');
        });

        $('#addCateg').on('submit', function (event) {
            event.preventDefault();
            var title = $('#titleCateg').val();
            $.ajax({
                url:"{{ route('add.category') }}",
                method:"POST",
                data:{title:title, _token:_token},
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
                        $('#addCateg')[0].reset();
                    }
                    $('#form_addCateg_result').html(result);
                    showCategList();
                }
            });
        });

        var bookIdToEdit;
            $(document).on('click', '.edit', function () {
                $('input:checked').prop('checked', false);
                categoryToEdit = [];
                bookIdToEdit = this.id;
                add_info_formEdit();
            });

            function add_info_formEdit() {

                var book = books.find(item => item.id == bookIdToEdit);
                $('#newTitle').val(book.title);
                $('#newWriter').val(book.writer);
                $('#newYear').val(book.year);
                $('#newNum_of_pages').val(book.num_of_pages);
                $('#newDescription').val(book.description);
                $('#oldImg').html('<img src="'+book.url_img+'" height="200">');
                var bookCategs = book.categ.split(" ");
                var addOutput = '';
                var delOutput = '';
                for(var count=0; count<allCategs.length; count++){
                    if(bookCategs.indexOf(allCategs[count].title) != -1){
                        delOutput += '<div class="form-group"><div class="col-md-8">' + '<input type="checkbox" name="categoryToChange[]" value="'+allCategs[count].id+'" class="categoryToChange"><label class="control-label col-md-4">' + allCategs[count].title + '</lable></div></div>';
                    }
                    else {
                        addOutput += '<div class="form-group"><div class="col-md-8"><input type="checkbox" name="categoryToChange[]" value="'+allCategs[count].id+'" class="categoryToChange"><label class="control-label col-md-4">' + allCategs[count].title + '</lable></div></div>';
                    }
                }
                $('#addCategsToEdit').html(addOutput);
                $('#delCategsToEdit').html(delOutput);
                $('#editModal').modal('show');
            }

        var categoryToEdit = [];

        $(document).on('click', '.categoryToChange', function () {
            var checked = [];
            $('input:checkbox:checked').each(function() {
                checked.push($(this).val());
            });
            categoryToEdit = checked;
        });

        $('#editForm').on('submit', function (event) {
            event.preventDefault();
            var form_data = new FormData();
            categoryToEdit.toString();
            if(books.find(item => item.id == bookIdToEdit).title == $('#newTitle').val()){
                form_data.append('title', '');
            }
            else {
                form_data.append('title', $('#newTitle').val());
            }
            form_data.append('year', $('#newYear').val());
            form_data.append('writer', $('#newWriter').val());
            form_data.append('description', $('#newDescription').val());
            form_data.append('num_of_pages', $('#newNum_of_pages').val());
            if($('#newImg')[0].files[0]) {
                form_data.append('url_img', $('#newImg')[0].files[0]);
            }
            if($('#newBook')[0].files[0]) {
                form_data.append('url_book', $('#newBook')[0].files[0]);
            }
            form_data.append('id', bookIdToEdit);
            form_data.append('categories', categoryToEdit);
            form_data.append('_token', _token);

            $.ajax({
                url:"{{ route('catalog.change') }}",
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
                        $('#editForm')[0].reset();
                        show_book_list();
                        alert( data.success);
                        $('#editModal').modal('hide');
                    }
                    $('#form_edit_result').html(result);
                }
            });
        });

    })

</script>

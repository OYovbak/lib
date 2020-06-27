<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@main_page')->name('main');
Route::get('/about_us', 'HomeController@about_us')->name('aboutUs');
Route::get('/contact', 'HomeController@contact')->name('contact');

Route::get('/catalog', 'CatalogController@index')->name('catalog');
Route::post('/catalog/show', 'CatalogController@show_books')->name('catalog.show');

Route::get('/book/{title}', 'BookController@index')->name('book');
Route::post('/book/favorite', 'BookController@favorite')->name('book.favorite');
Route::get('/book/download/{id}', 'BookController@download')->name('book.download');

Route::get('/profile/{login}', 'ProfileController@index')->name('profile');
Route::post('/profile/info', 'ProfileController@showUser')->name('profile.info');
Route::post('/profile/favorite', 'ProfileController@showFavorite')->name('profile.favorite');
Route::post('/profile/favorite/delete', 'ProfileController@deleteFavorite')->name('favorite.delete');
Route::post('/profile/change_pass', 'ProfileController@changePass')->name('change.pass');
Route::post('/profile/change_info', 'ProfileController@changeInfo')->name('change.info');

Route::get('/admin/catalog', 'CatalogController@admCatalog')->name('admin.catalog');
Route::post('/admin/catalog/add', 'CatalogController@add_new_book')->name('admin.add_book');
Route::post('/admin/catalog/delete', 'CatalogController@delete_book')->name('catalog.delete');
Route::post('/admin/catalog/change_book', 'CatalogController@changeBook')->name('catalog.change');

Route::post('/admin/catalog/add/category', 'CatalogController@addCategory')->name('add.category');
Route::post('/admin/catalog/tale/categories', 'CatalogController@takeCategories')->name('take.categories');

Route::any('/ViewerJS/{all?}', function(){
    return View::make('ViewerJS.index');
});

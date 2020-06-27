<?php

namespace App\Http\Controllers;
use App\Book;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\Promise\all;

class CatalogController extends Controller
{
    public function index(){
        return view('books.catalog');
    }

    public function admCatalog(){
        if(Auth::check()) {
            if (Auth::user()->is_admin) {
                return view('books.adminCatalog');
            } else {
                return redirect('catalog');
            }
        }
        else return redirect('catalog');
    }

    public function show_books(Request $request){
        if($request->ajax()){
            if($request->categories != ''){
                $new_arr = explode(',', $request->categories);
                $books_arr = [];
                $books = Book::all();
                foreach ($books as  $book){
                    foreach ($book->categories as $category){
                        foreach ($new_arr as $key=>$value){
                            if($category->id == $value){
                                array_push($books_arr, $book->id);
                                break 2;
                            }
                        }
                    }
                }
                if($request->search != ''){
                    $data = DB::table('books')
                        ->whereIn('id', $books_arr)
                        ->where('title', 'like', '%'.$request->search.'%')
                        ->get();
                }
                else {
                    $data = DB::table('books')
                        ->whereIn('id', $books_arr)->get();
                }
            }
            else{
                if($request->search != ''){
                    $data = DB::table('books')
                        ->where('title', 'like', '%'.$request->search.'%')
                        ->get();
                }
               else { $data = DB::table('books')->get(); }
            }
            foreach ($data as $arr){
                $book = Book::find($arr->id);
                $categ_string = '';
                foreach ($book->categories as $category){
                    $categ_string .=  $category->title.' ';
                }
                $arr->categ = $categ_string;
                $arr->link = route('book', $arr->title);
            }
            echo json_encode($data);
        }
    }

    public function add_new_book(Request $request){
       if($request->ajax()) {
           $rules = [
               'title' => 'required|unique:books',
               'year' => 'required|integer',
               'writer' => 'required',
               'description' => 'required',
               'num_of_pages' => 'required|integer',
               'url_img' => 'required|image',
               'url_book' => 'required|file'
           ];
           $error = Validator::make($request->all(), $rules);
           if($error->fails()){
               $data = [
                   'errors' => $error->errors()->all()
               ];
               echo json_encode($data);
           }
           else{
               $image = $request->file('url_img')->store('images', 'public');
               $url_img = Storage::url($image);
               $book_file = $request->file('url_book')->store('books', 'public');
               $url_book = Storage::url($book_file);
               $form_data = array(
                   'title' => $request->title,
                   'description' => $request->description,
                   'writer' => $request->writer,
                   'year' => $request->year,
                   'num_of_pages' => $request->num_of_pages,
                   'url_book' => $url_book,
                   'url_img' => $url_img
               );

               $book =Book::create($form_data);
               $new_arr = explode(',', $request->categories);
               foreach ($new_arr as $key=>$value){
                   $book->categories()->attach($value);
               }
               $data = [
                   'success' => 'Book Added Successfully'
               ];
               echo json_encode($data);
           }
       }
    }

        public function delete_book(Request $request){
            $book = Book::findOrFail($request->id);
            $book->categories()->detach();
            unlink(public_path($book->url_img));
            unlink(public_path($book->url_book));
            $book->delete();
            $data =[
                'success' => 'Book Deleted '
            ];
            echo json_encode($data);
        }

         public function addCategory(Request $request){
        $rules = [
          'title' => 'nullable|unique:categories,title'
        ];
        $error = Validator::make($request->all(), $rules);
        if($error->fails()){
            $data = [
                'errors' => $error->errors()->all()
            ];
            echo json_encode($data);
        }
        else {
            $category = array(
                'title' => $request->title
            );
            Category::create($category);
            $data = [
                'success' => 'Category Added Successfully'
            ];
            echo json_encode($data);
        }
    }

      public function takeCategories(){
          $data = Category::all();
          echo json_encode($data);
      }

  public function changeBook(Request $request){
        if($request->ajax()){
            $rules = [
                'title' => 'nullable|unique:books',
                'year' => 'nullable|integer',
                'writer' => 'nullable',
                'description' => 'nullable',
                'num_of_pages' => 'nullable|integer',
                'url_img' => 'nullable|sometimes|image',
                'url_book' => 'nullable|sometimes|file'
            ];
            $error = Validator::make($request->all(), $rules);
            if($error->fails()){
                $data = [
                    'errors' => $error->errors()->all()
                ];
                echo json_encode($data);
            }
            else{
                $book = Book::find($request->id);
                if($request->title){
                    $book->title = $request->title;
                }
                if($book->year != $request->year){
                    $book->year = $request->year;
                }
                if($book->writer != $request->writer){
                    $book->writer = $request->writer;
                }
                if($book->description != $request->description){
                    $book->description = $request->description;
                }
                if($book->num_of_pages != $request->num_of_pages){
                    $book->num_of_pages = $request->num_of_pages;
                }
                $old_img = '';
                if($request->url_img){
                    $image = $request->file('url_img')->store('images', 'public');
                    $url_img = Storage::url($image);
                    $old_img = $book->url_img;
                    $book->url_img = $url_img;
                }
                $old_book ='';
                if($request->url_book){
                    $book_file = $request->file('url_book')->store('books', 'public');
                    $url_book = Storage::url($book_file);
                    $old_book =  $book->url_book;
                    $book->url_book = $url_book;
                }
                $book->save();
                if($request->categories) {
                    $new_arr = explode(',', $request->categories);
                    foreach ($new_arr as $key => $value) {
                        if ($book->categories()->get()->contains('id', $value)) {
                            $book->categories()->detach($value);
                        } else {
                            $book->categories()->attach($value);
                        }
                    }
                }

                $data = [
                    'success' => 'Info changed',
                ];
                if($old_img != ''){
                unlink(public_path($old_img));}
                if($old_book != ''){
                unlink(public_path($old_book));}
                echo json_encode($data);

            }
        }
  }

}

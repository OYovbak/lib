<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index($title){
        $book = Book::where('title', '=', $title)->first();
        return view('books.bookpage', ['book'=>$book]);
    }

    public function favorite(Request $request){
        if($request->ajax()){
            if($request->doAction != ''){
                $book = Book::find($request->id);
                if($book->users()->get()->contains('id', Auth::user()->id)) {
                    $book->users()->detach(Auth::user()->id);
                    $data = [
                        'canDelete' => '0'
                    ];
                     }
                else{
                    $book->users()->attach(Auth::user()->id);
                    $data = [
                        'canDelete' => '1'
                    ];
                }
                echo json_encode($data);
            }
            else{
                $book = Book::find($request->id);
                $data = [
                    'canDelete' => '0'
                ];
                if($book->users()->get()->contains('id', Auth::user()->id)) {
                    $data = [
                        'canDelete' => '1'
                    ]; }
                echo json_encode($data);
            }
        }
    }

    public function download($id){
        $book = Book::find($id);
        $file_path = public_path($book->url_book);
        return response()->download($file_path, $book->title);
    }
}

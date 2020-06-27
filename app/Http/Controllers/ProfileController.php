<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Composer
{
    public function index($login){
        if(Auth::check()){
            if(Auth::user()->login == $login){
                $user = User::find(Auth::user()->id);
                return view('users.profile', ['user'=>$user]);}
            else return redirect('profile/'.Auth::user()->login);
        }
        return redirect('/login');
    }

    public function showUser(){
        $data = User::find(Auth::user()->id);
        echo json_encode($data);
    }

    public function showFavorite(){
        $user = User::find(Auth::user()->id);
        $data = $user->favoriteBooks;
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

    public function deleteFavorite(Request $request){
        User::find(Auth::user()->id)->favoriteBooks()->detach(Book::find($request->id));
       $data = [
            'success' => 'book delete from favorite'
        ];
        echo json_encode($data);
    }

    public function changeInfo(Request $request){
        $rules = [
            'new_name' => 'nullable|max:60',
            'new_surname' => 'nullable|max:60',
            'new_login' => 'nullable|max:60|unique:users,login',
            'new_mail' => 'nullable|email|unique:users,email',
            'new_img' => 'nullable|sometimes|image'
        ];
        $error = Validator::make($request->all(), $rules);
        if($error->fails()){
            $data = [
                'errors' => $error->errors()->all()
            ];
            echo json_encode($data);
        }
        else {
            $user = Auth::user();
            if($request->new_name != ''){
                $user->name = $request->new_name;
            }
            if($request->new_surname != ''){
                $user->surname = $request->new_surname;
            }
            if($request->new_login != ''){
                $user->login = $request->new_login;
            }
            if($request->new_mail != ''){
                $user->email = $request->new_mail;
            }
            if($request->new_img){
                $image = $request->file('new_img')->store('images', 'public');
                $url_img = Storage::url($image);
                $user->url_img = $url_img;
            }
            $user->save();
            $data = [
                'success' => 'Info changed'
            ];
            if(!$request->new_name && !$request->new_surname && !$request->new_login && !$request->new_mail && !$request->new_img){
                $data = [
                    'success' => 'Nothing to change'
                ];
            }
            echo json_encode($data);
        }
    }

    public function changePass(Request $request){
        $user = Auth::user();
        $password = $request->only([
            'current_password', 'new_password', 'new_password_confirmation'
        ]);

        $rules = [
            'current_password' => 'required|current_password_match',
            'new_password' => 'required|min:8|confirmed',
        ];
        $error = Validator::make($password, $rules);
        if($error->fails()){
            $data = [
                'errors' => $error->errors()->all()
            ];
            echo json_encode($data);
        }
        else{
            $user->password = Hash::make($password['new_password']);
            $user->save();
            $data = [
                'success' => 'Password changed'
            ];
            echo json_encode($data);
        }
    }
}

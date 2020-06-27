<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'description', 'writer', 'year', 'num_of_pages', 'url_book', 'url_img'
    ];

    public function categories(){
        return $this->belongsToMany(Category::class, 'book_category');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_book');
    }

}

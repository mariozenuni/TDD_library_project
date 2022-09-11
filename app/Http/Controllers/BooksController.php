<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
class BooksController extends Controller
{
    public function post()
    {
      
      request()->validate([
        'title' => 'required',
        'author' => 'required'
      ]);

          Book::create([
            'title' => request('title') ,
            'author' => request('author')
          ]);  
    }

    public function update(Book $book)
    { 
      request()->validate([
        'title' => 'required',
        'author' => 'required'
      ]);

      
      $book->update([
      'title' => request('title') ,
      'author' => request('author')
    ]); 

    }


}

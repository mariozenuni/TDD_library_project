<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
class BooksController extends Controller
{
    public function post()
    {
          Book::create([
            'title' => request('title') ,
            'author' => request('author')
          ]);  
    }
}

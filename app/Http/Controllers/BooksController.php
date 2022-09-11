<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BooksController extends Controller
{
    public function store()
    {   
       Book::create($this->validationRules());
    }
    public function update(Book $book)
    {   
        $book->update($this->validationRules());
    }

    private function validationRules()
    {
       return request()->validate([
            'title'=>'required',
            'author'=>'required'
        ]);
    }
}

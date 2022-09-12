<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BooksController extends Controller
{
    public function store()
    {   
      $book = Book::create($this->validationRules());
        
       return redirect($book->path());
    }
    public function update(Book $book)
    {   
        $book->update($this->validationRules());

        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect('/books');
    }

    private function validationRules()
    {
       return request()->validate([
            'title'=>'required',
            'author'=>'required'
        ]);
    }
}

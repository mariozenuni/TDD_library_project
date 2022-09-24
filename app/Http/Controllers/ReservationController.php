<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Book $book)
    {
        $user = Auth::user();
        $book->checkedOut($user);
    
        return redirect('/reservation/'.$book->id);
    }
}

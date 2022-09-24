<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\RedirectResponse;
class ReservationController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function checkOut(Book $book) : RedirectResponse
    {
        $book->checkedOut(Auth::user());
        return redirect('/reservation/'.$book->id);
    }

    public function checkIn(Book $book)
    {
        $book->checkedIn(Auth::user());
    
        return redirect('/reservation/'.$book->id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Auth::user()->books()->orderBy('created_at', 'desc')->get();

        return view('books.index', compact('books'));
    }

    public function show(Book $book)
    {
    }
}

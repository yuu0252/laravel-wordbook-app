<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
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
        return view('books.show', compact('book'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(BookRequest $request)
    {
        $book = new Book();
        $book->title = $request->input('title');
        $book->description = $request->input('description');
        $book->user_id = Auth::id();
        $book->save();

        return redirect()->route('books.index')->with('flash_message', '新しいブックが作成されました！');
    }
}

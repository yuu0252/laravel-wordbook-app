<?php

namespace App\Http\Controllers;

use App\Http\Requests\WordRequest;
use App\Models\Book;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{
  public function index(Book $book)
  {
    if ($book->user_id !== Auth::id()) {
      return redirect()->route('books.index')->with('error_message', '不正なアクセスです。');
    }

    $words = $book->words()->get();

    return view('words.index', compact('book', 'words'));
  }

  public function create(Book $book)
  {
    if ($book->user_id !== Auth::id()) {
      return redirect()->route('books.index');
    }

    return view('words.create', compact('book'));
  }

  public function store(Book $book, WordRequest $request)
  {
    $word = new Word();
    $word->english = $request->input('english');
    $word->japanese = $request->input('japanese');
    $word->memo = $request->input('memo');
    $word->book_id = $book->id;

    $word->save();

    return redirect()->route('books.words.index', $book)->with('flash_message', '新しい単語が追加されました！');
  }

  public function edit(Book $book, Word $word)
  {
    if ($book->user_id !== Auth::id()) {
      return redirect()->route('books.index')->with('error_message', '不正なアクセスです。');
    }

    return view('words.edit', compact('word'));
  }

  public function update(WordRequest $request, Book $book, Word $word)
  {
    if ($word->book->user_id !== Auth::id()) {
      return redirect()->route('books.index')->with('error_message', '不正なアクセスです。');
    };

    $word->english = $request->input('english');
    $word->japanese = $request->input('japanese');
    $word->memo = $request->input('memo');

    $word->save();

    return redirect()->route('books.words.index', ['book' => $word->book_id])->with('flash_message', '単語を編集しました！');
  }

  public function destroy(Book $book, Word $word)
  {
    if ($word->book->user_id !== Auth::id()) {
      return redirect()->route('books.index')->with('error_message', '不正なアクセスです。');
    }

    $word->delete();

    return redirect()->route('books.words.index', $book)->with('flash_message', 'ワードを削除しました。');
  }
}

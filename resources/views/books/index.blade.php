@extends('layouts.app')

@section('title', 'ブック一覧')

@section('content')
    <h1>ブック一覧</h1>

    @if (session('flash_message'))
        <p>{{ session('flash_message') }}</p>
    @endif

    @if ($books->isNotEmpty())
        @foreach ($books as $book)
            <article>
                <h2>{{ $book->title }}</h2>
                <p>{{ $book->description }}</p>
                <a href="{{ route('books.show', $book) }}">詳細</a>
            </article>
            {{ dd($books) }}
        @endforeach
    @else
        <p>ブックはまだありません。</p>
    @endif
@endsection

@extends('layouts.app')

@section('title', 'ブック一覧')

@section('content')
    <h1>ブック一覧</h1>

    @if (session('flash_message'))
        <p>{{ session('flash_message') }}</p>
    @endif

    @if (session('error_message'))
        <p>{{ session('error_message') }}</p>
    @endif

    <a href="{{ route('books.create') }}">新規作成</a>

    @if ($books->isNotEmpty())
        @foreach ($books as $book)
            <article>
                <h2>{{ $book->title }}</h2>
                <p>{{ $book->description }}</p>
                <a href="{{ route('books.show', $book) }}">詳細</a>
                <a href="{{ route('books.edit', $book) }}">編集</a>

                <form action="{{ route('books.destroy', $book) }}" method="POST"
                    onsubmit="return confirm('本当に削除してもよろしいですか？');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
                </form>
            </article>
        @endforeach
    @else
        <p>ブックはまだありません。</p>
    @endif
@endsection

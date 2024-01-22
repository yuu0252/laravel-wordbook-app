@extends('layouts.app')

@section('title', 'ブック一覧')

@section('content')
    <h1 class="fs-2 my-3">ブック一覧</h1>

    @if (session('flash_message'))
        <p class="text-success">{{ session('flash_message') }}</p>
    @endif

    @if (session('error_message'))
        <p class="test-danger">{{ session('error_message') }}</p>
    @endif

    <div class="mb-2">
        <a class="text-decoration-none" href="{{ route('books.create') }}">新規作成</a>
    </div>

    @if ($books->isNotEmpty())
        @foreach ($books as $book)
            <article>
                <div class="card mb-3">
                    <div class="card-body">
                        <a class="text-decoration-none text-dark" href="{{ route('books.words.index', $book) }}">
                            <h2 class="card-title fs-5">{{ $book->title }}</h2>
                            <p class="card-text">{{ $book->description }}</p>
                            <div class="d-flex">
                                <a class="btn btn-outline-primary d-block me-1"
                                    href="{{ route('books.edit', $book) }}">編集</a>

                                <form action="{{ route('books.destroy', $book) }}" method="POST"
                                    onsubmit="return confirm('本当に削除してもよろしいですか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">削除</button>
                                </form>
                            </div>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    @else
        <p>ブックはまだありません。</p>
    @endif
@endsection

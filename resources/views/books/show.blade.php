@extends('layouts.app')

@section('title', 'ブック詳細')

@section('content')
    <h1 class="fs-2 my-3">ブック詳細</h1>

    @if (session('flash_message'))
        <p class="text-success">{{ session('flash_message') }}</p>
    @endif

    <div class="mb-2">
        <a class="text-decoration-none" href="{{ route('books.index') }}">&lt; 戻る</a>
    </div>

    <article>
        <div class="card mb-3">
            <div class="card-body">
                <h2 class="card-title fs-5">{{ $book->title }}</h2>
                <p class="card-text">{{ $book->description }}</p>

                @if ($book->user_id === Auth::id())
                    <div class="d-flex">
                        <a class="btn btn-outline-primary d-block me-1" href="{{ route('books.edit', $book) }}">編集</a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST"
                            onsubmit="return confirm('本当に削除してもよろしいですか？');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger" type="submit">削除</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </article>
@endsection

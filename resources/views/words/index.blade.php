@extends('layouts.app')

@section('title', '単語一覧')

@section('content')
    <h1 class="fs-2 my-3">単語一覧</h1>

    @if (session('flash_message'))
        <p class="text-success">{{ session('flash_message') }}</p>
    @endif

    @if (session('error_message'))
        <p class="test-danger">{{ session('error_message') }}</p>
    @endif

    <div class="mb-2">
        <a class="text-decoration-none" href="{{ route('words.create', $book) }}">新規作成</a>
    </div>

    @if ($words->isNotEmpty())
        @foreach ($words as $word)
            <article>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="card-title fs-5">{{ $word->japanese }}</h2>
                        <p class="card-text">{{ $word->english }}</p>
                        {{-- <div class="d-flex">
                                <a class="btn btn-outline-primary d-block me-1"
                                    href="{{ route('words.edit', $book, $word) }}">編集</a>

                                <form action="{{ route('words.destroy', $book, $word) }}" method="POST"
                                    onsubmit="return confirm('本当に削除してもよろしいですか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">削除</button>
                                </form>
                            </div> --}}
                    </div>
                </div>
            </article>
        @endforeach
    @else
        <p>単語はまだありません。</p>
    @endif
@endsection

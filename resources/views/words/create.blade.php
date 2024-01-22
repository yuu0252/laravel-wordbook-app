@extends('layouts.app')

@section('title', '単語作成')

@section('content')
    <h1 class="fs-2 my-3">単語作成</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-2">
        <a class="text-decoration-none" href="{{ route('books.words.index', $book) }}">&lt; 戻る</a>
    </div>

    <form class="row g-3" action="{{ route('books.words.store', $book) }}" method="POST">
        @csrf
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label">英語</label>
            <input type="text" class="form-control" id="validationDefault01" name="english" value="{{ old('english') }}"
                required>
        </div>
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label">日本語</label>
            <input type="text" class="form-control" id="validationDefault01" name="japanese"
                value="{{ old('japanese') }}" required>
        </div>
        <div class="col-md-4">
            <label for="validationDefault02" class="form-label">メモ</label>
            <textarea type="text" class="form-control" id="validationDefault02" name="memo" value="{{ old('memo') }}"></textarea>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">作成</button>
        </div>
    </form>

@endsection

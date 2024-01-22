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
        <a class="text-decoration-none" href="{{ route('words.index', ['book' => $word->book->id]) }}">&lt; 戻る</a>
    </div>

    <form class="row g-3" action="{{ route('words.store', ['book' => $word->book->id]) }}" method="POST">
        @csrf
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label">英語</label>
            <input type="text" class="form-control" id="validationDefault01" name="english"
                value="{{ old('english', $word->english) }}" required>
        </div>
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label">日本語</label>
            <input type="text" class="form-control" id="validationDefault01" name="japanese"
                value="{{ old('japanese', $word->japanese) }}" required>
        </div>
        <div class="col-md-4">
            <label for="validationDefault02" class="form-label">メモ</label>
            <textarea type="text" class="form-control" id="validationDefault02" name="memo"
                value="{{ old('memo', $word->memo) }}"></textarea>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">編集</button>
        </div>
    </form>

@endsection

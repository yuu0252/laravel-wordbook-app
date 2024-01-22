@extends('layouts.app')

@section('title', 'ブック編集ページ')

@section('content')

    <h1 class="fs-2 my-3">投稿編集</h1>

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
        <a class="text-decoration-none" href="{{ route('books.index') }}">&lt; 戻る</a>
    </div>

    <form action="{{ route('books.update', $book) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label">タイトル</label>
            <input type="text" class="form-control" id="validationDefault01" name="title" value="{{ old('title') }}"
                required>
        </div>
        <div class="col-md-4">
            <label for="validationDefault02" class="form-label">このブックについて</label>
            <textarea type="text" class="form-control" id="validationDefault02" name="description"
                value="{{ old('description') }}" required></textarea>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">更新</button>
        </div>
    </form>
@endsection

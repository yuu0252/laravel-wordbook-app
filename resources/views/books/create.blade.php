@extends('layouts.app')

@section('title', 'ブック作成')

@section('content')
    <h1>ブック作成</h1>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('books.index') }}">&lt; 戻る</a>

    <form class="row g-3" action="{{ route('books.store') }}" method="POST">
        @csrf
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label">タイトル</label>
            <input type="text" class="form-control" id="validationDefault01" name="title" required>
        </div>
        <div class="col-md-4">
            <label for="validationDefault02" class="form-label">このブックについて</label>
            <textarea type="text" class="form-control" id="validationDefault02" name="description" required></textarea>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">作成</button>
        </div>
    </form>

@endsection

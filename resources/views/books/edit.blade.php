@extends('layouts.app')

@section('title', 'ブック編集ページ')

@section('content')

<h1>投稿編集</h1>

@if($errors->any())
<ul>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

<a href="{{ route('books.index')}}">&lt; 戻る</a>

<form action="{{ route('books.update', $book)}}" method="POST">
@csrf
@method('PATCH')
<div>
    <label for="title">タイトル</label>
    <input type="text" id="title" name="title" value="{{ old('title', $book->title)}}">
</div>
<div>
    <label for="description">このブックについて</label>
    <textarea name="description" id="description">{{ old('description', $book->description)}}</textarea>
</div>
<button type="submit">更新</button>
</form>
@endsection
@extends('layouts.app')

@section('title', 'ブック詳細')

@section('content')
<h1>ブック詳細</h1>
<a href="{{ route('books.index') }}">&lt; 戻る</a>

<article>
    <h2>{{$book->title}}</h2>
    <p>{{ $book->description }}</p>
</article>
@endsection
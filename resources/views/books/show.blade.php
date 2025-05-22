@extends('layout')

@section('content')
    <h1>Book #{{ $book->id }}</h1>
    <p>Title: {{ $book->title }}</p>
    <p>Isbn: {{ $book->isbn }}</p>
    <p>Name: {{ $book->author->name }}</p>
    <a href="{{ route('books.edit', $book) }}">Edit</a>
    {{ include('books/_delete_form') }}
    <br><a href="{{ route('books.index') }}">Back to list</a>
@endsection

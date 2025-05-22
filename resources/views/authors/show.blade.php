@extends('layout')

@section('content')
    <h1>Author #{{ $author->id }}</h1>
    <p>Name: {{ $author->name }}</p>
    <a href="{{ route('authors.edit', $author) }}">Edit</a>
    {{ include('authors/_delete_form') }}
    <br><a href="{{ route('authors.index') }}">Back to list</a>
@endsection

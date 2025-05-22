@extends('layout')

@section('content')
    <h1>Edit Author #{{ $author->id }}</h1>
    <form action="{{ route('authors.update', $author) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Name</label><br>
        <input type="text" name="name" value="{{ old('name', $author->name) }}"><br>
        @error('name')
        <div>{{ $message }}</div>@enderror

        <button type="submit">Update</button>
    </form>
    <a href="{{ route('authors.index') }}">Back to list</a>
@endsection

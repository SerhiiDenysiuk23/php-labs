@extends('layout')

@section('content')
    <h1>Edit Book #{{ $book->id }}</h1>
    <form action="{{ route('books.update', $book) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Title</label><br>
        <input type="text" name="title" value="{{ old('title', $book->title) }}"><br>
        @error('title')
        <div>{{ $message }}</div>@enderror

        <label>Isbn</label><br>
        <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}"><br>
        @error('isbn')
        <div>{{ $message }}</div>@enderror

        <label>Name</label><br>
        <select name="author_id">
            @foreach($authors as $author)
                <option value="{{ $author->id }}"
                        @if(old('author_id', $book->author_id)==$author->id) selected @endif>{{ $author->id }}</option>
            @endforeach
        </select><br>
        @error('name')
        <div>{{ $message }}</div>@enderror

        <button type="submit">Update</button>
    </form>
    <a href="{{ route('books.index') }}">Back to list</a>
@endsection

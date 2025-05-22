@extends('layout')

@section('content')
    <h1>Create Book</h1>
    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        <label>Title</label><br>
        <input type="text" name="title" placeholder="{{ old('title') }}"><br>
        @error('title')
        <div>{{ $message }}</div>@enderror

        <label>Isbn</label><br>
        <input type="text" name="isbn" value="{{ old('isbn') }}"><br>
        @error('isbn')
        <div>{{ $message }}</div>@enderror

        <label>Name</label><br>
        <select name="author_id">
            @foreach($authors as $author)
                <option value="{{ $author->id }}">{{ $author->id }}</option>
            @endforeach
        </select><br>
        @error('name')
        <div>{{ $message }}</div>@enderror

        <button type="submit">Save</button>
    </form>
    <a href="{{ route('books.index') }}">Back to list</a>
@endsection

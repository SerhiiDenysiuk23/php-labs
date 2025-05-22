@extends('layout')

@section('content')
    <h1>Create Issue</h1>
    <form action="{{ route('issues.store') }}" method="POST">
        @csrf
        <label>Title</label><br>
        <select name="book_id">
            @foreach($books as $book)
                <option value="{{ $book->id }}">{{ $book->id }}</option>
            @endforeach
        </select><br>
        @error('title')
        <div>{{ $message }}</div>@enderror

        <label>Name</label><br>
        <select name="reader_id">
            @foreach($readers as $reader)
                <option value="{{ $reader->id }}">{{ $reader->id }}</option>
            @endforeach
        </select><br>
        @error('name')
        <div>{{ $message }}</div>@enderror

        <label>Issued at</label><br>
        <input type="text" name="issued_at" value="{{ old('issued_at') }}"><br>
        @error('issued_at')
        <div>{{ $message }}</div>@enderror

        <button type="submit">Save</button>
    </form>
    <a href="{{ route('issues.index') }}">Back to list</a>
@endsection

@extends('layout')

@section('content')
    <h1>Edit Issue #{{ $issue->id }}</h1>
    <form action="{{ route('issues.update', $issue) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Title</label><br>
        <select name="book_id">
            @foreach($books as $book)
                <option value="{{ $book->id }}"
                        @if(old('book_id', $issue->book_id)==$book->id) selected @endif>{{ $book->id }}</option>
            @endforeach
        </select><br>
        @error('title')
        <div>{{ $message }}</div>@enderror

        <label>Name</label><br>
        <select name="reader_id">
            @foreach($readers as $reader)
                <option value="{{ $reader->id }}"
                        @if(old('reader_id', $issue->reader_id)==$reader->id) selected @endif>{{ $reader->id }}</option>
            @endforeach
        </select><br>
        @error('name')
        <div>{{ $message }}</div>@enderror

        <label>Issued at</label><br>
        <input type="text" name="issued_at" value="{{ old('issued_at', $issue->issued_at) }}"><br>
        @error('issued_at')
        <div>{{ $message }}</div>@enderror

        <button type="submit">Update</button>
    </form>
    <a href="{{ route('issues.index') }}">Back to list</a>
@endsection

@extends('layout')

@section('content')
    <h1>Create Author</h1>
    <form action="{{ route('authors.store') }}" method="POST">
        @csrf
        <label>Name</label><br>
        <input type="text" name="name" value="{{ old('name') }}"><br>
        @error('name')
        <div>{{ $message }}</div>@enderror

        <button type="submit">Save</button>
    </form>
    <a href="{{ route('authors.index') }}">Back to list</a>
@endsection

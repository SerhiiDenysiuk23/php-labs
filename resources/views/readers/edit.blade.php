@extends('layout')

@section('content')
    <h1>Edit Reader #{{ $reader->id }}</h1>
    <form action="{{ route('readers.update', $reader) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Name</label><br>
        <input type="text" name="name" value="{{ old('name', $reader->name) }}"><br>
        @error('name')
        <div>{{ $message }}</div>@enderror

        <label>Email</label><br>
        <input type="text" name="email" value="{{ old('email', $reader->email) }}"><br>
        @error('email')
        <div>{{ $message }}</div>@enderror

        <button type="submit">Update</button>
    </form>
    <a href="{{ route('readers.index') }}">Back to list</a>
@endsection

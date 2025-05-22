@extends('layout')

@section('content')
    <h1>Create Reader</h1>
    <form action="{{ route('readers.store') }}" method="POST">
        @csrf
        <label>Name</label><br>
        <input type="text" name="name" value="{{ old('name') }}"><br>
        @error('name')
        <div>{{ $message }}</div>@enderror

        <label>Email</label><br>
        <input type="text" name="email" value="{{ old('email') }}"><br>
        @error('email')
        <div>{{ $message }}</div>@enderror

        <button type="submit">Save</button>
    </form>
    <a href="{{ route('readers.index') }}">Back to list</a>
@endsection

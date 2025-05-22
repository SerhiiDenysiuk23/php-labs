@extends('layout')

@section('content')
    <h1>Reader #{{ $reader->id }}</h1>
    <p>Name: {{ $reader->name }}</p>
    <p>Email: {{ $reader->email }}</p>
    <a href="{{ route('readers.edit', $reader) }}">Edit</a>
    {{ include('readers/_delete_form') }}
    <br><a href="{{ route('readers.index') }}">Back to list</a>
@endsection

@extends('layout')

@section('content')
    <h1>Return #{{ $bookReturn->id }}</h1>
    <p>Title: {{ $bookReturn->bookIssue->book }}</p>
    <p>Name: {{ $bookReturn->bookIssue->reader }}</p>
    <p>Returned at: {{ $bookReturn->returned_at }}</p>
    <a href="{{ route('returns.edit', $bookReturn) }}">Edit</a>
    {{ include('returns/_delete_form') }}
    <br><a href="{{ route('returns.index') }}">Back to list</a>
@endsection

@extends('layout')

@section('content')
    <h1>Issue #{{ $issue->id }}</h1>
    <p>Title: {{ $issue->book->title }}</p>
    <p>Name: {{ $issue->reader->name }}</p>
    <p>Issued at: {{ $issue->issued_at }}</p>
    <a href="{{ route('issues.edit', $issue) }}">Edit</a>
    {{ include('issues/_delete_form') }}
    <br><a href="{{ route('issues.index') }}">Back to list</a>
@endsection

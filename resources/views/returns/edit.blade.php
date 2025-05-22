@extends('layout')

@section('content')
    <h1>Edit Return #{{ $bookReturn->id }}</h1>
    <form action="{{ route('returns.update', $bookReturn) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Title</label><br>
        <select name="bookIssue_id">
            @foreach($bookIssues as $bookIssue)
                <option value="{{ $bookIssue->id }}"
                        @if(old('bookIssue_id', $bookReturn->bookIssue_id)==$bookIssue->id) selected @endif>{{ $bookIssue->id }}</option>
            @endforeach
        </select><br>
        @error('title')
        <div>{{ $message }}</div>@enderror

        <label>Name</label><br>
        <select name="bookIssue_id">
            @foreach($bookIssues as $bookIssue)
                <option value="{{ $bookIssue->id }}"
                        @if(old('bookIssue_id', $bookReturn->bookIssue_id)==$bookIssue->id) selected @endif>{{ $bookIssue->id }}</option>
            @endforeach
        </select><br>
        @error('name')
        <div>{{ $message }}</div>@enderror

        <label>Returned at</label><br>
        <input type="text" name="returned_at" value="{{ old('returned_at', $return->returned_at) }}"><br>
        @error('returned_at')
        <div>{{ $message }}</div>@enderror

        <button type="submit">Update</button>
    </form>
    <a href="{{ route('returns.index') }}">Back to list</a>
@endsection

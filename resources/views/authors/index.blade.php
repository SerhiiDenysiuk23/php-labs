@extends('layout')

@section('content')
    <h1>Authors</h1>
    <a href="{{ route('authors.create') }}">+ New Author</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($authors as $author)
            <tr>
                <td>{{ $author->id }}</td>
                <td>{{ $author->name }}</td>
                <td>
                    <a href="{{ route('authors.show', $author) }}">Show</a> |
                    <a href="{{ route('authors.edit', $author) }}">Edit</a> |
                    <form action="{{ route('authors.destroy', $author) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

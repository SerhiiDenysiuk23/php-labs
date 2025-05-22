@extends('layout')

@section('content')
    <h1>Issues</h1>
    <a href="{{ route('issues.create') }}">+ New Issue</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Name</th>
            <th>Issued at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($issues as $issue)
            <tr>
                <td>{{ $issue->id }}</td>
                <td>{{ $issue->book->title }}</td>
                <td>{{ $issue->reader->name }}</td>
                <td>{{ $issue->issued_at }}</td>
                <td>
                    <a href="{{ route('issues.show', $issue) }}">Show</a> |
                    <a href="{{ route('issues.edit', $issue) }}">Edit</a> |
                    <form action="{{ route('issues.destroy', $issue) }}" method="POST" style="display:inline">
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

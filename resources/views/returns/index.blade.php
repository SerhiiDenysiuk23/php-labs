@extends('layout')

@section('content')
    <h1>Returns</h1>
    <a href="{{ route('returns.create') }}">+ New Return</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Name</th>
            <th>Returned at</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($returns as $bookReturn)
            <tr>
                <td>{{ $bookReturn->id }}</td>
                <td>{{ $bookReturn->bookIssue->book }}</td>
                <td>{{ $bookReturn->bookIssue->reader }}</td>
                <td>{{ $bookReturn->returned_at }}</td>
                <td>
                    <a href="{{ route('returns.show', $bookReturn) }}">Show</a> |
                    <a href="{{ route('returns.edit', $bookReturn) }}">Edit</a> |
                    <form action="{{ route('returns.destroy', $bookReturn) }}" method="POST" style="display:inline">
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

@extends('layout')

@section('content')
    <h1>Readers</h1>
    <a href="{{ route('readers.create') }}">+ New Reader</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($readers as $reader)
            <tr>
                <td>{{ $reader->id }}</td>
                <td>{{ $reader->name }}</td>
                <td>{{ $reader->email }}</td>
                <td>
                    <a href="{{ route('readers.show', $reader) }}">Show</a> |
                    <a href="{{ route('readers.edit', $reader) }}">Edit</a> |
                    <form action="{{ route('readers.destroy', $reader) }}" method="POST" style="display:inline">
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

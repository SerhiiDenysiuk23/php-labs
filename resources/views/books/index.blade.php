@extends('layout')

@section('content')
    <h1>Books</h1>
  <form method="GET" class="mb-3">
    <label for="per_page">Show per page:</label>
    <select name="per_page" id="per_page" onchange="this.form.submit()" class="form-select w-auto d-inline-block ms-2">
      @foreach($allowed as $n)
        <option value="{{ $n }}" {{ $perPage == $n ? 'selected' : '' }}>{{ $n }}</option>
      @endforeach
    </select>
  </form>
    <a href="{{ route('books.create') }}">+ New Book</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Isbn</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->isbn }}</td>
                <td>{{ $book->author->name }}</td>
                <td>
                    <a href="{{ route('books.show', $book) }}">Show</a> |
                    <a href="{{ route('books.edit', $book) }}">Edit</a> |
                    <form action="{{ route('books.destroy', $book) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
  <div>{{ $books->links() }}</div>
@endsection

@extends('layout')

@section('content')
    <h1>Readers</h1>
  <form method="GET" class="mb-3">
    <label for="per_page">Show per page:</label>
    <select name="per_page" id="per_page" onchange="this.form.submit()" class="form-select w-auto d-inline-block ms-2">
      @foreach($allowed as $n)
        <option value="{{ $n }}" {{ $perPage == $n ? 'selected' : '' }}>{{ $n }}</option>
      @endforeach
    </select>
  </form>
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
  <div>{{ $readers->links() }}</div>
@endsection

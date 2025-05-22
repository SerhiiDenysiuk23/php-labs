<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Library System')</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-..."
        crossorigin="anonymous"
    >
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Library</a>
        <div>
            <a class="nav-link d-inline" href="{{ route('authors.index') }}">Authors</a>
            <a class="nav-link d-inline" href="{{ route('books.index') }}">Books</a>
            <a class="nav-link d-inline" href="{{ route('readers.index') }}">Readers</a>
            <a class="nav-link d-inline" href="{{ route('issues.index') }}">Issues</a>
            <a class="nav-link d-inline" href="{{ route('returns.index') }}">Returns</a>
        </div>
    </div>
</nav>

<div class="container">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-..."
        crossorigin="anonymous">
</script>
</body>
</html>

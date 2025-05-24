<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Author::class, 'author');
    }


    public function index(Request $request)
    {
        // Pagination setup
        $perPage = $request->input('per_page', 10);
        $allowed = [5, 10, 25, 50, 100];
        if (!in_array($perPage, $allowed)) {
            $perPage = 10;
        }

        // Query with pagination
        $authors = Author::paginate($perPage)
            ->appends(['per_page' => $perPage]);

        return view('authors.index', compact('authors', 'perPage', 'allowed'));
    }




    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Author::create($data);

        return redirect()->route('authors.index')
            ->with('success', 'Author created.');
    }

    public function show(Author $author)
    {
        return view('authors.show', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author->update($data);

        return redirect()->route('authors.index')
            ->with('success', 'Author updated.');
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('authors.index')
            ->with('success', 'Author deleted.');
    }
}

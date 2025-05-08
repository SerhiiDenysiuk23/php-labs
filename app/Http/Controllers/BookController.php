<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')->paginate(15);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        return view('books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'isbn'      => 'required|string|size:13|unique:books',
            'author_id' => 'required|exists:authors,id',
        ]);

        Book::create($data);

        return redirect()->route('books.index')
            ->with('success', 'Book created.');
    }

    public function show(Book $book)
    {
        $book->load('author', 'issues');
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::all();
        return view('books.edit', compact('book', 'authors'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:255',
            'isbn'      => "required|string|size:13|unique:books,isbn,{$book->id}",
            'author_id' => 'required|exists:authors,id',
        ]);

        $book->update($data);

        return redirect()->route('books.index')
            ->with('success', 'Book updated.');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Reader;
use Illuminate\Http\Request;

class BookIssueController extends Controller
{
    public function index()
    {
        $issues = BookIssue::with(['book', 'reader'])->paginate(15);
        return view('issues.index', compact('issues'));
    }

    public function create()
    {
        $books   = Book::all();
        $readers = Reader::all();
        return view('issues.create', compact('books', 'readers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id'   => 'required|exists:books,id',
            'reader_id' => 'required|exists:readers,id',
            'issued_at' => 'required|date',
        ]);

        BookIssue::create($data);

        return redirect()->route('issues.index')
            ->with('success', 'Book issued.');
    }

    public function show(BookIssue $issue)
    {
        return view('issues.show', compact('issue'));
    }

    public function edit(BookIssue $issue)
    {
        $books   = Book::all();
        $readers = Reader::all();
        return view('issues.edit', compact('issue', 'books', 'readers'));
    }

    public function update(Request $request, BookIssue $issue)
    {
        $data = $request->validate([
            'book_id'   => 'required|exists:books,id',
            'reader_id' => 'required|exists:readers,id',
            'issued_at' => 'required|date',
        ]);

        $issue->update($data);

        return redirect()->route('issues.index')
            ->with('success', 'Issue updated.');
    }

    public function destroy(BookIssue $issue)
    {
        $issue->delete();

        return redirect()->route('issues.index')
            ->with('success', 'Issue deleted.');
    }
}

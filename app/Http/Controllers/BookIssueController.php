<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Reader;
use Illuminate\Http\Request;

class BookIssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(BookIssue::class, 'issue');
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
        $issues = BookIssue::with(['book', 'reader'])->paginate($perPage)
            ->appends(['per_page' => $perPage]);

        return view('issues.index', compact('issues', 'perPage', 'allowed'));
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

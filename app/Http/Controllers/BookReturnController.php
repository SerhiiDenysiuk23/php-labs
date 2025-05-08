<?php

namespace App\Http\Controllers;

use App\Models\BookIssue;
use App\Models\BookReturn;
use Illuminate\Http\Request;

class BookReturnController extends Controller
{
    public function index()
    {
        $returns = BookReturn::with('bookIssue.book', 'bookIssue.reader')
            ->paginate(15);
        return view('returns.index', compact('returns'));
    }

    public function create()
    {
        $issues = BookIssue::all();
        return view('returns.create', compact('issues'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'book_issue_id' => 'required|exists:book_issues,id',
            'returned_at'   => 'required|date',
        ]);

        BookReturn::create($data);

        return redirect()->route('returns.index')
            ->with('success', 'Book returned.');
    }

    public function show(BookReturn $return)
    {
        return view('returns.show', compact('return'));
    }

    public function edit(BookReturn $return)
    {
        $issues = BookIssue::all();

        return view('returns.edit', compact('return', 'issues'));
    }

    public function update(Request $request, BookReturn $return)
    {
        $data = $request->validate([
            'book_issue_id' => 'required|exists:book_issues,id',
            'returned_at'   => 'required|date',
        ]);

        $return->update($data);

        return redirect()->route('returns.index')
            ->with('success', 'Return updated.');
    }

    public function destroy(BookReturn $return)
    {
        $return->delete();

        return redirect()->route('returns.index')
            ->with('success', 'Return deleted.');
    }
}

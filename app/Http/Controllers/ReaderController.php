<?php

namespace App\Http\Controllers;

use App\Models\Reader;
use Illuminate\Http\Request;

class ReaderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Reader::class, 'reader');
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
        $readers = Reader::paginate($perPage)
            ->appends(['per_page' => $perPage]);

        return view('readers.index', compact('readers', 'perPage', 'allowed'));
    }




    public function create()
    {
        return view('readers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:readers,email',
        ]);

        Reader::create($data);

        return redirect()->route('readers.index')
            ->with('success', 'Reader created.');
    }

    public function show(Reader $reader)
    {
        return view('readers.show', compact('reader'));
    }

    public function edit(Reader $reader)
    {
        return view('readers.edit', compact('reader'));
    }

    public function update(Request $request, Reader $reader)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => "required|email|unique:readers,email,{$reader->id}",
        ]);

        $reader->update($data);

        return redirect()->route('readers.index')
            ->with('success', 'Reader updated.');
    }

    public function destroy(Reader $reader)
    {
        $reader->delete();

        return redirect()->route('readers.index')
            ->with('success', 'Reader deleted.');
    }
}

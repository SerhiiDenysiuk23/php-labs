<?php

namespace App\Http\Controllers;

use App\Models\Reader;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    public function index()
    {
        $readers = Reader::all();
        return view('readers.index', compact('readers'));
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

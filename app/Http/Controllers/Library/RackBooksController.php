<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Domain;
use App\Models\Language;
use App\Models\Rack;
use Exception;
use Illuminate\Http\Request;

class RackBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        //
        $rack = Rack::findOrFail($id);
        return view('library.rack-books.index', compact('rack'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($rackId, string $id)
    {
        //
        $book = Book::findOrFail($id);
        $rack = Rack::findOrFail($rackId);
        return view('library.rack-books.show', compact('rack', 'book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($rackId, string $id)
    {
        //
        $rack = Rack::findOrFail($rackId);
        $book = Book::findOrFail($id);
        $languages = Language::all();
        $domains = Domain::all();
        return view('library.rack-books.edit', compact('rack', 'book', 'languages', 'domains'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $rackId, string $id)
    {
        //
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'publish_year' => 'required',
            'language_id' => 'required',
            'num_of_copies' => 'required',
            'price' => 'required|min:0',
            'domain_id' => 'required',
            'language_id' => 'required',
        ]);
        try {
            $rack = rack::findOrFail($rackId);
            $book = $rack->books()->find($id)->update($request->all());
            return redirect()->route('library.rack.books.index', $rackId)->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($rackId, string $id)
    {
        //
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return redirect()->route('library.rack.books.index', $rackId)->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}

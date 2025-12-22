<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Domain;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $filtered = false;
        if (session('books')) {
            $books = session('books');
            $filtered = true;
        } else
            $books = Book::all();

        $domains = Domain::all();
        return view('library.books.index', compact('books', 'domains', 'filtered'));
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
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //

    }

    public function search(Request $request)
    {
        $books = Book::where('title', 'like', '%' . $request->searchby . '%')->get();
        return redirect()->route('library.books.index')->with('books', $books);
    }
}

<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Rack;
use App\Models\Domain;
use App\Models\Language;
use Egulias\EmailValidator\Parser\DomainPart;
use Exception;
use Illuminate\Http\Request;

class DomainBooksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($domainId)
    {
        //
        $domain = Domain::findOrFail($domainId);
        return view('library.domain-books.index', compact('domain'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($domainId)
    {
        //
        $domain = Domain::findOrFail($domainId);
        $languages = Language::all();
        $racks = Rack::all();
        return view('library.domain-books.create', compact('domain', 'languages', 'racks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($domainId, Request $request)
    {
        //
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'publish_year' => 'required',
            'language_id' => 'required',
            'num_of_copies' => 'required',
            'price' => 'required|min:0',
            'rack_id' => 'required',
            'language_id' => 'required',
        ]);
        try {
            $domain = Domain::findOrFail($domainId);
            $book = $domain->books()->create($request->all());
            return redirect()->route('library.domain.books.index', $domainId)->with(
                [
                    'success' => 'Successfully added',
                    'recent_language_id' => $book->language_id,
                    'recent_rack_id' => $book->rack_id,
                ]
            );
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($domainId, string $id)
    {
        //
        $book = Book::findOrFail($id);
        $domain = Domain::findOrFail($domainId);
        return view('library.domain-books.show', compact('domain', 'book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($domainId, string $id)
    {
        //
        $book = Book::findOrFail($id);
        $domain = Domain::findOrFail($domainId);
        $languages = Language::all();
        $racks = Rack::all();
        return view('library.domain-books.edit', compact('domain', 'book', 'languages', 'racks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $domainId, string $id)
    {
        //
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'publish_year' => 'required',
            'language_id' => 'required',
            'num_of_copies' => 'required',
            'price' => 'required|min:0',
            'rack_id' => 'required',
            'language_id' => 'required',
        ]);
        try {
            $domain = Domain::findOrFail($domainId);
            $book = $domain->books()->find($id)->update($request->all());
            return redirect()->route('library.domain.books.index', $domainId)->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($domainId, string $id)
    {
        //
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return redirect()->route('library.domain.books.index', $domainId)->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}

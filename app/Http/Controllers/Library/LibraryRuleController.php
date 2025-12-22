<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\LibraryRule;
use Exception;
use Illuminate\Http\Request;

class LibraryRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $libraryRules = LibraryRule::all();
        return view('library.library-rules.index', compact('libraryRules'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $libraryRule = LibraryRule::findOrFail($id);
        return view('library.library-rules.edit', compact('libraryRule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'max_books' => 'required',
            'max_days' => 'required',
            'fine_per_day' => 'required',
        ]);
        try {
            $libraryRule = LibraryRule::findOrFail($id);
            $libraryRule->update($request->all());
            return redirect()->route('library.library-rules.index')->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

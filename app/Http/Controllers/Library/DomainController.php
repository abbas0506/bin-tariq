<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;

use App\Models\Domain;
use Exception;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $domains = Domain::all();
        return view('library.domains.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('library.domains.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
        ]);
        try {
            Domain::create($request->all());
            return redirect()->route('library.domains.index')->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(domain $domain)
    {
        //
        return view('library.domains.show', compact('domain'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(domain $domain)
    {
        //
        return view('library.domains.edit', compact('domain'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, domain $domain)
    {
        //
        $request->validate([
            'name' => 'required',
        ]);
        try {
            $domain->update($request->all());
            return redirect()->route('library.domains.index')->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(domain $domain)
    {
        //
        try {
            $domain->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}

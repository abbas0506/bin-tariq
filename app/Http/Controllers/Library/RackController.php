<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Rack;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Str;

class RackController extends Controller
{

    public function index()
    {
        //
        // $racks = Rack::has('books')->get();
        $racks = Rack::all();
        $books = Book::all();
        return view('library.racks.index', compact('racks', 'books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('library.racks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'label' => 'required',
        ]);
        try {
            Rack::create($request->all());
            return redirect()->route('library.racks.index')->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(rack $rack)
    {
        //
        $rack = $rack;
        return view('library.racks.show', compact('rack'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $rack = Rack::findOrFail($id);
        return view('library.racks.edit', compact('rack'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, rack $rack)
    {
        //
        $request->validate([
            'label' => 'required',
        ]);
        try {
            $rack->update($request->all());
            return redirect()->route('library.racks.index')->with('success', 'Successfully updated');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rack $rack)
    {
        //
        try {
            $rack->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function print($id)
    {
        $rack = Rack::findOrFail($id);

        $pdf = PDF::loadview('library.pdf.rack-wise-books', compact('rack'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);
        $file = Str::lower($rack->title) . "-list of books.pdf";
        return $pdf->stream($file);
    }
}

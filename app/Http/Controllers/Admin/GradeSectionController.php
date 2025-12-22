<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class GradeSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        //
        $grade = Grade::findOrFail($id);
        $users = User::whereRelation('roles', 'name', 'teacher')->get();
        return view('admin.sections.create', compact('grade', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'starts_at' => 'required|date',
            'incharge_id' => 'nullable|numeric',
        ]);

        $request->merge([
            'ends_at' => Carbon::parse($request->starts_at)->addYears(2),
        ]);
        $grade = Grade::findOrFail($id);

        try {
            $grade->sections()->create($request->all());
            // Section::create($request->all());
            return redirect()->route('admin.sections.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
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
    public function destroy(string $id)
    {
        //
    }
}

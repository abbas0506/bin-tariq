<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class InchargeController extends Controller
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
        $section = Section::findOrFail($id);
        $users = User::whereRelation('roles', 'name', 'teacher')->get();
        return view('admin.incharges.edit', compact('section', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'incharge_id' => 'nullable|numeric',

        ]);
        $section = Section::findOrFail($id);

        try {

            $section->update([
                'incharge_id' => $request->incharge_id,
            ]);

            return redirect()->route('admin.section.lecture.schedule.index', [0, 0])->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
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

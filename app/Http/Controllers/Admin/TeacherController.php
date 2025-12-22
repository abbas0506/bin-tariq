<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $teachers = Teacher::all();
        return view('admin.teachers.index', compact('teachers'));
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
        $teacher = Teacher::findOrFail($id);
        $roles = Role::all();
        return view('admin.teachers.show', compact('teacher', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $teacher = Teacher::findOrFail($id);
        $roles = Role::all();
        return view('admin.teachers.edit', compact('teacher', 'roles'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'short_name' => 'required|string|max:50',
            'father_name' => 'nullable|string|max:100',
            'cnic' => 'required|string|max:20|unique:teachers,cnic,' . $teacher->id,
            'dob' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
            'joined_at' => 'nullable|date',
            'designation' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:100',
            'bps' => 'nullable|string|max:10',
            'personal_no' => 'string|max:10',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('photo')) {
                // delete old photo if exists
                if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
                    Storage::disk('public')->delete($teacher->photo);
                }
                $validated['photo'] = $request->file('photo')->store('teachers', 'public');
            }


            $teacher->update($validated);
            $teacher->user()->update([
                'email' => $request->email
            ]);

            DB::commit();
            return redirect()->route('admin.teachers.show', $teacher)->with('success', 'Teacher updated successfully.');
        } catch (Exception $ex) {
            DB::rollBack();
            return back()->with('error', $ex->getMessage());
        }
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->photo && Storage::disk('public')->exists($teacher->photo)) {
            Storage::disk('public')->delete($teacher->photo);
        }

        $teacher->delete();

        return redirect()->route('admin.teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}

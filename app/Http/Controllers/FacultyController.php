<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FacultyController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return view('faculty.index', compact('teachers'));
    }

    public function create()
    {
        return view('faculty.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:50',
            'father_name' => 'nullable|string|max:255',
            'cnic' => 'required|string|max:20|unique:teachers',
            'dob' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:15',
            'official_phone' => 'nullable|string|max:15',
            'joined_at' => 'nullable|date',
            'designation' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:100',
            'bps' => 'nullable|string|max:10',
            'personal_no' => 'string|max:10',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:1024', // 1MB limit
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('teachers', 'public');
        }

        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make('password'),

            ]);

            $teacher = Teacher::create(array_merge($validated, [
                'user_id' => $user->id,
            ]));
            DB::commit();
            return redirect()->route('faculty.index')->with('success', 'Teacher added successfully.');
        } catch (Exception $ex) {
            Db::rollBack();
            return back()->with('warning', $ex->getMessage());
        }
    }

    public function show(Teacher $teacher) {}

    public function faculty()
    {
        $teachers = Teacher::where('is_active', true)->orderBy('bps', 'desc')->get();
        return view('faculty', compact('teachers'));
    }
}

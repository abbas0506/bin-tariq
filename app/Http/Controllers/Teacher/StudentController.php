<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $section = Auth::user()->teacher?->sectionAsIncharge();
        return view('teacher.students.index', compact('section'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $section = Auth::user()->teacher?->sectionAsIncharge();
        return view('teacher.students.create', compact('section'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'father' => 'nullable',
            'phone' => 'nullable',
            'bform' => 'required',
            'rollno' => 'required',
        ]);

        try {

            $section = Auth::user()->teacher?->sectionAsIncharge();
            $section->students()->create($request->all());
            return redirect()->route('teacher.students.index')->with('success', 'Successfully created');
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
        $section = Auth::user()->teacher?->sectionAsIncharge();
        $student = Student::findOrFail($id);
        return view('teacher.students.show', compact('section', 'student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $section = Auth::user()->teacher?->sectionAsIncharge();
        $student = Student::findOrFail($id);
        return view('teacher.students.edit', compact('section', 'student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $student = Student::findOrFail($id);
        
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'name' => 'required|string|max:50',
            'father_name' => 'required|string|max:50',
            'rollno' => 'integer|min:1',
            'phone' => 'nullable|string|max:16',
            'address' => 'nullable|string|max:100',
            
            // 'dob' => 'nullable|date',
            // 'bform' => 'required|string|max:15|unique:students,bform,' . $student->id,
            // 'id_mark' => 'nullable|string|max:100',
            // 'caste' => 'nullable|string|max:50',
            // 'is_orphan' => 'nullable|boolean',
            // 'distinction' => 'nullable',

            // 'father_cnic' => 'nullable|string|max:15',
            // 'profession' => 'nullable|string|max:50',
            // 'income' => 'nullable|integer|min:0',

            // 'gender' => 'required',
            // 'group_id' => 'nullable|exists:groups,id',
        ]);

        try {

            // ✅ If new photo uploaded
            if ($request->hasFile('photo')) {
                if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                    Storage::disk('public')->delete($student->photo);
                }

                $filename = uniqid() . '.' . $request->photo->extension();
                $path = $request->photo->storeAs('uploads', $filename, 'public');

                $validated['photo'] = $path; // full path like "uploads/abc.jpg"
            }
            $student->update($validated);
            return redirect()->route('teacher.students.index')->with('success', 'Student successfully updated');
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
    public function print()
    {
        $section = Auth::user()->teacher?->sectionAsIncharge();
        $pdf = PDF::loadview('teacher.students.print', compact('section'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);
        $file = "Phone_list" . Str::random(3);
        return $pdf->stream($file);
    }
}

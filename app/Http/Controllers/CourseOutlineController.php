<?php

namespace App\Http\Controllers;

use App\Models\CourseOutline;
use App\Models\Subject;
use Illuminate\Http\Request;

class CourseOutlineController extends Controller
{
    public function index()
    {
        $outlines = CourseOutline::with('subject')->latest()->paginate(10);
        return view('course_outlines.index', compact('outlines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('course_outlines.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'day_no' => 'required|integer|min:1',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|integer|min:1|max:12',
            'topic' => 'required|string|max:200',
            'activity' => 'nullable|string|max:200',
            'assignment' => 'nullable|string|max:200',
            'media_url' => 'nullable|url|max:200',
        ]);

        CourseOutline::create($validated);

        return redirect()->route('course_outlines.index')
            ->with('success', 'Course outline created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseOutline $course_outline)
    {
        return view('course_outlines.show', compact('course_outline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseOutline $course_outline)
    {
        $subjects = Subject::all();
        return view('course_outlines.edit', compact('course_outline', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourseOutline $course_outline)
    {
        $validated = $request->validate([
            'day_no' => 'required|integer|min:1',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|integer|min:1|max:12',
            'topic' => 'required|string|max:200',
            'activity' => 'nullable|string|max:200',
            'assignment' => 'nullable|string|max:200',
            'media_url' => 'nullable|url|max:200',
        ]);

        $course_outline->update($validated);

        return redirect()->route('course_outlines.index')
            ->with('success', 'Course outline updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseOutline $course_outline)
    {
        $course_outline->delete();

        return redirect()->route('course_outlines.index')
            ->with('success', 'Course outline deleted successfully!');
    }
}

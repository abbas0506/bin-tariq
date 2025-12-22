<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Group;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OnlineApplicationController extends Controller
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
        $groups = Group::all();
        // echo "Requested resource is not available ...";
        return view('admission.online-applications.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:1024',
            'name' => 'required|string|max:50',
            'bform' => 'required|string|max:15|unique:applications,bform',
            'phone' => 'required|string|max:16',
            'address' => 'nullable|string|max:100',
            'dob' => 'required|date',
            'id_mark' => 'required|string|max:100',
            'caste' => 'required|string|max:50',
            'is_orphan' => 'required|boolean',
            'father_name' => 'required|string|max:50',
            'mother_name' => 'required|string|max:50',
            'father_cnic' => 'nullable|string|max:15',
            'mother_cnic' => 'nullable|string|max:15',

            'profession' => 'required|string|max:50',
            'income' => 'required|integer|min:0',
            'grade' => 'required|integer|min:1|max:12',
            'group_id' => 'required|exists:groups,id',
            'pass_year' => 'required|digits:4|integer',
            'medium' => 'required|in:en,ur',
            'previous_school' => 'nullable|string|max:100',
            'bise' => 'required|string|max:20',
            'rollno' => 'required|string|max:8',
            'obtained_marks' => 'required|integer|min:0',
            'max_marks' => 'required|integer|min:1|gte:obtained_marks',
        ]);

        try {
            // Application::create($data);
            $duplicate = Application::where('rollno', $request->rollno)->where('pass_year', $request->pass_year)->first();
            if ($duplicate) {
                // duplicate record;
                return redirect()->back()->with('warning', 'Application alrady exists');
            } else {
                // not duplicating
                if ($request->hasFile('photo')) {
                    $filename = uniqid() . '.' . $request->photo->extension();
                    $path = $request->photo->storeAs('uploads', $filename, 'public');
                    $validated['photo'] = $path; // full path like "uploads/abc.jpg"

                }
                $application = Application::create($validated);
                return redirect()->route('applied', $application);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
    public function show($id) {}

    public function applied($id)
    {

        $application = Application::findOrFail($id);
        return view('admission.online-applications.success', compact('application'));
    }
}

<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Group;
use App\Models\Section;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApplicationController extends Controller
{

    public function accept(Application $application)
    {
        try {
            $application->update([
                'status' => 'accepted',
                'rejection_note' => null,
            ]);
            return back()->with('success', 'Application accepted!');
        } catch (Exception $ex) {
            return back()->with('warning', $ex->getMessage());
        }
    }

    public function reject(Request $request, Application $application)
    {
        $request->validate(['rejection_note' => 'required|string']);
        try {
            $application->update([
                'status' => 'rejected',
                'rejection_note' => $request->rejection_note,
            ]);
            return back()->with('success', 'Application rejected.');
        } catch (Exception $ex) {
            return back()->with('warning', $ex->getMessage());
        }
    }

    public function admit(Request $request, Application $application)
    {
        $request->validate([
            'amount_paid' => 'required|numeric'
        ]);

        DB::beginTransaction();
        try {
            $application->update([
                'status' => 'admitted',
                'amount_paid' => $request->amount_paid,
                'payment_date' => now()->format('Y-m-d'),
            ]);
            // e.g., Move data to students table
            $section = Section::where('grade', 11)->first();
            if ($section) {
                Student::create([
                    'photo' => $application->photo,
                    'name' => $application->name,
                    'bform' => $application->bform,
                    'gender' => $application->gender,
                    'phone' => $application->phone,
                    'address' => $application->address,
                    'dob' => $application->dob,
                    'id_mark' => $application->id_mark,
                    'caste' => $application->caste,
                    'is_orphan' => $application->is_orphan,
                    'father_name' => $application->father_name,
                    'mother_name' => $application->mother_name,
                    'father_cnic' => $application->father_cnic,
                    'mother_cnic' => $application->mother_cnic,
                    'profession' => $application->profession,
                    'income' => $application->income,

                    'grade' => $section->grade,
                    'section_id' => $section->id,
                    'rollno' => $section->students->count() + 1,
                    'group_id' => $application->group_id,
                    'admission_date' => now(),
                    'score' => $application->obtained_marks,
                ]);
                DB::commit();
                return back()->with('success', 'Student successfully admitted');
            } else {
                DB::rollBack();
                return back()->with('warning', 'Section required!');
            }
        } catch (Exception $ex) {
            return back()->with('warning', $ex->getMessage());
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $applications = Application::all();
        $today = \Carbon\Carbon::today();

        $stats = [
            'pending_total'   => Application::where('status', 'pending')->count(),
            'pending_today'   => Application::where('status', 'pending')->whereDate('created_at', $today)->count(),

            'accepted_total'  => Application::where('status', 'accepted')->count(),
            'accepted_today'  => Application::where('status', 'accepted')->whereDate('created_at', $today)->count(),

            'rejected_total'  => Application::where('status', 'rejected')->count(),
            'rejected_today'  => Application::where('status', 'rejected')->whereDate('created_at', $today)->count(),

            'admitted_total'  => Application::where('status', 'admitted')->count(),
            'admitted_today'  => Application::where('status', 'admitted')->whereDate('created_at', $today)->count(),
        ];

        return view('admission.applications.index', compact('applications', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $groups = Group::all();
        return view('admission.applications.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required',
            'father_name' => 'required',
            'bform' => 'required',
            'phone' => 'required',
            'bise' => 'required',
            'rollno' => 'required',
            'obtained_marks' => 'required',
            'max_marks' => 'required',
            'pass_year' => 'required',
            'group_id' => 'required',
        ]);

        try {
            $duplicate = Application::where('rollno', $request->rollno)->where('pass_year', $request->pass_year)->first();
            if ($duplicate) {
                // duplicate record;
                return redirect()->back()->with('warning', 'Application alrady exists');
            } else {
                // not duplicating
                Application::create($request->all());
                return redirect()->route('admission.applications.index')->with('success', 'Successfully submitted!');
            }
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
        $application = Application::findOrFail($id);
        return view('admission.applications.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $application = Application::findOrFail($id);
        $groups = Group::all();
        return view('admission.applications.edit', compact('application', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $application = Application::find($id);

        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'name' => 'required|string|max:50',
            'father_name' => 'required|string|max:50',
            'bform' => 'required|string|max:15|unique:applications,bform,' . $application->id,
            'phone' => 'required|string|max:16',
            'address' => 'nullable|string|max:100',
            'dob' => 'required|date',
            'id_mark' => 'required|string|max:100',
            'caste' => 'required|string|max:50',
            'is_orphan' => 'required|boolean',
            'guardian_relation' => 'nullable|string|max:50',
            'guardian_name' => 'nullable|string|max:50',
            'father_cnic' => 'nullable|string|max:15',
            'mother_cnic' => 'nullable|string|max:15',
            'profession' => 'required|string|max:50',
            'income' => 'required|integer|min:0',

            // 'grade' => 'required|integer|min:1|max:12',
            'group_id' => 'required|exists:groups,id',
            'pass_year' => 'required|digits:4|integer',
            'medium' => 'required|in:en,ur',
            'previous_school' => 'nullable|string|max:100',
            'bise' => 'required|string|max:20',
            'rollno' => 'required|string|max:8',
            'obtained_marks' => 'required|integer|min:0',
            'max_marks' => 'required|integer|min:1|gte:obtained_marks',
            'status' => 'nullable|string|in:pending,accepted,rejected,admitted',
            'rejection_note' => 'nullable|string|max:200',
            'amount_paid' => 'nullable|integer|min:0',

            'fee_concession' => 'nullable|integer|min:0|max:100',
        ]);

        try {

            // ✅ If new photo uploaded
            if ($request->hasFile('photo')) {
                if ($application->photo && Storage::disk('public')->exists($application->photo)) {
                    Storage::disk('public')->delete($application->photo);
                }

                $filename = uniqid() . '.' . $request->photo->extension();
                $path = $request->photo->storeAs('uploads', $filename, 'public');

                $validated['photo'] = $path; // full path like "uploads/abc.jpg"
            }
            $application->update($validated);
            return redirect()->route('admission.applications.index')->with('success', 'Application # ' . $application->rollno . ' successfully updated');
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
        try {
            $application = Application::findOrFail($id);
            // Delete associated photo if exists
            if ($application->photo && Storage::disk('public')->exists($application->photo)) {
                Storage::disk('public')->delete($application->photo);
            }

            // Delete the record
            $application->delete();

            return redirect()->route('admission.applications.index')->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function congratulate()
    {
        return view('admission.applications.congrats');
    }
}

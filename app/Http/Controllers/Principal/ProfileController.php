<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = Profile::all();
        return view('principal.users.index', compact('users'));
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
        $user = Profile::findOrFail($id);
        return view('principal.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        return view('principal.users.edit', compact('user'));
    }

    public function update(Request $request, user $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'short_name' => 'required|string|max:50',
            'father_name' => 'nullable|string|max:100',
            'cnic' => 'required|string|max:20|unique:users,cnic,' . $user->id,
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
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }
                $validated['photo'] = $request->file('photo')->store('users', 'public');
            }


            $user->update($validated);
            $user->user()->update([
                'email' => $request->email
            ]);

            DB::commit();
            return redirect()->route('principal.users.index')->with('success', 'user updated successfully.');
        } catch (Exception $ex) {
            DB::rollBack();
            return back()->with('error', $ex->getMessage());
        }
    }

    public function destroy(user $user)
    {
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('principal.users.index')->with('success', 'user deleted successfully.');
    }
}

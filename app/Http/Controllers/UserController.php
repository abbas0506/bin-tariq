<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'user');
        })->get();

        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'father_name' => 'nullable|string',
            'cnic' => 'required|string',
            'phone' => 'required|string',
            'salary' => 'required|numeric',
        ]);

        try {

            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make('password'),
            ]);
            $user->assignRole(['user']);
            $user->profile()->create($request->all());
            return redirect()->route('users.index')->with('success', 'Successfully created');
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
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.show', compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, user $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'short_name' => 'nullable|string|max:50',
            'father_name' => 'nullable|string|max:100',
            'cnic' => 'nullable|string|max:15',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'joined_at' => 'nullable|date',
            'qualification' => 'nullable|string|max:100',
            'seniority' => 'nullable|numeric',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('photo')) {
                // delete old photo if exists
                if ($user->profile->photo && Storage::disk('public')->exists($user->profile->photo)) {
                    Storage::disk('public')->delete($user->profile->photo);
                }
                $validated['photo'] = $request->file('photo')->store('users', 'public');
            }

            $user->update([
                'email' => $request->email
            ]);

            $user->profile->update($validated);

            DB::commit();
            return redirect()->route('users.show', $user)->with('success', 'user updated successfully.');
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

        return redirect()->route('users.index')->with('success', 'user deleted successfully.');
    }

    public function  switchAs($roleName)
    {
        if (Auth::user()->hasRole($roleName)) {
            session([
                'role' => $roleName,
            ]);
            return redirect($roleName);
        } else {
            echo "Invalid role selected!";
        }
    }
}

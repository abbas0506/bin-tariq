<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        return view('admin.users.index', compact('users'));
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
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',

        ]);
        $user = User::findOrFail($id);
        DB::beginTransaction();



        $roles = Role::all();
        try {

            $user->update([
                'email' => $request->email,
            ]);

            $user->teacher->update([
                'name' => $request->name,
            ]);

            if (isset($request->role_names_array)) {
                $arrayOfRequestedRoleNames = $request->role_names_array;
                foreach ($roles as $role) {
                    if (in_array($role->name, $arrayOfRequestedRoleNames)) {
                        //add the role, if alreay not
                        if (!$user->hasRole($role->name))
                            $user->assignRole($role->name);
                    } else {
                        //remove the role, if withdrawal
                        if ($user->hasRole($role->name))
                            $user->removeRole($role->name);
                    }
                }
            } else {
                // remove all roles
                foreach ($roles as $role) {
                    $user->removeRole($role);
                }
            }

            DB::commit();
            return redirect()->route('admin.users.index')->with('success', 'Successfully updated');;
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->back()->with('success', 'Successfully deleted!');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
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

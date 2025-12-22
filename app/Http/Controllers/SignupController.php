<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Exception;


class SignupController extends Controller
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
        $numA = rand(1, 9);
        $numB = 0;
        while (1) {
            $numB = rand(1, 9);
            if ($numA != $numB) break;
        }

        return view('signup', compact('numA', 'numB'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //signup  process
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'cnic' => 'required',
            'designation' => 'required',
            'secret_code' => 'required|numeric',
            'num_a' => 'required|numeric',
            'num_b' => 'required|numeric',
        ]);


        DB::beginTransaction();
        try {

            $code = Str::random(5);
            $numA = $request->num_a;
            $numB = $request->num_b;
            $secretCode = $request->secret_code;

            //    if secret code not matched
            if ($numA + $numB != $secretCode)
                return redirect()->back()->with('warning', 'Registeration rejected!');
            else {
                $user = User::create([
                    'email' => $request->email,
                    'password' => Hash::make($code),
                ]);

                $user->assignRole('teacher');

                $user->teacher()->create([
                    'name' => $request->name,
                    'cnic' => $request->cnic,
                    'designation' => $request->designation,
                    'bps' => 0,
                ]);

                // send password to given email for verification
                $email = $request->email;
                Mail::raw('Password sent by ghsscb.edu.pk : ' . $code, function ($message) use ($code, $email) {
                    $message->to($email);
                    $message->subject('Signup on ghsscb');
                });
            }



            DB::commit();

            // go to related dashboard
            return redirect('signup-success');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Principal;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;

class userWiseScheduleController extends Controller
{
    //
    public function  index()
    {
        $users = User::has('allocations')->get()->sortByDesc('bps'); //get active sections
        $lectures = Lecture::all();
        return view('principal.schedule.user-wise.index', compact('users', 'lectures'));
    }

    public function print()
    {
        // on the basis of print mode, create pdf
        if (session('user_ids'))
            $users = User::whereIn('id', session('user_ids'))->get();
        else
            $users = User::has('allocations')->get()->sortByDesc('bps');;

        $lectures = Lecture::all();
        $pdf = PDF::loadview('principal.schedule.user-wise.pdf', compact('users', 'lectures'))->setPaper('a4', 'portrait');
        $pdf->set_option("isPhpEnabled", true);
        $file = "user-schedule.pdf";
        return $pdf->stream($file);
    }

    public function post(Request $request)
    {
        $request->validate([
            'user_ids_array' => 'required',
        ]);
        try {
            $userIdsArray = array();
            $userIdsArray = $request->user_ids_array;
            session([
                'user_ids' => $userIdsArray,
                'print_mode' => $request->print_mode,
            ]);

            return redirect()->route('principal.user-schedule.print');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }
}

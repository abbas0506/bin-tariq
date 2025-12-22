<?php

namespace App\Http\Controllers\Admission;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $stats = [
            'applications_total' => Application::count(),
            'applications_today' => Application::today()->count(),
            'applications_admitted' => Application::admitted()->count(),

            'pending_total'   => Application::pending()->count(),
            'pending_today'   => Application::pending()->today()->count(),

            'accepted_total'  => Application::accepted()->count(),
            'accepted_today'  => Application::accepted()->today()->count(),

            'rejected_total'  => Application::rejected()->count(),
            'rejected_today'  => Application::rejected()->today()->count(),

            'admitted_total'  => Application::admitted()->count(),
            'admitted_today'  => Application::admitted()->whereDate('payment_date', today())->count(),

            'amount_paid_total'  => Application::sum('amount_paid'),
            'amount_paid_today'  => Application::whereDate('payment_date', today())->sum('amount_paid'),

            'pre_engg_total'  => Application::preEngg()->count(),
            'pre_engg_today'  => Application::preEngg()->today()->count(),
            'pre_engg_admitted'  => Application::preEngg()->admitted()->count(),

            'ics_total'  => Application::ics()->count(),
            'ics_today'  => Application::ics()->today()->count(),
            'ics_admitted'  => Application::ics()->admitted()->count(),

            'arts_total'  => Application::arts()->count(),
            'arts_today'  => Application::arts()->today()->count(),
            'arts_admitted'  => Application::arts()->admitted()->count(),


            '1000+_total'  => Application::where('obtained_marks', '>=', 1000)->count(),
            '1000+_today'  => Application::today()->where('obtained_marks', '>=', 1000)->count(),
            '1000+_admitted'  => Application::admitted()->where('obtained_marks', '>=', 1000)->count(),

            'other_board_total'  => Application::otherBoard()->count(),
            'other_board_today'  => Application::otherBoard()->today()->count(),
            'other_board_admitted'  => Application::otherBoard()->admitted()->count(),

        ];

        $applications_today = Application::today()->get();
        return view('admission.dashboard', compact('stats', 'applications_today'));
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

<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Salary;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Salary::class);

        $salaries = Salary::latest()
            ->paginate(5);
        return view('salaries.index', compact('salaries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->authorize('create', Salary::class);
        $months = config('enums.months');
        $users = User::whereHas('profile', function ($q) {
            $q->where('status', 1);
        })->get();
        return view('salaries.create', compact('months', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $this->authorize('create', Salary::class);

        $request->validate([
            'month' => 'numeric',
            'year' => 'numeric',
            'user_ids_array' => 'required|array|min:1', // must be an array with at least 1 item

        ]);

        $month = $request->month;
        $year  = $request->year;

        $userIdsArray = array();
        $userIdsArray = $request->user_ids_array;
        $users = User::whereIn('id', $userIdsArray)->get();

        $year = $request->year;

        $salaryExpense = Account::where('code', '5001')->first(); // Teacher Salary
        $salaryPayable = Account::where('code', '2001')->first(); // Salary Payable (liability)

        DB::beginTransaction();
        try {

            foreach ($users as $user) {
                // start transaction
                $transaction = Transaction::create([
                    'date' => now()->format('Y-m-d'),
                    'description' => "Salary: {$month}/{$year} - {$user->profile->name}",
                ]);

                $salary = $user->profile->salary;
                $user->salaries()->create([
                    'year' => $request->year,
                    'month' => $request->month,
                    'amount' => $salary,
                    'transaction_id' => $transaction->id,
                ]);
                // transaction lines
                // Dr to salary expense
                $transaction->lines()->create([
                    'account_id' => $salaryExpense->id,
                    'debit'      => $salary,
                    'credit'     => 0,
                ]);

                //Cr to salary payable / liability
                $transaction->lines()->create([
                    'account_id' => $salaryPayable->id,
                    'debit'     => 0,
                    'credit'      => $salary,
                ]);
            }

            DB::commit();
            return redirect()->route('salaries.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $salary = Salary::findOrFail($id);
        $this->authorize('view', $salary);
        $paymentMethods = Account::where('is_payment_method', true)->get();
        return view('salaries.show', compact('salary', 'paymentMethods'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        DB::beginTransaction();
        try {

            $salary = salary::find($id);
            $this->authorize('update', $salary);

            $salary->update([
                'status' => 1,
            ]);

            $salaryPayable  = Account::where('code', '2001')->first();
            // transaction lines
            // Dr to salary payable
            $salary->transaction->lines()->create([
                'account_id' => $salaryPayable->id,
                'debit'      => $salary->amount,
                'credit'     => 0,
            ]);


            // Cr → Cash / Bank / JazzCash / Easypaisa
            $salary->transaction->lines()->create([
                'account_id' => $request->payment_account_id,
                'debit'     => 0,
                'credit'      => $salary->amount,
            ]);

            DB::commit();
            return redirect()->route('salaries.show', $salary)->with('success', 'Successfully updated');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salary $salary)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Expense;
use App\Models\Transaction;
use App\Models\TransactionLine;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $this->authorize('viewAny', Expense::class);

        // $feeInvoices = FeeInvoice::all();
        $expenses = Expense::latest()->paginate(5);
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $this->authorize('create', Expense::class);

        $expenseAccounts = Account::where('type', 'expense')->get();
        $paymentMethods  = Account::where('is_payment_method', true)->get();

        return view('expenses.create', compact('expenseAccounts', 'paymentMethods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'expense_account_id' => 'required|exists:accounts,id',
            'payment_account_id' => 'nullable|exists:accounts,id',
        ]);

        DB::beginTransaction();
        try {
            // Create transaction
            $transaction = Transaction::create([
                'date' => now(),
                'description' => Account::find($request->expense_account_id)->name . ' expense',
            ]);

            // Dr Expense
            $transaction->lines()->create([
                'account_id' => $request->expense_account_id,
                'debit' => $request->amount,
                'credit' => 0,
            ]);


            // Cr Bank/Cash/Jazz Cash etc
            $transaction->lines()->create([
                'transaction_id' => $transaction->id,
                'account_id' => $request->payment_account_id,
                'debit' => 0,
                'credit' => $request->amount,
            ]);
            // Save expense record
            Expense::create([
                'amount' => $request->amount,
                'expense_account_id' => $request->expense_account_id,
                'payment_account_id' => $request->payment_account_id,
                'status' => 1,
                'transaction_id' => $transaction->id,
            ]);
            DB::commit();
            return redirect()->route('expenses.index')->with('success', 'Successfully created');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}

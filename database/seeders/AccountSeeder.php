<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        // ===== ASSETS =====
        $assets = Account::create([
            'code' => '1000',
            'name' => 'Assets',
            'type' => 'asset',
            'parent_id' => null,
        ]);

        $currentAssets = Account::create([
            'code' => '1100',
            'name' => 'Current Assets',
            'type' => 'asset',
            'parent_id' => $assets->id,
        ]);

        Account::insert([
            [
                'code' => '1101',
                'name' => 'Cash',
                'type' => 'asset',
                'parent_id' => $currentAssets->id,
            ],
            [
                'code' => '1102',
                'name' => 'Bank',
                'type' => 'asset',
                'parent_id' => $currentAssets->id,
            ],
            [
                'code' => '1103',
                'name' => 'Student Receivable',
                'type' => 'asset',
                'parent_id' => $currentAssets->id,
            ],
        ]);

        $fixedAssets = Account::create([
            'code' => '1200',
            'name' => 'Fixed Assets',
            'type' => 'asset',
            'parent_id' => $assets->id,
        ]);

        Account::insert([
            [
                'code' => '1201',
                'name' => 'Furniture',
                'type' => 'asset',
                'parent_id' => $fixedAssets->id,
            ],
            [
                'code' => '1202',
                'name' => 'Computers',
                'type' => 'asset',
                'parent_id' => $fixedAssets->id,
            ],
        ]);

        // ===== LIABILITIES =====
        $liabilities = Account::create([
            'code' => '2000',
            'name' => 'Liabilities',
            'type' => 'liability',
            'parent_id' => null,
        ]);

        Account::insert([
            [
                'code' => '2101',
                'name' => 'Salary Payable',
                'type' => 'liability',
                'parent_id' => $liabilities->id,
            ],
            [
                'code' => '2102',
                'name' => 'Accounts Payable',
                'type' => 'liability',
                'parent_id' => $liabilities->id,
            ],
        ]);

        // ===== EQUITY =====
        $equity = Account::create([
            'code' => '3000',
            'name' => 'Equity',
            'type' => 'equity',
            'parent_id' => null,
        ]);

        Account::insert([
            [
                'code' => '3101',
                'name' => 'Capital',
                'type' => 'equity',
                'parent_id' => $equity->id,
            ],
            [
                'code' => '3102',
                'name' => 'Drawings',
                'type' => 'equity',
                'parent_id' => $equity->id,
            ],
            [
                'code' => '3103',
                'name' => 'Retained Earnings',
                'type' => 'equity',
                'parent_id' => $equity->id,
            ],
        ]);

        // ===== INCOME =====
        $income = Account::create([
            'code' => '4000',
            'name' => 'Income',
            'type' => 'income',
            'parent_id' => null,
        ]);

        Account::insert([
            [
                'code' => '4101',
                'name' => 'Tuition Fee Income',
                'type' => 'income',
                'parent_id' => $income->id,
            ],
            [
                'code' => '4102',
                'name' => 'Admission Fee',
                'type' => 'income',
                'parent_id' => $income->id,
            ],
            [
                'code' => '4103',
                'name' => 'Fine Income',
                'type' => 'income',
                'parent_id' => $income->id,
            ],
        ]);

        // ===== EXPENSES =====
        $expenses = Account::create([
            'code' => '5000',
            'name' => 'Expenses',
            'type' => 'expense',
            'parent_id' => null,
        ]);

        $academicExpenses = Account::create([
            'code' => '5100',
            'name' => 'Academic Expenses',
            'type' => 'expense',
            'parent_id' => $expenses->id,
        ]);

        Account::insert([
            [
                'code' => '5101',
                'name' => 'Teacher Salary',
                'type' => 'expense',
                'parent_id' => $academicExpenses->id,
            ],
            [
                'code' => '5102',
                'name' => 'Exam Expenses',
                'type' => 'expense',
                'parent_id' => $academicExpenses->id,
            ],
        ]);

        Account::insert([
            [
                'code' => '5201',
                'name' => 'Office Rent',
                'type' => 'expense',
                'parent_id' => $expenses->id,
            ],
            [
                'code' => '5202',
                'name' => 'Electricity',
                'type' => 'expense',
                'parent_id' => $expenses->id,
            ],
            [
                'code' => '5203',
                'name' => 'Internet',
                'type' => 'expense',
                'parent_id' => $expenses->id,
            ],
        ]);
    }
}

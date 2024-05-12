<?php

namespace App\Action\ExpenseCategory;

use App\Models\Expense;
use App\Models\ExpenseCategory;

class UpdateExpenseCategory
{

    public function execute(ExpenseCategory $expenseCategory, array $inputs = [])
    {
        $expenseCategory = $expenseCategory->update($inputs);
        return $expenseCategory;
    }
}

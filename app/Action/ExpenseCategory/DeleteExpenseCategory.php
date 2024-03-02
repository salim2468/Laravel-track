<?php

namespace App\Action\ExpenseCategory;

use App\Models\ExpenseCategory;

class DeleteExpenseCategory
{

    public function execute(ExpenseCategory $expenseCategory)
    {
        $expenseCategory->delete();
    }
}

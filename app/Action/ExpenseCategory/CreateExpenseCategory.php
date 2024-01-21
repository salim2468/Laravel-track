<?php

namespace App\Action\ExpenseCategory;

use App\Models\ExpenseCategory;

class CreateExpenseCategory
{

    public function execute(array $inputs = [])
    {
        $expenseCategory = ExpenseCategory::create($inputs);
        return $expenseCategory;
    }
}

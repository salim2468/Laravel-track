<?php

namespace App\Action\Expense;

use App\Models\Expense;

class UpdateExpense
{

    public function execute(Expense $expense, array $inputs = [])
    {
        $expense = $expense->update($inputs);
        return $expense;
    }
}

<?php

namespace App\Action\Expense;

use App\Models\Expense;

class DeleteExpense
{

    public function execute(Expense $expense)
    {
        $expense->delete();
    }
}

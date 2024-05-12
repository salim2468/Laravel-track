<?php

namespace App\Action\Expense;
use App\Models\Expense;

class CreateExpense
{
    public function execute(array $inputs=[])
    {   
        $expense =  Expense::create($inputs);
        return $expense;
    }
}

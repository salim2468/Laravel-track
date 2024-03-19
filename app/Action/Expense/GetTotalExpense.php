<?php

namespace App\Action\Expense;

class GetTotalExpense
{
    protected $filter; 
    public function __construct(FilterExpense $filter){
        $this->filter = $filter;
    }

    public function execute(array $inputs = [])
    {
        $total = $this->filter->execute($inputs)->sum('price');
        return $total;
    }
}

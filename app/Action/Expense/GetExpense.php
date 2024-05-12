<?php

namespace App\Action\Expense;
use App\Action\Expense\FilterExpense;

class GetExpense
{

    protected $filter;
    public function __construct(FilterExpense $filter)
    {
        $this->filter = $filter;
    }
    public function execute($params = [], $sort='id',$order = 'desc')
    {
       $query = $this->filter->execute($params); 
       $query->orderBy($sort, $order);
       
       return $query;
    }
}

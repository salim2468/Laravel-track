<?php

namespace App\Action\ExpenseCategory;

use App\Action\ExpenseCategory\FilterExpenseCategory;

class GetExpenseCategory
{
    protected $filter;
    public function __construct(FilterExpenseCategory $filter)
    {
        $this->filter = $filter;
    }
    public function execute(array $params = [], $sort = 'id', $order = 'asc')
    {
       $query  = $this->filter->execute($params);
       $query->orderBy($sort, $order);

       return $query;
    }
    
}

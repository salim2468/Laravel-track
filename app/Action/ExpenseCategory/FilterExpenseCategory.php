<?php

namespace App\Action\ExpenseCategory;

use Illuminate\Support\Arr;
use App\Models\ExpenseCategory;
use Illuminate\Contracts\Database\Eloquent\Builder;

class FilterExpenseCategory
{
    protected $query;
    public function __construct(ExpenseCategory $expenseCategory)
    {
        $this->query = $expenseCategory->query();
    }
    public function execute($params = []): Builder
    {
        if ($id = Arr::pull($params, 'id')) {
            $this->query->where('id', $id);
        }
        if ($ids = Arr::pull($params, 'ids')) {
            $this->query->whereIn('id', $ids);
        }
        if ($keyword = Arr::pull($params, 'keyword')) {
            $this->query->where('category_name','like' ,"%$keyword%");
        }

        return $this->query;
    }
}

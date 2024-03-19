<?php

namespace App\Action\Expense;

use App\Models\Expense;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Database\Eloquent\Builder;


class FilterExpense
{
    protected $query;
    public function __construct(Expense $expense)
    {
        $this->query = $expense->query();
    }
    public function execute($params = []): Builder
    {
        if ($id = Arr::pull($params, 'id')) {
            $this->query->where('id', $id);
        }
        if ($ids = Arr::pull($params, 'ids')) {
            $this->query->whereIn('id', $ids);
        }
        if ($userId = Arr::pull($params, 'userId')) {
            $this->query->whereIn('user_id', $userId);
        }
        if($date = Arr::pull($params, 'date')) {
            $yearMonth = substr($date, 0,7);
            $this->query->where('date','LIKE',"%$yearMonth%");
        }
        if ($keyword = Arr::pull($params, 'keyword')) {
            $this->query->where(function($query) use($keyword){
                $query
                    ->where('description','like' ,"%$keyword%")
                    ->orWhere('price','like' ,"%$keyword%");
            });
        }

        return $this->query;
    }
}            
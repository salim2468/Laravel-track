<?php

namespace App\Models;

use App\Models\User;
use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'description', 'price','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function expenseCategory(){
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function scopeCategoryName($query,$category)
    {
        return $query->where('category_name', $category);
    }
}

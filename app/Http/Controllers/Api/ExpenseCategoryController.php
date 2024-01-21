<?php

namespace App\Http\Controllers\Api;

use App\Action\ExpenseCategory\CreateExpenseCategory;
use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Action\ExpenseCategory\GetExpenseCategory;
use App\Http\Controllers\Controller;

class ExpenseCategoryController extends Controller
{
    //
    public function index(GetExpenseCategory $expenseCategory)
    {
        $order = request()->input('order', 'asc');
        $sort = request()->input('sort', 'id');
        $count = request()->input('count', 10);
        $params = request()->only(['id', 'ids', 'keyword']);
            
        return $expenseCategory
            ->execute($params, $sort, $order)
            ->paginate($count);

        // $expenseCategory = ExpenseCategory::all();
        // return response()->json([
        //     "data" => $expenseCategory,
        // ],200);
    }

    public function store(CreateExpenseCategory $createExpenseCategory)
    {
        $inputs = request()->all();
        $expenseCategory = $createExpenseCategory->execute($inputs);
        return $expenseCategory;

        // $expenseCategory = ExpenseCategory::create([
        //     'category_name' => $request->category_name,
        // ]);
        // return response()->json([
        //     'data' => $expenseCategory,
        //     'message' => 'Sucessfully added new category'
        // ], 200);
    }


    public function update(Request $request, string $id)
    {
        $expenseCategory = ExpenseCategory::find($id);
        if ($expenseCategory) {
            $expenseCategory->update([
                'category_name' => $request->category_name,
            ]);
            return response()->json([
                'data' => $expenseCategory,
                'message' => 'Sucessfully updated record'
            ], 200);
        } else {
            return response()->json(['message' => "Record not found"], 404);
        }
    }

    public function destroy(string $id)
    {
        $expenseCategory = ExpenseCategory::find($id);

        if (!$expenseCategory) {
            return response()->json(['message' => 'Expense record not found'], 404);
        }
        $expenseCategory->delete();
        return response()->json(['message' => 'Expense record deleted successfully'], 204);
    }
}

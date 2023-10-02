<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ExpenseCategory;
use App\Http\Controllers\Controller;

class ExpenseCategoryController extends Controller
{
    //
    public function index()
    {
        $expenseCategory = ExpenseCategory::all();
        return response()->json([
            "data" => $expenseCategory,
        ],200);
    }

    public function store(Request $request)
    {

        $expenseCategory = ExpenseCategory::create([
            'category_name' => $request->category_name,
        ]);
        return response()->json([
            'data' => $expenseCategory,
            'message' => 'Sucessfully added new category'
        ], 200);
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
            return response()->json(['message' => "Record not found"],404);
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

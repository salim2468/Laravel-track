<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseResource;
use App\Http\Requests\StoreExpenseRequest;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $expense = Expense::all();
        return response()->json([
            "data" => $expense
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category' => 'required',
            'description' => 'required',
            'price' =>'required',
            'user_id' => 'required',
        ]);

        $expense = Expense::create([
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'data' => new ExpenseResource($expense),
            'message' => 'Sucessfully added new record'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $expense =  Expense::find($id);
        if ($expense) {
            return response()->json([
                'data' => new ExpenseResource($expense),
                'message' => 'Found record',
            ], 200);
        } else {
            return response()->json(['message' => "Record not found"]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'category' => 'required',
            'description' => 'required',
            'price' =>'required',
            'user_id' => 'required',
        ]);
        
        $expense = Expense::find($id);
        if ($expense) {
            $expense->update([
                'category' => $request->category,
                'description' => $request->description,
                'price' => $request->price,
                'user_id' => $request->user_id,
            ]);
            return response()->json([
                'data' => new ExpenseResource($expense),
                'message' => 'Sucessfully updated record'
            ], 200);
        } else {
            return response()->json(['message' => "Record not found"],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense record not found'], 404);
        }
        $expense->delete();
        return response()->json(['message' => 'Expense record deleted successfully'], 204);
    }

    /** 
     * Get all expense records for the specified user
     */
    public function allExpenses($id,Request $request)
    {
        $limit = $request->query('limit',2);
        $category = $request->query('category');

        $user = User::find($id);
        $expenseQuery =  $user->expense()->orderByDesc('created_at');
        // ->paginate($limit);
        if($category){
            $expenseQuery->catagoryName($category);
        }


        return response()->json([
            'data' => $expenseQuery->paginate($limit)
        ], 200);
    }
}

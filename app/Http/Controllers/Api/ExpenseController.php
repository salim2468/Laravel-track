<?php

namespace App\Http\Controllers\Api;


use App\Models\Expense;
use Illuminate\Http\Request;
use App\Action\Expense\GetExpense;
use App\Http\Controllers\Controller;
use App\Action\Expense\CreateExpense;
use App\Action\Expense\DeleteExpense;
use App\Action\Expense\UpdateExpense;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetExpense $getExpense)
    {
        $order = request()->input('order', 'asc');
        $sort = request()->input('sort', 'id');
        $count = request()->input('count', 10);
        $params = request()->only(['keyword']);
        $userId = auth()->user()->id;
        $params['user_id'] = $userId;

        $expenses = $getExpense->execute($params, $sort, $order)->paginate($count);
        return response(["data"=>$expenses],200);
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
    public function store(Request $request,CreateExpense $createExpense)
    {
        // $validatedData = $request->validate([
        //     'category' => 'required',
        //     'description' => 'required',
        //     'price' =>'required',
        //     'user_id' => 'required',
        // ]);
        $inputs = request()->all();
        $expense = $createExpense->execute($inputs);
        
        // $expense = Expense::create([
        //     'category' => $request->category,
        //     'description' => $request->description,
        //     'price' => $request->price,
        //     'user_id' => $request->user_id,
        // ]);

        return response()->json([
            'data' => $expense,
            'message' => 'sucessfully added new record'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        if ($expense && $expense->user_id == auth()->user()->id) {
            return response()->json([
                'data' => $expense,
                'message' => 'sucess',
            ], 200);
        } else {
            return response()->json(['message' => "record not found"],404);
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
    public function update(Expense $expense, UpdateExpense $updateExpense)
    {   
        $inputs = request()->all();
        $updateExpense->execute($expense, $inputs);
        return response([]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id,DeleteExpense $deleteExpense)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense record not found'], 404);
        }
        $deleteExpense->execute($expense);
        return response()->json(['message' => 'Expense record deleted successfully'], 204);
    }

    public function monthlyExpense(){
        $inputs['id'] = auth()->user()->id;

    }

    /** 
     * Get all expense records for the specified user
     */
    // public function allExpenses($id,Request $request)
    // {
    //     $limit = $request->query('limit',2);
    //     $category = $request->query('category');

    //     $user = User::find($id);
    //     $expenseQuery =  $user->expense()->orderByDesc('created_at');
    //     // ->paginate($limit);
    //     if($category){
    //         $expenseQuery->catagoryName($category);
    //     }


    //     return response()->json([
    //         'data' => $expenseQuery->paginate($limit)
    //     ], 200);
    // }

    // public function sortByDate(Request $request){
    //     $date = $request->query('date');

    //     if(!is_null($date)){
    //         $user = auth()->user();
    //         if($user){
    //             // $expense = $user->expense()->where('date',$date);
    //         }
    //     } 
    // }
}

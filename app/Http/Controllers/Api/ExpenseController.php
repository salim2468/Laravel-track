<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use App\Models\Expense;
use Illuminate\Http\Request;
use App\Action\Expense\GetExpense;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

use App\Action\Expense\CreateExpense;
use App\Action\Expense\DeleteExpense;
use App\Action\Expense\UpdateExpense;
use App\Action\Expense\GetTotalExpense;


class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetExpense $getExpense)
    {
        $order = request()->input('order', 'desc');
        $sort = request()->input('sort', 'id');
        $count = request()->input('count', 10);
        $params = request()->only(['keyword']);
        $params = request()->input('date');
        $userId = auth()->user()->id;
        $params['user_id'] = $userId;

        $expenses = $getExpense->execute($params, $sort, $order)->with('expenseCategory')->paginate($count);
        return response(["data" => $expenses], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CreateExpense $createExpense)
    {
        $inputs = request()->all();
        Log::debug('hhhhhhhh');
        Log::debug(json_encode($inputs));
        $expense = $createExpense->execute($inputs);
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
            return response()->json(['message' => "record not found"], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Expense $expense, UpdateExpense $updateExpense)
    {
        $inputs = request()->all();
        $result = $updateExpense->execute($expense, $inputs);
        if ($result) {
            return response(['message' => 'Sucessfully Updated'], 200);
        }
        return response(['error' => 'Something went wrong'], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, DeleteExpense $deleteExpense)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            return response()->json(['message' => 'Expense record not found'], 404);
        }
        $deleteExpense->execute($expense);
        return response()->json(['message' => 'Expense record deleted successfully'], 204);
    }

    // old function
    // public function totalExpense(GetTotalExpense $getTotalExpense)
    // {
    //     $inputs['user_id'] = auth()->user()->id;
    //     $inputs['date'] = request()->input('date', date('Y-m-d'));
    //     $expenses = $getTotalExpense->execute($inputs);
    //     return response()->json(['total' => $expenses]);
    // }
    // new function
    public function totalExpense(GetTotalExpense $getTotalExpense)
    {
        $inputs['user_id'] = auth()->user()->id;
        $inputs['date'] = request()->input('date', date('Y-m-d'));
        $expenses = $getTotalExpense->execute($inputs);

        $monthlyIncome = User::find(auth()->user()->id)->value('income');

        return response()->json([
            'total_expense' => $expenses,
            'monthly_income' => $monthlyIncome,
            'remaning_amount' => $monthlyIncome - $expenses
        ]);
    }

    /*
    public function latestSixMonthsExpense(GetMonthlyExpense $getMonthlyExpense)
    {
        $startDate = now()->subMonths(6)->startOfMonth();
        $endDate = now()->endOfMonth();

        $expenses = Expense::select(
            DB::raw('MONTH(date) as month'),
            DB::raw('YEAR(date) as year'),
            DB::raw('SUM(price) as total_price')
        )
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy(DB::raw('YEAR(date)'), DB::raw('MONTH(date)'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        return response(['data' => $expenses]);

        // $expenses = Expense::whereBetween('date', [$startDate, $endDate])->groupBy(DB::raw('YEAR(date)'))->get();
        // return response(['data' => $expenses, 'start' => $startDate, 'end' => $endDate]);
        // $inputs['user_id'] = auth()->user()->id;
        // $expenses = $getMonthlyExpense->execute($inputs);
        // return $expenses;
    }
*/
    public function getExpenseByCategoryOfCurrentMonth()
    {
        $result = Expense::select(
            'expense_categories.category_name as category_name',
            'expenses.category_id',
            DB::raw('SUM(expenses.price) as total_price')
        )
            ->join('expense_categories', 'expenses.category_id', '=', 'expense_categories.id')
            ->where('expenses.user_id', 1)
            ->whereYear('expenses.date', '=', date('Y'))
            ->whereMonth('expenses.date', '=', date('m'))
            ->groupBy('expenses.category_id')
            ->get();
        return response(['data' => $result]);
    }
}

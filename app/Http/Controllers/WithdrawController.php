<?php

namespace App\Http\Controllers;

use App\Models\Withdraw;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Size;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $withdraws = Withdraw::with(['employee', 'uniform', 'size'])->get();
        $employees = Employee::all();
        return view('home', [
            'withdraws' => $withdraws,
            'employees' => $employees
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
        $size = Size::findOrFail($request->sizeId);
        
        if ($request->withdrawal_amount > $size->amount) {
            return redirect()->back()->withErrors(['withdrawal_amount' => 'A quantidade solicitada excede a quantidade disponível.']);
        }

        $withdraw = new Withdraw;
        $withdraw->employee_id = $request->employeeId;
        $withdraw->uniform_id = $request->uniformId;
        $withdraw->size_id = $request->sizeId;
        $withdraw->withdrawal_amount = $request->withdrawal_amount;
        $withdraw->exit_date = $request->exit_date;
        $withdraw->delivery_date = $request->delivery_date;

        $withdraw->save();

        $newAmount = $size->amount - $request->withdrawal_amount;
        $size->update(['amount' => $newAmount]);
        
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $withdraw = Withdraw::findOrFail($id);
        $size = Size::findOrFail($withdraw->size_id);

        $returnAmount = $withdraw->withdrawal_amount + $size->amount;
        $size->update(['amount' => $returnAmount]);

        $withdraw->delete();
        return redirect('/');
    }
}
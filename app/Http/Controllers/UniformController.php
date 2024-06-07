<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Uniform;
use App\Models\Size;

class UniformController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $uniforms = Uniform::with('sizes')->get();
        return view('uniforms', ['uniforms' => $uniforms]);
    }
    
    public function create($id)
    {
        // $uniform = Uniform::with('size')->find($id);

        // return view('uniform');
    }

    public function store(Request $request)
    {
        $uniform = new Uniform;
        $uniform->name = $request->name;
        $uniform->save();
        return redirect('/uniforms');
    }

    public function show($id)
    {

    }
    public function edit($id)
    {
        $uniform = Uniform::with('sizes')->findOrFail($id);
        $employees = Employee::all();

        return view('uniform-show', [
            'uniform'=> $uniform,
            'employees' => $employees,
        ]);
    }

    public function update(Request $request, $id)
    {
        Uniform::findOrFail($id)->update($request->all());
        return redirect('/uniforms');
    }

    public function destroy(string $id)
    {
        $uniform = Uniform::findOrFail($id);
        $uniform->delete();
        return redirect('/uniforms');
    }
}

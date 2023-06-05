<?php

namespace App\Http\Controllers;
use App\Models\RAB;
use App\Models\RABDetails;
use App\Models\User;
use Illuminate\Http\Request;

class RABController extends Controller
{
    public function index()
    {
        $title = "Data RAB";
        $rabs = RAB::orderBy('id','asc')->paginate(5);
        return view('rabs.index', compact('rabs', 'title'));
    } 

    public function create()
    {
        $title = "Add Data RAB";
        $managers = User::where('position','1')->get();
        return view('rabs.create', compact('title', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_rab' => 'required'
        ]);
        dd($request);
        RAB::create($request->post());
        return redirect()->route('rabs.index')->with('success','rabs has been created successfully.');
    }

    public function edit(RAB $rab)
    {
        $title = "Edit Data RAB";
        $managers = User::where('position','1')->get();
        return view('rabs.edit', compact('rab', 'title', 'managers'));
    }

    public function update(Request $request, RAB $rab)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'manager_id' => 'required',
        ]);
        
        $rab->fill($request->post())->save();

        return redirect()->route('rabs.index')->with('success','rab Has Been updated successfully');
    }

    public function destroy(RAB $rab)
    {
        $rab->delete();
        return redirect()->route('rabs.index')->with('success','rab has been deleted successfully');
    }

}

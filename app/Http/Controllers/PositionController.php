<?php

namespace App\Http\Controllers;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $title = "Data Position";
        $positions = Position::orderBy('id','asc')->paginate(5);
        return view('positions.index', compact('positions', 'title'));
    }

    public function create()
    {
        $title = "Add Data Position";
        return view('positions.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'keterangan' => 'required',
            'alias' => 'required',
        ]);
        
        Position::create($request->post());

        return redirect()->route('positions.index')->with('success','Positions has been created successfully.');
    }
}

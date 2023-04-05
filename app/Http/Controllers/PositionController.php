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

    public function edit(Position $position)
    {
        $title = "Edit Data Position";
        return view('positions.edit', compact('position', 'title'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required',
            'keterangan' => 'required',
            'alias' => 'required',
        ]);
        
        $position->fill($request->post())->save();

        return redirect()->route('positions.index')->with('success','Position Has Been updated successfully');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('positions.index')->with('success','Position has been deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Departement;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class DepartementController extends Controller
{
    public function index()
    {
        $title = "Data Departement";
        $departements = Departement::orderBy('id','asc')->paginate(5);
        return view('departements.index', compact('departements', 'title'));
    }

    public function create()
    {
        $title = "Add Data Departement";
        $managers = User::where('position','1')->get();
        return view('departements.create', compact('title', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'manager_id' => 'required',
        ]);
        
        Departement::create($request->post());
        return redirect()->route('departements.index')->with('success','departements has been created successfully.');
    }

    public function edit(Departement $departement)
    {
        $title = "Edit Data Departement";
        $managers = User::where('position','1')->get();
        return view('departements.edit', compact('departement', 'title', 'managers'));
    }

    public function update(Request $request, Departement $departement)
    {
        $request->validate([
            'name' => 'required',
            'location' => 'required',
            'manager_id' => 'required',
        ]);
        
        $departement->fill($request->post())->save();

        return redirect()->route('departements.index')->with('success','Departement Has Been updated successfully');
    }

    public function destroy(Departement $departement)
    {
        $departement->delete();
        return redirect()->route('departements.index')->with('success','Departement has been deleted successfully');
    }

    public function exportPdf()
    {
        $title = "Laporan Data Departement";
        $departements = Departement::orderBy('id','asc')->get();
        $pdf = PDF::loadview('departements.pdf', compact('departements', 'title'));
        return $pdf->stream('laporan_departement');
    }
}

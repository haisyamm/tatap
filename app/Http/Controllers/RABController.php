<?php

namespace App\Http\Controllers;
use App\Models\RAB;
use App\Models\RABDetails;
use App\Models\User;
use Illuminate\Http\Request;
use App\Charts\RabLineChart;

class RABController extends Controller
{
    public function index()
    {   
        $title = "Data RAB";
        $rabs = RAB::orderBy('id','asc')->paginate(5);
        return view('rabs.index', compact(['rabs' , 'title']));
    }

    public function create()
    {
        $title = "Tambah Data RAB";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        return view('rabs.create', compact('title', 'managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_rab' => 'required'
        ]);
        $rab = [
            'no_rab' => $request->no_rab,
            'id_penyusun' => $request->id_penyusun,
            'tgl_rab' => $request->tgl_rab,
            'total' => $request->total,
        ];
        if($result = RAB::create($rab)){
            for ($i=1; $i <= $request->jml; $i++) { 
                $details = [
                    'no_rab' => $request->no_rab,
                    'id_product' => $request['productId'.$i],
                    'product_name' => $request['productName'.$i],
                    'price' => $request['price'.$i],
                    'qty' => $request['qty'.$i],
                    'sub_total' => $request['sub_total'.$i],
                ];
                RABDetails::create($details);
            }
        }     

        return redirect()->route('positions.index')->with('success','Position has been created successfully.');
    }

    public function show(RAB $rab)
    {
        return view('rabs.show',compact('Departement'));
    }

    public function edit(RAB $rab)
    {
        $title = "Edit Data RAB";
        $managers = User::where('position', '1')->orderBy('id','asc')->get();
        $detail = RABDetails::where('no_rab', $rab->no_rab)->orderBy('id','asc')->get();
        return view('rabs.edit',compact('rab' , 'title', 'managers', 'detail'));
    }

    public function update(Request $request, RAB $rab)
    {
        $rabs = [
            'no_rab' => $rab->no_rab,
            'id_penyusun' => $request->id_penyusun,
            'tgl_rab' => $request->tgl_rab,
            'total' => $request->total,
        ];
        if($rab->fill($rabs)->save()){
            RABDetails::where('no_rab', $rab->no_rab)->delete();
            for ($i=1; $i <= $request->jml; $i++) { 
                $details = [
                    'no_rab' => $rab->no_rab,
                    'id_product' => $request['productId'.$i],
                    'product_name' => $request['productName'.$i],
                    'price' => $request['price'.$i],
                    'qty' => $request['qty'.$i],
                    'sub_total' => $request['sub_total'.$i],
                ];
                RABDetails::create($details);
            }
        }           

        return redirect()->route('rabs.index')->with('success','Departement Has Been updated successfully');
    }

    public function destroy(RAB $rab)
    {
        $rab->delete();
        return redirect()->route('rabs.index')->with('success','Departement has been deleted successfully');
    }

    public function chartLine()
    {
        $api = route('rabs.chartLineAjax');
   
        $chart = new RabLineChart;
        $chart->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])->load($api);
        $title = "Beranda";
        return view('home', compact('chart', 'title'));
    }
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function chartLineAjax(Request $request)
    {
        $year = $request->has('year') ? $request->year : date('Y');
        $rabs = RAB::select(\DB::raw("COUNT(*) as count"))
                    ->whereYear('tgl_rab', $year)
                    ->groupBy(\DB::raw("Month(tgl_rab)"))
                    ->pluck('count');
  
        $chart = new RabLineChart;
  
        $chart->dataset('RAB Chart', 'bar', $rabs)->options([
                    'fill' => 'true',
                    'borderColor' => '#51C1C0'
                ]);
  
        return $chart->api();
    }
}

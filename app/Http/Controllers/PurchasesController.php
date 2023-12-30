<?php

namespace App\Http\Controllers;

use App\Exports\exportPurchases;
use Illuminate\Http\Request;
use App\Models\Purchases;
use App\Models\Purchases_details;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class PurchasesController extends Controller
{

    //____________role super admin
    public function index(Request $request)
    
    {

        $user = Auth::user();

        $user_id = $user->id;

        $data_purchases = Purchases::where('user_id', $user_id)->first();

        $dataAllPurchases = Purchases_details::orderBy('id', 'desc')->paginate(8);
    
        return view('purchases.index')->with('data', $dataAllPurchases);
        
    }

    public function store(Request $request)
    {

        $user = Auth::user();
        $user_id = $user->id;
            
        $dataPurchases = [
            'number' => rand(),
            'user_id' => $user_id,
            'date' => now()->format('Y-m-d H:i:s') 
        ];
            
       $purchases = Purchases::create($dataPurchases);     

        $data_purchases_detail = [
            'purchase_id'  =>  $purchases->id,
            'inventory_id'  =>  $request->inventory_id,
            'qty' =>  $request->qty ?? 1,
            'price' =>  $request->price
        ];


        $inventory_Exists =  Purchases_details::where('inventory_id', $request->inventory_id )->exists();


        if($inventory_Exists ) {

            Purchases_details::where('inventory_id', $request->inventory_id)->increment('qty', 1);

        } else {

             Purchases_details::create($data_purchases_detail);

        }      

        $request->session()->flash('success', 'Berhasil menambahkan product');

        return redirect ('/');
    }


    public function update(Request $request, $id)
    {
        $data = 
        
        [
            'qty'  =>  $request->qty,
        ];

        Purchases_details::where('id', $id)->update($data);
        
        $request->session()->flash('success', 'Berhasil update data');
    

        return redirect ('/purchases');

    }

     //excel
     public function exportExcel()
     {
         return Excel::download(new exportPurchases, 'purchases.xlsx');
     } 
 
     //csv 
     public function exportCsv()
     {
 
         return Excel::download(new exportPurchases, 'purchases.csv');
     } 
 
 
     //pdf 
     public function exportPdf() 
     {
         $mpdf = new \Mpdf\Mpdf();
         $data = Purchases_details::orderBy('id', 'desc')->paginate(6);
         $mpdf->WriteHTML(view('purchases.viewTablePurchases')->with('data', $data));
         $mpdf->Output();
     }

    public function destroy(Request $request, $id)
    {

        Purchases_details::where('id', $id)->delete();

        Purchases::where('id', $request->purchase_id)->delete();

        $request->session()->flash('success', 'Berhasil delete produk');

        return redirect ('/purchases');
    }

    // role purchase
    public function getPurchases(Request $request)
    {

        $user = Auth::user();
        $user_id = $user->id;

        $data_purchases = Purchases::where('user_id', $user_id)->first();

        $dataAllPurchases = Purchases_details::orderBy('id', 'desc')->paginate(8);
    
        return view('purchase.index')->with('data', $dataAllPurchases);
        
    }

    public function update_purc(Request $request, $id)
    {
        $data = 
        
        [
            'qty'  =>  $request->qty,
        ];

        Purchases_details::where('id', $id)->update($data);
        
        $request->session()->flash('success', 'Berhasil update data');
    

        return redirect ('/purchases/purc/get');

    }

    public function destroy_purc(Request $request, $id)
    {

        Purchases_details::where('id', $id)->delete();

        Purchases::where('id', $request->purchase_id)->delete();

        $request->session()->flash('success', 'Berhasil delete produk');

        return redirect ('/purchases/purc/get');
    }

    // role manager
    public function viewPurchases(Request $request)
    
    {

        $dataAllPurchases = Purchases_details::orderBy('id', 'desc')->paginate(8);
    
        return view('manager.viewPurchases')->with('data', $dataAllPurchases);
        
    }



    


    public function payAll(Request $request)
    {
        return $request->all();
        
    }
}

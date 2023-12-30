<?php

namespace App\Http\Controllers;
use App\Exports\exportInventory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Inventories;
use App\Models\Purchases_details;
use App\Models\Sales_details;
use App\Models\Sales;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use PDF;

class ProductsController extends Controller
{
    // role super admin
    public function index(Request $request)
    
    {
        $katakunci  = $request->katakunci;
        $jumlah     = 8;


        if(strlen($katakunci) ) {
            $data = Inventories::where('name', 'like', "%$katakunci%")
            ->paginate($jumlah);
        } 

        else {
            $data = Inventories::orderBy('id', 'desc')->paginate($jumlah);
        }
        
        return view('dashboard')->with('data', $data);
    }

    public function create()
    {
        $data = Inventories::orderBy('id', 'desc')->paginate(6);

        return view('products.addProduct')->with('data', $data);
    }

    public function store(Request $request)
    {
        
        // menambah data ke tabel inventory
        $validatedData = $request->validate([
            'code'  => 'required|unique:inventories,code',
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required'
        ], [
            'code.required'  => 'Code wajib diisi',
            'code.unique'    => 'Code sudah pernah digunakan',
            'name.required'  => 'Nama wajib diisi',
            'price.required' => 'Harga wajib diisi',
            'price.numeric'  => 'Harga harus berupa angka',
            'stock.required' => 'Stok wajib diisi'
        ]);
        
            
        $data_inventory = [
            'code'  =>  $request->code,
            'name'  =>  $request->name,
            'price' =>  $request->price,
            'stock' =>  $request->stock
        ];

       $inventory = Inventories::create($data_inventory);

       $user_id = Auth::id();
   
       $get_user_sales =  Sales::where('user_id', $user_id)->first();

       if(!$get_user_sales) {

            $request->session()->flash('error', 'Seller tidak terdaftar, silahkan registrasi dulu');

       } else {

          $data_sales_detail = [

            'sales_id'  =>  $get_user_sales->id,
            'inventory_id'  =>  $inventory->id,
            'qty' =>  $request->stock,
            'price' =>  $request->price

        ];

        // menambah data ke tabel sales_detail
        Sales_details::create($data_sales_detail);

       }   


        $request->session()->flash('success', 'Tambah produk berhasil');

        return redirect ('/product/addProduct');

    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'code'  => 'required',
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required'
        ], [
            'code.required'  => 'Code wajib diisi',
            'name.required'  => 'Nama wajib diisi',
            'price.required' => 'Harga wajib diisi',
            'price.numeric'  => 'Harga harus berupa angka',
            'stock.required' => 'Stok wajib diisi'
        ]);
        
        $data = [
            'code'  =>  $request->code,
            'name'  =>  $request->name,
            'price' =>  $request->price,
            'stock' =>  $request->stock
        ];

        Inventories::where('id', $id)->update($data);
        
        $request->session()->flash('success', 'Berhasil update data');
    
        return redirect ('/product/addProduct');

    }


    public function update_stock(Request $request, $id)
    {
        $update_status = [
            'status_bayar'  =>  1 
        ];

        Purchases_details::where('id', $request->id)->update($update_status);


        $update_stock = [
            'stock'  => ( $request->stock) - ($request->qty )
        ];


        Inventories::where('id', $request->inventory_id)->update($update_stock);

        $request->session()->flash('success', 'Pembayaran berhasil');

        return redirect ('/purchases');

    }

    public function destroy(Request $request, $id)
    {
        Inventories::where('id', $id)->delete();

        $request->session()->flash('success', 'Berhasil delete produk');

        return redirect ('/product/addProduct');

    } 

    // role sales
    public function create_sal()
    {
        $data = Inventories::orderBy('id', 'desc')->paginate(6);

        return view('salles.addProduct')->with('data', $data);
    }

    public function store_sal(Request $request)
    {
        
        // menambah data ke tabel inventory
        $validatedData = $request->validate([
            'code'  => 'required|unique:inventories,code',
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required'
        ], [
            'code.required'  => 'Code wajib diisi',
            'code.unique'    => 'Code sudah pernah digunakan',
            'name.required'  => 'Nama wajib diisi',
            'price.required' => 'Harga wajib diisi',
            'price.numeric'  => 'Harga harus berupa angka',
            'stock.required' => 'Stok wajib diisi'
        ]);
        
            
        $data_inventory = [
            'code'  =>  $request->code,
            'name'  =>  $request->name,
            'price' =>  $request->price,
            'stock' =>  $request->stock
        ];

       $inventory = Inventories::create($data_inventory);

       $user_id = Auth::id();
   
       $get_user_sales =  Sales::where('user_id', $user_id)->first();

       if(!$get_user_sales) {

            $request->session()->flash('error', 'Seller tidak terdaftar, silahkan registrasi dulu');

       } else {

          $data_sales_detail = [

            'sales_id'  =>  $get_user_sales->id,
            'inventory_id'  =>  $inventory->id,
            'qty' =>  $request->stock,
            'price' =>  $request->price

        ];

        // menambah data ke tabel sales_detail
        Sales_details::create($data_sales_detail);

       }   


        $request->session()->flash('success', 'Tambah produk berhasil');

        return redirect ('/product/sal/addProduct');

    }


    public function update_sal(Request $request, $id)
    {
        $validatedData = $request->validate([
            'code'  => 'required',
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required'
        ], [
            'code.required'  => 'Code wajib diisi',
            'name.required'  => 'Nama wajib diisi',
            'price.required' => 'Harga wajib diisi',
            'price.numeric'  => 'Harga harus berupa angka',
            'stock.required' => 'Stok wajib diisi'
        ]);
        
        $data = [
            'code'  =>  $request->code,
            'name'  =>  $request->name,
            'price' =>  $request->price,
            'stock' =>  $request->stock
        ];

        Inventories::where('id', $id)->update($data);
        
        $request->session()->flash('success', 'Berhasil update data');
    
        return redirect ('/product/sal/addProduct');

    }


    public function update_stock_sal(Request $request, $id)
    {
        $update_status = [
            'status_bayar'  =>  1 
        ];

        Purchases_details::where('id', $request->id)->update($update_status);


        $update_stock = [
            'stock'  => ( $request->stock) - ($request->qty )
        ];


        Inventories::where('id', $request->inventory_id)->update($update_stock);

        $request->session()->flash('success', 'Pembayaran berhasil');

        return redirect ('/purchases');

    }

    public function destroy_sal(Request $request, $id)
    {
        Inventories::where('id', $id)->delete();

        $request->session()->flash('success', 'Berhasil delete produk');

        return redirect ('/product/sal/addProduct');

    } 

   
    //excel
    public function exportExcel()
    {
        return Excel::download(new exportInventory, 'inventory.xlsx');
    } 

    //csv 
    public function exportCsv()
    {
        return Excel::download(new exportInventory, 'inventory.csv');
    } 


    //pdf 
    public function exportPdf() 
    {
        $mpdf = new \Mpdf\Mpdf();
        $data = Inventories::orderBy('id', 'desc')->paginate(6);
        $mpdf->WriteHTML(view('products.viewTableProduct')->with('data', $data));
        $mpdf->Output();
    }

}

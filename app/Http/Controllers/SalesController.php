<?php

namespace App\Http\Controllers;
use App\Exports\exportSales;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
    public function index(Request $request)
    
    {
        $katakunci  = $request->katakunci;
        $jumlah     = 8;


        if(strlen($katakunci) ) {
            $data = Sales::where('name', 'like', "%$katakunci%")
            ->paginate($jumlah);
        } 

        else {
            $data = Sales::orderBy('id', 'desc')->paginate($jumlah);

            $users = user::all();
        }
        
        return 
            view('sales.addSales')
                ->with('data', $data)
                ->with('users', $users);
    }

    // role manager
    public function viewSales(Request $request)
    
    {
        $katakunci  = $request->katakunci;
        $jumlah     = 8;


        if(strlen($katakunci) ) {
            $data = Sales::where('name', 'like', "%$katakunci%")
            ->paginate($jumlah);
        } 

        else {
            $data = Sales::orderBy('id', 'desc')->paginate($jumlah);

        }
        
        return view('manager.viewSales')->with('data', $data);
              
    }


 
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;
    
        $validatedData = $request->validate([

            'user_id' => 'required|unique:sales,user_id,' . $user_id
        ], 
        [
            'user_id.required'    => 'User ID wajib diisi',
            'user_id.unique'    => 'User ID sudah terdaftar'
        ]);
    
        $data = [
            'number'  =>  rand(),
            'date'    =>  now()->format('Y-m-d H:i:s') ,
            'user_id' =>  $request->user_id ?? $user_id,
        ];

        $user_Exists =  User::where('id', $request->user_id ?? $user_id )->exists();

        if(!$user_Exists) {

            $request->session()->flash('error', 'user_id tidak terdaftar di dalam tabel  user, silahkan registrasi akun anda terlebih dahulu');
 
            return redirect('/sales');

        } else {
             Sales::create($data);
    
            $request->session()->flash('success', 'Tambah seller berhasil');
    
            return redirect('/sales');
        }

    }
    


    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $user_Exists =  User::where('id', $request->user_id ?? $user_id )->exists();

        if (!$user_Exists) {
             $request->session()->flash('error', 'User tidak ditemukan ');
        
            return redirect('/sales');
        }
        

        $validatedData = $request->validate([

            'user_id' => 'required|unique:sales,user_id,' . $user_id
        ], 
        [
            'user_id.required'    => 'User ID wajib diisi',
            'user_id.unique'    => 'User ID sudah terdaftar'
        ]);
    
        $data = [
            'number'  =>  $request->number,
            'date'    =>  $request->date,
            'user_id' =>  $request->user_id ?? $user_id,
        ];

        Sales::where('id', $id)->update($data);
        
        $request->session()->flash('success', 'Berhasil update data');

        return redirect ('/sales');
        
    }

    //excel
    public function exportExcel()
    {
        return Excel::download(new exportSales, 'sales.xlsx');
    } 

    //csv 
    public function exportCsv()
    {

        return Excel::download(new exportSales, 'sales.csv');
    } 

    // pdf
    public function exportPdf() 
    {
        $mpdf = new \Mpdf\Mpdf();
        $data = Sales::orderBy('id', 'desc')->paginate(6);
        $mpdf->WriteHTML(view('sales.viewTableSales')->with('data', $data));
        $mpdf->Output();
    }

    public function destroy(Request $request, $id)
    {
        Sales::where('id', $id)->delete();

        $request->session()->flash('success', 'Berhasil delete seller');

        return redirect ('/sales');
    }


    // role manager
   
}

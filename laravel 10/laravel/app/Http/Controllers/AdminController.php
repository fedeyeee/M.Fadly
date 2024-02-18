<?php

namespace App\Http\Controllers;

use App\Models\produk;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $dataproduk = Produk::all();
        // dd($dataproduk->toArray());
        return view('admin.dashboard', compact('dataproduk'));
    }
    public function stok(){
        $dataproduk = Produk::all();
        // dd($dataproduk->toArray());
        return view('admin.stok', compact('dataproduk'));
    }
    
    public function create(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'namaproduk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            // ... tambahkan aturan validasi lain sesuai kebutuhan
        ]);   
        

        
        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('assets/img/barang/', $filename);
            $link = 'assets/img/barang/'.$filename;
            // dd($link);   
            
            $newdata = new Produk();
            $newdata->namaproduk = $request->namaproduk;
            $newdata->harga = $request->harga;
            $newdata->stok = $request->stok;
            $newdata->image = $link;
            $newdata->save();
        }else{
            $dataproduk = new Produk;
            $dataproduk->namaproduk = $request->namaproduk;
            $dataproduk->harga = $request->harga;
            $dataproduk->stok = $request->stok;
            // ... tambahkan kolom lain sesuai kebutuhan
            $dataproduk->save();
        }
       
        return redirect()->route('admin.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $dataproduk = Produk::find($id);
        $dataproduk->delete();
        return redirect()->route('admin.index')->with('success', 'Data berhasil dihapus!');
    }

    public function edit($id)
    {
        $data = Produk::find($id);
        return response()->json($data);
    }


    public function update(Request $request)
    {
        // dd(request()->all());
        // dd($request->all());
        $req = $request;
        $stok =Produk::find($request->id);
     
        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('assets/img/barang/', $filename);
            $link = 'assets/img/barang/'.$filename;
            // dd($link);   
            
            $newdata = produk::find($request->id);
            $newdata->namaproduk = $request->namaproduk;
            $newdata->harga = $request->harga;
            $newdata->stok = $request->stok;
            $newdata->image = $link;
            $newdata->update();
        }else{
            $dataproduk = produk::find($request->id);
            $dataproduk->namaproduk = $request->namaproduk;
            $dataproduk->harga = $request->harga;
            $dataproduk->stok = $request->stok;

            $dataproduk->update();
        }

        if ($req->namaproduk == $stok->namaproduk && $req->harga == $stok->harga && $req->stok== $stok->stok) {
            return redirect()->route('admin.index')->with('else', 'Data tidak ada yang diubah!');
        }else{

            return redirect()->route('admin.index')->with('success', 'Data berhasil diupdate!'); 
        }
    }

    public function stokupdate(Request $request)
    {
        $stok = $request->stok;
        $stokdata=Produk::find($request->id);
        $stoc = $stokdata->stok;
       
        if($request->hasFile('image')){
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('assets/img/barang/', $filename);
            $link = 'assets/img/barang/'.$filename;
            // dd($link);   
            
            $newdata = produk::find($request->id);
            $newdata->namaproduk = $request->namaproduk;
            $newdata->harga = $request->harga;
            $newdata->stok = $request->stok;
            $newdata->image = $link;
            $newdata->update();
        }else{
            $dataproduk = produk::find($request->id);
            $dataproduk->namaproduk = $request->namaproduk;
            $dataproduk->harga = $request->harga;
            $dataproduk->stok = $request->stok;

            $dataproduk->update();
        }
        // return redirect()->route('admin.index')->with('success', 'Data berhasil diupdate!');

        $data = produk::find($request->id);

        if($stok == $stoc){
            return redirect()->route('admin.stok')->with('success', 'Data berhasil diupdate!');
        }
        elseif ($stok >= $stoc) {
          $tambah = $stok - $stoc;
          return redirect()->route('admin.stok')->with('success', 'Data berhasil diupdate! '.$tambah.' barang ditambahkan '.$data->namaproduk.'');
        }elseif ($stoc > $stok) {
         $kurang = $stoc - $stok;

        return redirect()->route('admin.stok')->with('success', 'Data berhasil diupdate! '.$kurang.' barang dikurangi '.$data->namaproduk.'');
        }else{

            return redirect()->route('admin.stok')->with('else', 'Data tidak ada yang diubah!');
        }
        
    }

    public function register()
    {
        $data = User::all();

        return view('admin.register', compact('data'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = $request->level;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('admin.register')->with('success', 'Data berhasil ditambahkan!');
    }


    public function showuser($id)
    {
        $data = User::find($id);
        return response()->json($data);
    }

    public function updateuser()
    {

        $user = User::find(request()->id);
        $user->name = request()->name;
        $user->email = request()->email;
        $user->level = request()->level;
        $user->password = bcrypt(request()->password);
        $user->update();
        return redirect()->route('admin.register')->with('success', 'Data berhasil diupdate!');
    }

    public function destroyuser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.register')->with('success', 'Data berhasil dihapus!');
    }
    
}

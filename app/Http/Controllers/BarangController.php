<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();
        $kategori = Kategori::all();
        $satuan = Satuan::all();

        $now = Carbon::now();
        $tahun_bulan = $now->year . $now->month;
        $cek = Barang::count();

        if($cek == 0){
            $kode = 100001;
            $kode = $tahun_bulan . $kode;
        }else {
            $ambil = Barang::all()->last();
            $kode = (int)substr($ambil->kode, -6) + 1;
            $kode = $tahun_bulan . $kode;
        }

        return view('barang.index', compact('barang', 'kategori', 'satuan', 'kode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'kode' => 'required|string|max:255',
                'nama' => 'required|string|max:255',
                'kategori_id' => 'required|exists:kategoris,id',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0',
                'satuan_id' => 'required|exists:satuans,id', 
                'stok' => 'required|integer|min:0',
                'diskon' => 'nullable|numeric|min:0|max:100',
            ]);
    
            $barang = new Barang;
            $barang->kode = $request->kode;
            $barang->nama = $request->nama;
            $barang->kategori_id = $request->kategori_id;
            $barang->harga_beli = $request->harga_beli;
            $barang->harga_jual = $request->harga_jual;
            $barang->satuan_id = $request->satuan_id;
            $barang->stok = $request->stok;
            $barang->diskon = $request->diskon;
            $barang->save();
    
    
            return redirect('/admin/barang')->with('sukses', 'Data Berhasil di Simpan');
        }catch(\Exception $e){
            return redirect('/admin/barang')->with('gagal', 'Data Tidak Berhasil di Simpan. Pesan Kesalahan: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $barang = Barang::find($id);
        $kategori = \App\Models\Kategori::all();
        $satuan = \App\Models\Satuan::all();

        return view('barang.view', compact('barang', 'kategori', 'satuan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barang = Barang::find($id);
        $kategori = \App\Models\Kategori::all();
        $satuan = \App\Models\Satuan::all();

        return view('barang.edit', compact('barang', 'kategori', 'satuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try{
            $request->validate([
                'nama' => 'required|string|max:255',
                'kategori_id' => 'required|exists:kategoris,id',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0',
                'satuan_id' => 'required|exists:satuans,id', 
                'stok' => 'required|integer|min:0',
                'diskon' => 'nullable|numeric|min:0|max:100',
            ]);
    
            $barang = Barang::find($id);
            $barang->nama = $request->nama;
            $barang->kategori_id = $request->kategori_id;
            $barang->harga_beli = $request->harga_beli;
            $barang->harga_jual = $request->harga_jual;
            $barang->satuan_id = $request->satuan_id;
            $barang->stok = $request->stok;
            $barang->diskon = $request->diskon;
            $barang->update();
    
    
            return redirect('/admin/barang')->with('sukses', 'Data Berhasil di Edit');
        }catch(\Exception $e){
            return redirect('/admin/barang')->with('gagal', 'Data Tidak Berhasil di Edit. Pesan Kesalahan: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);
        $barang->delete();

        return redirect('/admin/barang')->with('sukses', 'Data Berhasil di Hapus');
    }
}

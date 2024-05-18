<?php

namespace App\Http\Controllers;

use App\Models\TransaksiSementara;
use App\Models\TransaksiDetail;
use App\Models\Transaksi;
use App\Models\Barang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TransaksiSementaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::all();
        $transaksi_sementara = TransaksiSementara::all();
        $now = Carbon::now();
        $tahun_bulan = $now->year . $now->month;
        $cek = Transaksi::count();
        
        if($cek == 0){
            $urut = 10000001;
            $nomor = $tahun_bulan . $urut;
        }else {
            $ambil = Transaksi::all()->last();
            $urut = (int)substr($ambil->kode_transaksi, -8) + 1;
            $nomor = $tahun_bulan . $urut;
        }

        return view('penjualan.index', compact('barang', 'transaksi_sementara', 'nomor'));
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
        $user = Auth::user();

        $data = $request->all();

        $sub_total = ($data['harga'] - ($data['diskon'] * $data['harga'] / 100)) * $data['jumlah'];

        $barangAda = TransaksiSementara::where('barang_id', $request->barang_id)->first();
        
        if($barangAda) {
            return redirect('/' . $user->level . '/penjualan')->with('warning', 'Barang Yang Sama Sudah Tersedia');
        }else{
            $transaksi_sementara = new TransaksiSementara;
            $transaksi_sementara->kode_transaksi = $request->kode_transaksi;
            $transaksi_sementara->barang_id = $request->barang_id;
            $transaksi_sementara->harga = $request->harga;
            $transaksi_sementara->jumlah = $request->jumlah;
            $transaksi_sementara->diskon = $request->diskon;
            $transaksi_sementara->total = $sub_total;
            $transaksi_sementara->save();
        }
        
        return redirect('/' . $user->level . '/penjualan');
    }

    /**
     * Display the specified resource.
     */
    public function show(TransaksiSementara $transaksiSementara)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $barang_id)
    {
        $user = Auth::user();

        $data = $request->all();
        $barang = Barang::find($barang_id);

        if($barang->stok >= $data['jumlah']){
            $sub_total = ($data['harga'] - ($data['diskon'] * $data['harga'] / 100)) * $data['jumlah'];
    
            $transaksi_sementara = TransaksiSementara::find($id);
            $transaksi_sementara->jumlah = $request->jumlah;
            $transaksi_sementara->total = $sub_total;
            $transaksi_sementara->update();
    
            return redirect('/' . $user->level . '/penjualan');
        }else{
            return redirect('/' . $user->level . '/penjualan')->with('gagal', $barang->nama . ' hanya tersisa ' . $barang->stok);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $transaksi_sementara = TransaksiSementara::find($id);
        $transaksi_sementara->delete();

        return redirect('/' . $user->level . '/penjualan');
    }

    public function hapusSemua()
    {
        $user = Auth::user();
        
        TransaksiSementara::truncate(); // Menghapus semua data dari tabel Transaksi
        
        return redirect('/' . $user->level . '/penjualan');
    }
    
    public function bayar(Request $request, $kode_transaksi)
    {
        $user = Auth::user();

        $transaksi_sementara = TransaksiSementara::all();

        if($transaksi_sementara->isEmpty())
        {
            return redirect('/' . $user->level . '/penjualan')->with('gagal', 'Transaksi Gagal');
        }
        else
        {
            try{
                $request->validate([
                    'kode_transaksi' => 'required|string|max:255',
                    'total' => 'required|numeric',
                    'bayar' => 'required|numeric',
                    'kembali' => 'required|numeric',
                    'kode_kasir' => 'required|string|max:255',
                ]);


                $tanggalSekarang = now('Asia/Jakarta')->format('Y-m-d H:i:s');
                $transaksi = new Transaksi;
                $transaksi->kode_transaksi = $request->kode_transaksi;
                $transaksi->total = $request->total;
                $transaksi->bayar = $request->bayar;
                $transaksi->kembali = $request->kembali;
                $transaksi->kode_kasir = $request->kode_kasir;
                $transaksi->tanggal = $tanggalSekarang;
                $transaksi->save();

                foreach ($transaksi_sementara as $data) {
                    $barang = Barang::find($data->barang_id);
        
                        $kurangi = $barang->stok - $data->jumlah;
        
                        $barang->update(['stok' => $kurangi]);

                        TransaksiDetail::create([
                            'kode_transaksi' => $data->kode_transaksi,
                            'barang' => $barang->nama,
                            'harga' => $data->harga,
                            'jumlah' => $data->jumlah,
                            'diskon' => $data->diskon,
                            'total' => $data->total,
                        ]);

                        TransaksiSementara::truncate();
                }
            }
            catch(\Exception $e){
                return redirect('/' . $user->level . '/penjualan')->with('gagal', 'Transaksi gagal Pesan Kesalahan: ' . $e->getMessage());
            }

            return redirect('/' . $user->level . '/penjualan')->with('berhasil', $kode_transaksi);
        }
    }
}

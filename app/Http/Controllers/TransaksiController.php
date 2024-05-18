<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Barang;
use App\Models\TransaksiSementara;
use App\Models\TransaksiDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksi = Transaksi::orderBy('tanggal', 'desc')->get();

        return view('laporan.index', compact('transaksi'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($kodeTransaksi)
    {
        $data = TransaksiDetail::where('kode_transaksi', $kodeTransaksi)->get();
        
        return view('laporan.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        
    }

    public function print($kode_transaksi)
     {
        $id_transaksi = Transaksi::where('kode_transaksi', $kode_transaksi)->first();
        $transaksi = Transaksi::find($id_transaksi->id);
        $transaksi_detail = TransaksiDetail::where('kode_transaksi', $kode_transaksi)->get();

        $pdf = Pdf::loadView('laporan.print', compact('transaksi', 'transaksi_detail'));
        return $pdf->stream();
    }
    
    public function cari(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $tanggalSampai = Carbon::parse($sampai)->addDays(1)->format('Y-m-d');
        
        $transaksi = Transaksi::whereBetween('tanggal', [$dari, $tanggalSampai])->get();
        
        return view('laporan.cari',compact('transaksi', 'dari', 'sampai'));
    }
    
    public function printTanggal($dari, $sampai)
    {
        $tanggalSampai = Carbon::parse($sampai)->addDays(1)->format('Y-m-d');
        $transaksi = Transaksi::whereBetween('tanggal', [$dari, $tanggalSampai])->get();
        
        $totalAll = 0;
        foreach($transaksi as $data)
        {
            $totalAll += $data->total;
        }

        $total = number_format($totalAll, 0, ',', '.');

        $pdf = Pdf::loadView('laporan.printTanggal', compact('transaksi', 'dari', 'sampai', 'total'));
        return $pdf->stream();
    }
}

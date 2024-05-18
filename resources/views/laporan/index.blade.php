@extends('layout.app')

@section('title', ' - Laporan')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Laporan</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    @if(auth()->user()->level == 'admin')
                    <div class="card-header bg-white justify-content-center">
                        <form action="/{{auth()->user()->level}}/laporan/cari">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group d-flex">
                                        <label class="mr-1" for="nama">Dari</label>
                                        <input type="date" class="form-control" name="dari" id="tanggalDari" max="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group d-flex">
                                        <label class="mr-1" for="nama">Sampai</label>
                                        <input type="date" class="form-control mr-5" name="sampai" id="tanggalSampai" max="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-search"></i> Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                    @if(auth()->user()->level == 'kasir')
                    <div class="card-header bg-white">
                        <h4 class="text-primary">Riwayat Transaksi</h4>
                    </div>
                    @endif
                    <div class="card-body p-2">
                        <table class="table table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Kode Kasir</th>
                                    <th>Total</th>
                                    <th>Bayar</th>
                                    <th>Kembali</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->kode_transaksi}}</td>
                                    <td>{{$item->tanggal}}</td>
                                    <td>{{$item->kode_kasir}}</td>
                                    <td>{{$item->formatRupiah('total')}}</td>
                                    <td>{{$item->formatRupiah('bayar')}}</td>
                                    <td>{{$item->formatRupiah('kembali')}}</td>
                                    <td>
                                        <a href="/{{auth()->user()->level}}/laporan/{{$item->kode_transaksi}}"
                                            class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i> Detail</a>
                                        <a href="/{{auth()->user()->level}}/laporan/{{$item->kode_transaksi}}/print" target="_blank"
                                            class="btn btn-sm btn-outline-danger"><i class="fa fa-print"></i> Print</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    $(document).ready(function () {
        $('#table').DataTable();
    });

    // Mendapatkan elemen input tanggal
    var tanggal_dari = document.getElementById('tanggalDari');
    var tanggal_sampai = document.getElementById('tanggalSampai');

    // Mendapatkan tanggal hari ini
    var today = new Date();
    var year = today.getFullYear();
    var month = String(today.getMonth() + 1).padStart(2, '0'); // Tambahkan nol di depan jika bulan < 10
    var day = String(today.getDate()).padStart(2, '0'); // Tambahkan nol di depan jika tanggal < 10

    // Format tanggal sebagai "YYYY-MM-DD" (format yang diharapkan untuk input type="date")
    var formattedDate = year + '-' + month + '-' + day;

    // Set nilai input tanggal menjadi tanggal hari ini
    tanggal_dari.value = formattedDate;
    tanggal_sampai.value = formattedDate;
</script>
@endpush

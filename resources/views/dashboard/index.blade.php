@extends('layout.app')

@section('title', ' - Dashboard')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="alert alert-success">
        <p>Hallo <span class="font-weight-bold">{{auth()->user()->nama}}</span>, Kamu Login Sebagai <span class="font-weight-bold">{{auth()->user()->level}}</span>.</p>
    </div>

    @if(auth()->user()->level=='admin')
    <div class="section-body">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Barang</h4>
                        </div>
                        <div class="card-body">
                            {{$barang->count()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1" id="stokCard">
                    <div class="card-icon bg-info">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Stok Kosong</h4>
                        </div>
                        <div class="card-body">
                            {{$stok_kosong->count()}}
                        </div>
                        <a href="stok-kosong" data-toggle="modal" data-target="#stok-kosong">Detail</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4> Total Transaksi</h4>
                        </div>
                        <div class="card-body">
                            {{$transaksi->count()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Transaksi Hari ini</h4>
                        </div>
                        <div class="card-body">
                            {{$transaksi_hari_ini->count()}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header bg-white">
                        <h4 class="text-info">Detail Transaksi</h4>
                    </div>
                    <div class="card-body p-2">
                        <table class="table table-hover" id="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode transaksi</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Diskon</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($detail as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->kode_transaksi}}</td>
                                    <td>{{$item->barang}}</td>
                                    <td>{{$item->formatRupiah('harga')}}</td>
                                    <td>{{$item->jumlah}}</td>
                                    <td>{{$item->diskon}}%</td>
                                    <td>{{$item->formatRupiah('total')}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>
@include('dashboard.kosong')
@endsection

@push('script')
<script>
    $(document).ready(function () {
        $('#table').DataTable();
    });

    $(document).ready(function () {
        $('#data-table').DataTable();
    });

    var colors = ['#FCFF52', '#ffff']; // Array of colors
    var lastColorIndex = -1; // Initialize last color index

    function changeBackgroundColor() {
        var card = document.getElementById('stokCard');
        var randomColorIndex = Math.floor(Math.random() * colors.length); // Pick a random color index

        // Ensure the next random color is different from the previous one
        while (randomColorIndex === lastColorIndex) {
            randomColorIndex = Math.floor(Math.random() * colors.length);
        }

        var randomColor = colors[randomColorIndex]; // Get the random color
        card.style.backgroundColor = randomColor; // Set background color
        lastColorIndex = randomColorIndex; // Update last color index
    }

    var stockCount = {{$stok_kosong->count()}};
    if (stockCount > 0) {
        setInterval(changeBackgroundColor, 300); // Call the function every second
    }
</script>
@endpush
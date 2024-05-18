@extends('layout.app')

@section('title', ' - Barang')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Barang</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-white">
                        <h4 class="position-absolute text-primary">Data Barang</h4>
                        <div class="card-header-form float-right">
                            <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal"
                                data-target="#form-tambah"><i class="fa fa-plus"></i> Tambah</button>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode</th>
                                        <th style="width: 20%">Nama</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Stok</th>
                                        <th>Diskon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barang as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->kode}}</td>
                                        <td>{{$item->nama}}</td>
                                        <td>{{$item->formatRupiah('harga_beli')}}</td>
                                        <td>{{$item->formatRupiah('harga_jual')}}</td>
                                        @if($item->stok <= 0)
                                        <td><span class="text-danger">Stok Habis</span></td>
                                        @endif
                                        @if($item->stok > 0)
                                        <td>{{$item->stok}}</td>
                                        @endif
                                        <td>{{$item->diskon}}%</td>
                                        <td>
                                            <form action="/{{auth()->user()->level}}/barang/{{$item->id}}" id="delete-form">
                                                <a href="/{{auth()->user()->level}}/barang/{{$item->id}}/show"
                                                    class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i>
                                                    Detail</a>
                                                <a href="/{{auth()->user()->level}}/barang/{{$item->id}}/edit"
                                                    class="btn btn-sm btn-outline-warning" ata-toggle="modal"
                                                    data-target="#form-edit"><i class="fa fa-edit"></i>
                                                    Edit</a>
                                                @csrf
                                                @method('delete')
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    id="{{$item->kode}}" data-id="{{$item->id}}"
                                                    onclick="confirmDelete(this)"><i class="fa fa-trash"></i> Delete</a>
                                            </form>
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
    </div>
</section>
@include('barang.form');
@endsection

@push('script')
<script>
    $(document).ready(function () {
        $('#table').DataTable();
    });

    $(document).ready(function () {
        $('.jumlah').on('input', function () {
            if ($(this).val() < 0) {
                $(this).val(0);
            }
        });
    })

    // Mengambil elemen input
    var harga_beli = document.getElementById('harga-beli');
    var harga_jual = document.getElementById('harga-jual');
    var diskon = document.getElementById('diskon');

    // Menambahkan event listener untuk setiap kali ada input
    harga_beli.addEventListener('input', function() {
      // Mengganti nilai input hanya dengan karakter angka
      this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Menambahkan event listener untuk setiap kali ada input
    harga_jual.addEventListener('input', function() {
      // Mengganti nilai input hanya dengan karakter angka
      this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Menambahkan event listener untuk setiap kali ada input
    diskon.addEventListener('input', function() {
      // Mengganti nilai input hanya dengan karakter angka
      this.value = this.value.replace(/[^0-9]/g, '');
    });

    var data_anggota = $(this).attr('data-id')

    function confirmDelete(button) {

        event.preventDefault()
        const id = button.getAttribute('data-id');
        const kode = button.getAttribute('id');
        swal({
                title: 'Apa Anda Yakin ?',
                text: 'Anda akan menghapus data: "' + kode +
                    '". Ketika Anda tekan OK, maka data tidak dapat dikembalikan !',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    const form = document.getElementById('delete-form');
                    // Setelah pengguna mengkonfirmasi penghapusan, Anda bisa mengirim form ke server
                    form.action = '/{{auth()->user()->level}}/barang/' + id; // Ubah aksi form sesuai dengan ID yang sesuai
                    form.submit();
                }
            });
    }

</script>
@endpush

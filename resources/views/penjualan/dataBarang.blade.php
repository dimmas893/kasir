<!-- Modal -->
<div class="modal fade" id="data-barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-info" id="exampleModalLabel">Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <div style="overflow-y: scroll; max-height: 400px;">
                            <table class="table table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Stok</th>
                                        <th>Diskon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barang as $item)
                                    <tr>
                                        <form action="/{{auth()->user()->level}}/penjualan/store" method="POST">
                                            @csrf
                                            <td>{{$loop->iteration}}<input class="form-control" type="text"
                                                    value="{{$nomor}}" name="kode_transaksi" hidden></td>
                                            <td>{{$item->nama}}<input class="form-control" type="text"
                                                    value="{{$item->id}}" name="barang_id" hidden></td>
                                            <td>{{$item->formatRupiah('harga_jual')}}<input class="form-control"
                                                    type="text" value="{{$item->harga_jual}}" name="harga" hidden></td>
                                            <td style="width: 15%"><input class="form-control jumlah" type="number"
                                                    name="jumlah" id="jumlah" value="1" min="1" max="{{$item->stok}}">
                                            </td>
                                            @if($item->stok > 0)
                                            <td>{{$item->stok}}<input type="text" value="{{$item->stok}}" hidden><input
                                                    class="form-control" type="text" value="1" hidden></td>
                                            @endif
                                            @if($item->stok <= 0)
                                            <td><span class="text-danger">Stok Habis</span></td>
                                            @endif
                                            <td>{{$item->diskon}}%<input class="form-control" type="text"
                                                    value="{{$item->diskon}}" name="diskon" hidden></td>
                                            @if($item->stok <= 0)
                                            <td><button type="submit" id="tambah" class="btn btn-sm btn-success" disabled><i
                                                        class="fa fa-plus"></i></button></td>
                                            @endif
                                            @if($item->stok > 0)
                                            <td><button type="submit" id="tambah" class="btn btn-sm btn-success"><i
                                                        class="fa fa-plus"></i></button></td>
                                            @endif
                                        </form>
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
</div>

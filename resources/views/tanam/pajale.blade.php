@extends('app')

@section('title')
Pajale
@endsection

@section('breadcrumb')
@parent
<li class="active">Dashboard</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <div class="btn-group">
                    {{-- <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                    <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger btn-xs btn-flat"><i class="fa fa-trash"></i> Hapus</button> --}}
                    {{-- <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-info btn-xs btn-flat"><i class="fa fa-barcode"></i> Cetak Barcode</button> --}}
                </div>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">
                                <input type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Tanaman </th>
                            <th>Luas Panen</th>
                            <th>Kadar</th>
                            <th>Produksi</th>
                            <th>Provitas</th>
                            <th>harga</th>
                            <th width="15%"><i class="fa fa-cog"></i> Aksi</th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

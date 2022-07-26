@extends('app')

@section('title')
    Pajale
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Pajale</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="#" class="btn btn-danger "> <i class="fa fa-trash"> Hapus</i></button>
                    <button onclick="#" class="btn btn-success "> <i class="fa fa-plus"> Tambah</i></button>
                    <button onclick="#" class="btn btn-success "> <i class="fa fa-upload"> Import</i></button>
                    <button onclick="#" class="btn btn-info "> <i class="fa fa-file-pdf-o"> PDF</i></button>
                    <button onclick="#" class="btn btn-primary "> <i class="fa fa-file-excel-o"> Excel</i></button>
                    {{-- <div class="btn-group">
                    <button onclick="addForm('{{ route('produk.store') }}')" class="btn btn-success  btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                    <button onclick="deleteSelected('{{ route('produk.delete_selected') }}')" class="btn btn-danger  btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                     <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-info  btn-flat"><i class="fa fa-barcode"></i> Cetak Barcode</button>
                </div> --}}
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

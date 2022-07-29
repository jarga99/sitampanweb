@extends('app')

@section('title')
    Panen Perkebunan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Perkebunan</li>
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
                                <th>Harga</th>
                                <th>Nama Penginput</th>
                                <th width="15%"><i class="fa fa-cog"></i> Aksi</th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('home')

@section('content')
<section class="content-header">
    <h1>
        LAPORAN PANEN PAJALE
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Panen Pajale</li>
    </ol>
</section>
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="#" class="btn btn-info" style="margin-bottom: 1%"><i class="fa fa-plus-circle"></i>
                        Filter Periode</button>
                    <br>
                    <button onclick="#" class="btn btn-info "> <i class="fa fa-file-pdf-o"> PDF</i></button>
                    <button onclick="#" class="btn btn-primary "> <i class="fa fa-file-excel-o"> Excel</i></button>
                </div>
                <div class="box-body table-responsive" style="margin-top: 1%">
                    <form action="" method="post" class="form-produk">
                        @csrf
                        <table class="table table-stiped table-bordered">
                            <thead class="text-success">
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Kecamatan</th>
                                <th class="text-center">Desa</th>
                                <th class="text-center">Tanaman </th>
                                <th class="text-center">Luas Tanam</th>
                                <th class="text-center">Kadar</th>
                                <th class="text-center">Produksi</th>
                                <th class="text-center">Provitas</th>
                                <th class="text-center">harga</th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

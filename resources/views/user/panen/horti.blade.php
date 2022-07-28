@extends('home')

@section('content')
<section class="content-header">
    <h1>
        LAPORAN PANEN HORTI
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Panen Horti</li>
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
                    <form action="" method="post" class="form-panen-horti">
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

            @includeIf('panen.form_horti')
        @endsection

        @push('scripts')
            <script src="{{ asset('/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
            </script>
            <script>
                let table;

                $(function() {
                            table = $('.table').DataTable({
                                processing: true,
                                autoWidth: false,
                                ajax: {
                                    url: '{{ route('horti.data') }}',
                                },
                                columns: [{
                                        data: 'select_all',
                                        searchable: false,
                                        sortable: false
                                    },
                                    {
                                        data: 'DT_RowIndex',
                                        searchable: false,
                                        sortable: false
                                    },
                                    {
                                        data: 'mst_kecamatan.nama_kecamatan'
                                    },
                                    {
                                        data: 'mst_desa.nama_desa'
                                    },
                                    {
                                        data: 'mst_tanaman.nama_tanaman'
                                    },
                                    {
                                        data: 'luas_lahan'
                                    },
                                    {
                                        data: 'kadar'
                                    },
                                    {
                                        data: 'produksi'
                                    },
                                    {
                                        data: 'provitas'
                                    },
                                    {
                                        data: 'harga'
                                    },
                                    {
                                        data: 'aksi',
                                        searchable: false,
                                        sortable: false
                                    },
                                ]

                            });

                            //Pilih Periode
                            $('#btn-search').on('click', function(e) {
                                const months = ["January", "February", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                                    "September", "Oktober", "November", "Desember"
                                ];
                                var tanggal_awal = new Date($('#tanggal_awal').val()).getDate() + ' ' + months[new Date($(
                                        '#tanggal_awal').val()).getMonth()] + ' ' + new Date($('#tanggal_awal').val())
                                    .getFullYear();
                                var tanggal_akhir = new Date($('#tanggal_akhir').val()).getDate() + ' ' + months[new Date($(
                                        '#tanggal_akhir').val()).getMonth()] + ' ' + new Date($('#tanggal_akhir').val())
                                    .getFullYear();
                                var content_title = `Daftar Penjualan ` + tanggal_awal + ` - ` + tanggal_akhir;
                                table.draw();
                                e.preventDefault();
                                $('#modal-form').modal("hide");
                                $('#form_awal').val($('#tanggal_awal').val());
                                $('#form_akhir').val($('#tanggal_akhir').val());
                                $('#content-title').html(content_title);
                            });
            </script>
        @endpush

@extends('home')

@section('content')

<section class="content-header">
    <h1>
        LAPORAN PUSO PAJALE
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{'/'}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Puso Pajale</li>
    </ol>
</section>

    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <form id="form_pdf" action="{{ route('user.puso.pdf_puso_pajale') }}" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" >
                        <input type="hidden" name="form_akhir" id="form_akhir" >
                    </form>
                    <div class="btn-group">
                        <button target="_blank" class="btn btn-success export_pdf">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </button>
                        <button class="btn btn-primary export_excel"> <i class="fa fa-file-excel-o"> Excel</i></button>
                    </div>
                    <form id="form_excel" action="{{ route('puso.excel_pajale') }}" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" >
                        <input type="hidden" name="form_akhir" id="form_akhir" >
                    </form>
                </div>
                <br>
                <div class="box-body table-responsive">
                    <form action="" method="post" class="form-puso-pajale">
                        @csrf
                        <table class="table table-striped">
                            <thead>
                                <tr class="danger">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kecamatan</th>
                                    <th>Desa</th>
                                    <th>Tanaman </th>
                                    <th>Luas Puso</th>
                                    <th>Kadar</th>
                                    <th>Produksi</th>
                                    <th>Provitas</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            </table>
                    </form>
                </div>
            </div>
        @endsection

        @push('scripts')
            <script src="{{ asset('/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
            </script>
            <script>
                $(function() {
                    table = $('.table').DataTable({
                        processing: true,
                        autoWidth: false,
                        ajax: {
                            url: '{{ route('user.user_puso_pajale.data') }}',
                        },
                        columns: [
                            {
                                data: 'DT_RowIndex',
                                searchable: false,
                                sortable: false
                            },
                            {
                                data: 'updated_at'
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
                        ],

                    });
                });

                $('.export_pdf').click(function() {

                    $('#form_pdf').submit();
                });
                $('.export_excel').click(function() {
                    $('#form_excel').submit();
                });

            </script>
        @endpush

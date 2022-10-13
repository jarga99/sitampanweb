@extends('home')

@section('content')
    <section class="content-header">
        <h1>
            LAPORAN TANAM PAJALE
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{'/'}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Tanam Pajale</li>
        </ol>
    </section>
    @push('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
    @endpush
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    {{-- <button class="btn btn-info" style="margin-bottom: 1%"><i class="fa fa-plus-circle"></i> Filter Periode</button>
                    <br> --}}
                    <form id="form_pdf" action="{{ route('user.tanam.pdf_tanam_pajale') }}" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" value="{{--  $tanggalAwal --}}">
                        <input type="hidden" name="form_akhir" id="form_akhir" value="{{--  $tanggalAkhir --}}">
                    </form>
                    <div class="btn-group">
                        <button target="_blank" class="btn btn-success export_pdf">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </button>
                        <button class="btn btn-primary export_excel"> <i class="fa fa-file-excel-o"> Excel</i></button>
                    </div>
                    <form id="form_excel" action="{{ route('tanam.excel_pajale') }}" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" value="{{--  $tanggalAwal --}}">
                        <input type="hidden" name="form_akhir" id="form_akhir" value="{{--  $tanggalAkhir --}}">
                    </form>
                </div>
                <br>
                <div class="box-body table-responsive">
                    <form action="" method="post" class="form-tanam-pajale">
                        @csrf
                        <table class="table table-striped">
                            <thead>
                                <tr class="success">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Kecamatan</th>
                                    <th>Desa</th>
                                    <th>Tanaman </th>
                                    <th>Luas Tanam</th>
                                </tr>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        @endsection

        @push('scripts')
        <script src="{{asset('js/select2.min.js')}}"></script>
            <script>
                $(document).ready(function() {
                    $('.select2').select2();
                });
            </script>
            <script src="{{ asset('/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
            </script>
            <script>
                let table;

                $(function() {
                    table = $('.table').DataTable({
                        processing: true,
                        autoWidth: false,
                        ajax: {
                            url: '{{ route('user.user_tanam_pajale.data') }}',
                        },
                        columns: [{
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
                        ]

                    });
                });

                $('.export_pdf').click(function() {
                    // var url = "{{ route('user.tanam.pdf_tanam_pajale') }}";
                    // $('#export-penjualan-form form').attr('action', url);

                    $('#form_pdf').submit();
                });
                $('.export_excel').click(function() {
                    $('#form_excel').submit();
                });
            </script>
        @endpush

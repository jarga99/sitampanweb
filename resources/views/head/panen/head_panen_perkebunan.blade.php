@extends('app')

@section('title')
    Data Panen Perkebunan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Panen Perkebunan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <form id="form_pdf" action="{{ route('panen.pdf_perkebunan') }}" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" value="{{-- $tanggalAwal --}}">
                        <input type="hidden" name="form_akhir" id="form_akhir" value="{{-- $tanggalAkhir --}}">
                    </form>
                    <div class="btn-group">
                        <button target="_blank" class="btn btn-success export_pdf">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </button>
                        <button class="btn btn-primary export_excel"> <i class="fa fa-file-excel-o"> Excel</i></button>
                    </div>
                    <form id="form_excel" action="{{ route('panen.excel_perkebunan') }}" method="get"
                        style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" value="{{-- $tanggalAwal --}}">
                        <input type="hidden" name="form_akhir" id="form_akhir" value="{{-- $tanggalAkhir --}}">
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <form action="" method="post" class="form-panen-perkebunan">
                        @csrf
                        <table class="table table-stiped table-bordered">
                            <thead>
                                <th width="3%">No</th>
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
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        @endsection
        @push('scripts')
            <script src="{{ asset('/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
            <script>
                let table;

                $(function() {
                            table = $('.table').DataTable({
                                processing: true,
                                autoWidth: false,
                                ajax: {
                                    url: '{{ route('head.head_panen_perkebunan.data') }}',
                                },
                                columns: [{
                                        data: 'DT_RowIndex',
                                        searchable: false,
                                        sortable: false
                                    },
                                    {
                                        data: 'created_at'
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
                                        data: 'created_by'
                                    },

                                ]

                            });
                        });
                            //

                            $('.export_pdf').click(function() {
                                // var url = "{{ route('panen.pdf_perkebunan') }}";
                                // $('#export-penjualan-form form').attr('action', url);

                                $('#form_pdf').submit();
                            });
                            $('.export_excel').click(function() {
                                $('#form_excel').submit();
                            });
            </script>
        @endpush

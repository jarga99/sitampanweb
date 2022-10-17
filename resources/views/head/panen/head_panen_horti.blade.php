@extends('app')

@section('title')
    Data Panen Horti
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Panen Horti</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="updatePeriode()" class="btn btn-info"><i class="fa fa-plus-circle"></i> Filter
                        Periode</button>
                    <br>
                    <br>
                    <form id="form_pdf" action="{{ route('head.panen.pdf_panen_horti') }}" method="get"
                        style="display: none;">
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
                    <form id="form_excel" action="{{ route('panen.excel_horti') }}" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" value="{{-- $tanggalAwal --}}">
                        <input type="hidden" name="form_akhir" id="form_akhir" value="{{-- $tanggalAkhir --}}">
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <form action="" method="post" class="form-panen-horti">
                        @csrf
                        <table class="table table-striped">
                            <thead>
                                <tr class="warning">
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Tanggal</th>
                                    <th rowspan="2">Kecamatan</th>
                                    <th rowspan="2">Desa</th>
                                    <th rowspan="2">Tanaman </th>
                                    <th colspan="2" style="text-align: center;">Luas Panen</th>
                                    <th rowspan="2">Kadar</th>
                                    <th colspan="2" style="text-align: center;">Produksi</th>
                                    <th rowspan="2">Provitas</th>
                                    <th rowspan="2">Harga</th>
                                    <th rowspan="2">Penginput</th>
                                <tr class="warning">
                                    <th>Hbs</th>
                                    <th>Blm Hbs</th>
                                    <th>Hbs</th>
                                    <th>Blm Hbs</th>
                                </tr>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">Total :</th>
                                    <th id="lh_hbs"></th>
                                    <th id="lh_blm_hbs"></th>
                                    <th colspan="1"></th>
                                    <th id="hbs"></th>
                                    <th id="blm_hbs"></th>
                                    <th colspan="3"></th>
                                </tr>
                                <tr>
                                    <th colspan="7">Rata-Rata :</th>
                                    <th id="kadar"></th>
                                    <th colspan="2"></th>
                                    <th id="prov"></th>
                                    <th id="harga"></th>
                                    <th colspan="1"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
            @includeIf('panen.form')
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
                            url: '{{ route('head.head_panen_horti.data') }}',
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
                                data: 'lh_habis'
                            },
                            {
                                data: 'lh_blm_habis'
                            },
                            {
                                data: 'kadar'
                            },
                            {
                                data: 'habis'
                            },
                            {
                                data: 'blm_habis'
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

                        ],
                        "initComplete": function(settings, json) {
                            var $lh_hbs = 0;
                            var $lh_blm_hbs = 0;
                            var $kadar = 0;
                            var $hbs = 0;
                            var $blm_hbs = 0;
                            var $prov = 0;
                            var $harga = 0;
                            for (let index = 0; index < json.data.length; index++) {
                                const $elm_lh_hbs = parseFloat(json.data[index].lh_habis);
                                const $elm_lh_blm_hbs = parseFloat(json.data[index].lh_blm_habis);
                                const $elm_kadar = parseFloat(json.data[index].kadar);
                                const $elm_hbs = parseFloat(json.data[index].habis);
                                const $elm_blm_hbs = parseFloat(json.data[index].blm_habis);
                                const $elm_prov = parseFloat(json.data[index].provitas);
                                const $elm_harga = parseFloat(json.data[index].harga.replace("Rp.", ""));
                                $lh_hbs += $elm_lh_hbs;
                                $lh_blm_hbs += $elm_lh_blm_hbs;
                                $kadar += $elm_kadar;
                                $hbs += $elm_hbs;
                                $blm_hbs += $elm_blm_hbs;
                                $prov += $elm_prov;
                                $harga += $elm_harga;
                            }
                            $kadar = parseFloat($kadar) / parseFloat(json.data.length)
                            $prov = parseFloat($prov) / parseFloat(json.data.length)
                            $harga = parseFloat($harga) / parseFloat(json.data.length)
                            var $avg_kadar = parseFloat($kadar);
                            var $avg_prov = parseFloat($prov);
                            var $avg_harga = parseFloat($harga);
                            $("th#lh_hbs").html($lh_hbs.toFixed(2) + " ha");
                            $("th#lh_blm_hbs").html($lh_blm_hbs.toFixed(2) + " ha");
                            $("th#kadar").html($avg_kadar.toFixed(2) + " %");
                            $("th#hbs").html($hbs.toFixed(2) + " ton");
                            $("th#blm_hbs").html($blm_hbs.toFixed(2) + " ton");
                            $("th#prov").html($avg_prov.toFixed(2) + " ton");
                            $("th#harga").html("Rp. " + $avg_harga.toFixed(2));
                        }

                    });
                    //Pilih Periode
                    $(document).off("click", "#btn-search")
                        .on("click", "#btn-search", function(e) {
                            // e.preventhefault();
                            const months = ["January", "February", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                                "September", "Oktober", "November", "Desember"
                            ];
                            var tanggal_awal = new Date($('#tanggal_awal').val()).getDate() + ' ' + months[new Date($(
                                    '#tanggal_awal').val()).getMonth()] + ' ' + new Date($('#tanggal_awal').val())
                                .getFullYear();
                            var tanggal_akhir = new Date($('#tanggal_akhir').val()).getDate() + ' ' + months[new Date($(
                                    '#tanggal_akhir').val()).getMonth()] + ' ' + new Date($('#tanggal_akhir').val())
                                .getFullYear();
                            var $_s_bln = new Date($('#tanggal_awal').val()).getMonth() + 1;
                            var $_s_tgl = new Date($('#tanggal_awal').val()).getDate();
                            $_s_bln = $_s_bln.length > 1 ? $_s_bln : "0" + $_s_bln;
                            $_s_tgl = $_s_tgl.length > 1 ? $_s_tgl : "0" + $_s_tgl;
                            var $_e_bln = new Date($('#tanggal_akhir').val()).getMonth() + 1;
                            var $_e_tgl = new Date($('#tanggal_akhir').val()).getDate();
                            $_e_bln = $_e_bln.length > 1 ? $_e_bln : "0" + $_e_bln;
                            $_e_tgl = $_e_tgl.length > 1 ? $_e_tgl : "0" + $_e_tgl;
                            var p_tanggal_awal = new Date($('#tanggal_awal').val()).getFullYear() + '-' + $_s_bln +
                                '-' + $_s_tgl;
                            var p_tanggal_akhir = new Date($('#tanggal_akhir').val()).getFullYear() + '-' + $_e_bln +
                                '-' + $_e_tgl;
                            var content_title = `Daftar Data Panen Horti ` + tanggal_awal + ` - ` + tanggal_akhir;
                            $("th#lh_hbs").html(null);
                            $("th#lh_blm_hbs").html(null);
                            $("th#kadar").html(null);
                            $("th#hbs").html(null);
                            $("th#blm_hbs").html(null);
                            $("th#prov").html(null);
                            $("th#harga").html(null);
                            table.ajax.url("{{ route('head.head_panen_horti.data') }}?tanggal_awal=" + p_tanggal_awal +
                                "&tanggal_akhir=" + p_tanggal_akhir).load();
                            table.ajax.reload((json) => {
                                var $lh_hbs = 0;
                                var $lh_blm_hbs = 0;
                                var $kadar = 0;
                                var $hbs = 0;
                                var $blm_hbs = 0;
                                var $prov = 0;
                                var $harga = 0;
                                for (let index = 0; index < json.data.length; index++) {
                                    const $elm_lh_hbs = parseFloat(json.data[index].lh_habis);
                                    const $elm_lh_blm_hbs = parseFloat(json.data[index].lh_blm_habis);
                                    const $elm_kadar = parseFloat(json.data[index].kadar);
                                    const $elm_hbs = parseFloat(json.data[index].habis);
                                    const $elm_blm_hbs = parseFloat(json.data[index].blm_habis);
                                    const $elm_prov = parseFloat(json.data[index].provitas);
                                    const $elm_harga = parseFloat(json.data[index].harga.replace("Rp.", ""));
                                    $lh_hbs += $elm_lh_hbs;
                                    $lh_blm_hbs += $elm_lh_blm_hbs;
                                    $kadar += $elm_kadar;
                                    $hbs += $elm_hbs;
                                    $blm_hbs += $elm_blm_hbs;
                                    $prov += $elm_prov;
                                    $harga += $elm_harga;
                                }
                                $kadar = parseFloat($kadar) / parseFloat(json.data.length)
                                $prov = parseFloat($prov) / parseFloat(json.data.length)
                                $harga = parseFloat($harga) / parseFloat(json.data.length)
                                var $avg_kadar = parseFloat($kadar);
                                var $avg_prov = parseFloat($prov);
                                var $avg_harga = parseFloat($harga);
                                $("th#lh_hbs").html($lh_hbs.toFixed(2) + " ha");
                                $("th#lh_blm_hbs").html($lh_blm_hbs.toFixed(2) + " ha");
                                $("th#kadar").html($avg_kadar.toFixed(2) + " %");
                                $("th#hbs").html($hbs.toFixed(2) + " ton");
                                $("th#blm_hbs").html($blm_hbs.toFixed(2) + " ton");
                                $("th#prov").html($avg_prov.toFixed(2) + " ton");
                                $("th#harga").html("Rp. " + $avg_harga.toFixed(2));
                            }, false);
                            $('#modal-content').modal("hide");
                            $('#form_awal').val($('#tanggal_awal').val());
                            $('#form_akhir').val($('#tanggal_akhir').val());
                            $('#content-title').html(content_title);
                        });
                });

                function updatePeriode() {
                    $('#modal-content').modal('show');
                }
                $('.export_pdf').click(function() {
                    // var url = "{{ route('head.panen.pdf_panen_horti') }}";
                    // $('#export-penjualan-form form').attr('action', url);

                    $('#form_pdf').submit();
                });
                $('.export_excel').click(function() {
                    $('#form_excel').submit();
                });
            </script>
        @endpush

@extends('app')

@section('title')
    Data Panen Perkebunan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Panen Perkebunan</li>
@endsection

@push('css')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <input type="hidden" name="is_kecamatan" value="{{ $is_kecamatan }}">
                    <button onclick="updatePeriode()" class="btn btn-info"><i class="fa fa-plus-circle"></i> Filter
                        Periode</button>
                    <br>
                    <br>
                    {{-- <button onclick="deleteSelected('{{ route('panen.delete_selected') }}')" class="btn btn-danger "> <i
                            class="fa fa-trash"> Hapus</i></button> --}}
                    <button onClick="addForm();" class="btn btn-success "> <i class="fa fa-plus"> Tambah</i></button>
                    {{-- <button onclick="#" class="btn btn-success "> <i class="fa fa-upload"> Import</i></button> --}}
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
                    <form id="form_excel" action="{{ route('panen.excel_perkebunan') }}" method="get" style="display: none;">
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

                                <th>No</th>
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
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5">Total :</th>
                                    <th id="luas"></th>
                                    <th colspan="3"></th>
                                    <th id="harga"></th>
                                    <th colspan="1"></th>
                                </tr>
                                <tr>
                                    <th colspan="6">Rata-Rata :</th>
                                    <th id="kadar"></th>
                                    <th id="prod"></th>
                                    <th id="prov"></th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>
            @includeIf('admin.panen.form_add')
            @includeIf('admin.panen.form')
        @endsection
        @push('scripts')
            <script src="{{asset('js/select2.min.js')}}"></script>
            <script>
                $(document).ready(function() {
                    $('.select2').select2();
                });
            </script>
            <script src="{{ asset('/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
            <script>
                let table;

                $(function() {
                    table = $('.table').DataTable({
                        processing: true,
                        autoWidth: false,
                        ajax: {
                            url: '{{ route('admin.admin_panen_perkebunan.data') }}',
                        },
                        columns: [

                            {
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

                        ],
                        "initComplete": function(settings, json) {
                            var $luas = 0;
                            var $kadar = 0;
                            var $prod = 0;
                            var $prov = 0;
                            var $harga = 0;
                            for (let index = 0; index < json.data.length; index++) {
                                const $elm_luas = parseInt(json.data[index].luas_lahan);
                                const $elm_kadar = parseFloat(json.data[index].kadar);
                                const $elm_prod = parseFloat(json.data[index].produksi);
                                const $elm_prov = parseFloat(json.data[index].provitas);
                                const $elm_harga = parseFloat(json.data[index].harga.replace("Rp.", ""));
                                $luas += $elm_luas;
                                $kadar += $elm_kadar;
                                $prod += $elm_prod;
                                $prov += $elm_prov;
                                $harga += $elm_harga;
                            }
                            $kadar = parseFloat($kadar) / parseFloat(json.data.length)
                            $prod = parseFloat($prod) / parseFloat(json.data.length)
                            $prov = parseFloat($prov) / parseFloat(json.data.length)
                            var $avg_kadar = parseFloat($kadar);
                            var $avg_prod = parseFloat($prod);
                            var $avg_prov = parseFloat($prov);
                            $("th#luas").html($luas+ " ha");
                            $("th#kadar").html($avg_kadar.toFixed(2) + " %");
                            $("th#prod").html($avg_prod.toFixed(2) + " ton");
                            $("th#prov").html($avg_prov.toFixed(2) + " ku/ha");
                            $("th#harga").html("Rp. " + $harga);
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
                            var content_title = `Daftar Data Panen Perkebunan ` + tanggal_awal + ` - ` + tanggal_akhir;
                            $("th#luas").html(null);
                            $("th#kadar").html(null);
                            $("th#prod").html(null);
                            $("th#prov").html(null);
                            $("th#harga").html(null);
                            table.ajax.url("{{ route('admin.admin_panen_perkebunan.data') }}?tanggal_awal=" + p_tanggal_awal +
                                "&tanggal_akhir=" + p_tanggal_akhir).load();
                            table.ajax.reload((json) => {
                                var $luas = 0;
                                var $kadar = 0;
                                var $prod = 0;
                                var $prov = 0;
                                var $harga = 0;
                                for (let index = 0; index < json.data.length; index++) {
                                    const $elm_luas = parseInt(json.data[index].luas_lahan);
                                    const $elm_kadar = parseFloat(json.data[index].kadar);
                                    const $elm_prod = parseFloat(json.data[index].produksi);
                                    const $elm_prov = parseFloat(json.data[index].provitas);
                                    const $elm_harga = parseFloat(json.data[index].harga.replace("Rp. ", ""));
                                    $luas += $elm_luas;
                                    $kadar += $elm_kadar;
                                    $prod += $elm_prod;
                                    $prov += $elm_prov;
                                    $harga += $elm_harga;
                                }
                                $kadar = parseFloat($kadar) / parseFloat(json.data.length)
                                $prod = parseFloat($prod) / parseFloat(json.data.length)
                                $prov = parseFloat($prov) / parseFloat(json.data.length)
                                var $avg_kadar = parseFloat($kadar);
                                var $avg_prod = parseFloat($prov);
                                var $avg_prov = parseFloat($prov);
                                $("th#luas").html($luas+ " ha");
                                $("th#kadar").html($avg_kadar.toFixed(2) + " %");
                                $("th#prod").html($avg_prod.toFixed(2) + " ton");
                                $("th#prov").html($avg_prov.toFixed(2) + " ku/ha");
                                $("th#harga").html("Rp. " + $harga);
                            }, false);
                            $('#modal-content').modal("hide");
                            $('#form_awal').val($('#tanggal_awal').val());
                            $('#form_akhir').val($('#tanggal_akhir').val());
                            $('#content-title').html(content_title);
                        });


                    $('#modal-form').validator().on('submit', function(e) {
                        if (!e.preventDefault()) {
                            $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize(), )
                                .done((response) => {
                                    $('#modal-form').modal('hide');
                                    table.ajax.reload();
                                })
                                .fail((errors) => {
                                    console.log(errors.responseJSON.message);
                                    alert('Tidak dapat menyimpan data');
                                    return false;
                                });
                        }
                    });

                    // $('[name=select_all]').on('click', function() {
                    //     $(':checkbox').prop('checked', this.checked);
                    // });
                });

                function addForm() {
                    var url = "{{ route('admin.panen.create_perkebunan') }}";
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Tambah Data Panen Perkebunan');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('post');
                    $('#modal-form [name=nama_kecamatan]').focus();
                    if ($("[name=\"is_kecamatan\"]").val() != "") {
                        $("select#id_kecamatan").val($("[name=\"is_kecamatan\"]").val()).trigger("change");
                        $("div#panel-kecamatan").attr("style", "display:none;");
                    } else {
                        $("select#id_kecamatan").val(null).trigger("change").attr("required", true);
                        $("div#panel-kecamatan").removeAttr("style");
                        console.log()
                    }
                }


                function updatePeriode() {
                    $('#modal-content').modal('show');
                }
                $('.export_pdf').click(function() {
                    // var url = "{{ route('panen.pdf_perkebunan') }}";
                    // $('#export-penjualan-form form').attr('action', url);

                    $('#form_pdf').submit();
                });
                $('.export_excel').click(function() {
                    $('#form_excel').submit();
                });

                $('#id_kecamatan').change(function() {
                    var id_kecamatan = $(this).val();
                    var html = "";
                    $.ajax({
                        method: "get",
                        url: "{{ route('getdesa') }}",
                        data: {
                            id_kecamatan: id_kecamatan
                        },
                        success: function(resp) {
                            $.each(resp, function(i, v) {
                                html += '<option value="' + v.id_desa + '">' + v.nama_desa +
                                '</option>';
                                $('#id_desa').html(html);
                            });
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                });
            </script>
        @endpush

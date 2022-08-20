@extends('app')

@section('title')
    Data Panen Horti
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Panen Horti</li>
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
                    <button onclick="updatePeriode()" class="btn btn-info"><i class="fa fa-plus-circle"></i> Filter
                        Periode</button>
                    <br>
                    <br>
                    {{-- <button onclick="deleteSelected('{{ route('panen.delete_selected') }}')" class="btn btn-danger "> <i
                            class="fa fa-trash"> Hapus</i></button> --}}
                    <button onclick="addForm();" class="btn btn-success "> <i class="fa fa-plus"> Tambah</i></button>
                    {{-- <button onclick="#" class="btn btn-success "> <i class="fa fa-upload"> Import</i></button> --}}
                    <form id="form_pdf" action="{{ route('panen.pdf_horti') }}" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" value="{{ $tanggalAwal }}">
                        <input type="hidden" name="form_akhir" id="form_akhir" value="{{ $tanggalAkhir }}">
                    </form>
                    <div class="btn-group">
                        <button target="_blank" class="btn btn-success export_pdf">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </button>
                        <button class="btn btn-primary export_excel"> <i class="fa fa-file-excel-o"> Excel</i></button>
                    </div>
                    <form id="form_excel" action="{{ route('panen.excel_horti') }}" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" value="{{ $tanggalAwal }}">
                        <input type="hidden" name="form_akhir" id="form_akhir" value="{{ $tanggalAkhir }}">
                    </form>
                </div>
                <div class="box-body table-responsive">

                    <form action="" method="post" class="form-panen-horti">
                        @csrf
                        <table class="table table-stiped table-bordered">
                            <thead>
                                <!-- <th width="5%">
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th> -->
                                <!-- <th>No</th> -->
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
                                <th width="8%"><i class="fa fa-cog"></i> Aksi</th>
                            </thead>
                            <tbody>
                            
                           </tbody>
                            <tfoot>
                                <tr>
                                    <th style="text-align: center" colspan="5"><b> Total Luas: </b></th>
                                </tr>
                                <tr>
                                    <th style="text-align: center" colspan="6"><b> Rata - rata:</b></th>
                                    <th><b>81</b></th>
                                    <th><b>20</b></th>
                                    <th><b>39</b></th>
                                    <th colspan="3"><b>Rp. 10.000,00</b></th>
                                </tr>
                            </tfoot>
                        </table>
                    </form>
                </div>
            </div>

            @includeIf('panen.form_horti')
            @includeIf('panen.form')
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
                        "processing": true,
                        "serverSide": true,
                        "autoWidth": false,
                        "ajax":{
                            "url": "http://localhost:8001/api/data/panen/2",
                            "type": "GET",
                            "dataSrc":function(d) {
                                return d.datas
                            }
                        },
                        "columns":[
                            {
                                "data":"updated_at"
                            },
                            {
                                "data":"nama_kecamatan"
                            },
                            {
                                "data":"nama_desa"
                            },
                            {
                                "data":"nama_tanaman"
                            },
                            {
                                "data":"luas_lahan"
                            },
                            {
                                "data":"kadar"
                            },
                            {
                                "data":"produksi"
                            },
                            {
                                "data":"provitas"
                            },
                            {
                                "data":"harga"
                            },
                            {
                                "data":"nama"
                            },
                            {
                                "data":"id_produktivitas",
                                "render":function ( data, type, row, meta ) {
                                    return type == 'display' ? 
                                    '<div class="btn-group">'+
                                    '<button type="button" onclick=editForm('+data+') class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></button>'+
                                    '<button type="button" onclick=deleteData('+data+') class="btn btn-sm btn-info"><i class="fa fa-trash"></i></button>'+
                                    '</div>'
                                    : data
                                }
                            },
                        ],
                        "footerCallback": function ( row, data, start, end, display ) {
                            var api = this.api()
                            $(api.column(4).footer()).html(
                              'Total Luas : '+data[0].total_luas_lahan +'ha'
                            );
                        }
                    })
                    // table = $('.table').DataTable({
                    //     processing: true,
                    //     serverSide: true,
                    //     autoWidth: false,
                    //     ajax: {
                    //         url: "http://localhost:8000/api/data/panen/1",
                    //         type:"GET",
                    //         "dataSrc":function(json) {
                    //             console.log(json)
                    //         },
                    //     },
                    //     columns:
                    //         [
                    //             {
                    //                 data: 'aksi',
                    //                 searchable: false,
                    //                 sortable: false
                    //             }
                    //         ]

                    // });

                    //Pilih Periode
                    $('#btn-search').on('click', function(e) {
                        const months = ["January", "February", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                            "September", "Oktober", "November", "Desember"
                        ];
                        var tanggal_awal = new Date($('#tanggal_awal').val()).gethate() + ' ' + months[new Date($(
                                '#tanggal_awal').val()).getMonth()] + ' ' + new Date($('#tanggal_awal').val())
                            .getFullYear();
                        var tanggal_akhir = new Date($('#tanggal_akhir').val()).gethate() + ' ' + months[new Date($(
                                '#tanggal_akhir').val()).getMonth()] + ' ' + new Date($('#tanggal_akhir').val())
                            .getFullYear();
                        var content_title = `Daftar Data Panen Horti` + tanggal_awal + ` - ` + tanggal_akhir;
                        table.draw();
                        e.preventhefault();
                        $('#modal-content').modal("hide");
                        $('#form_awal').val($('#tanggal_awal').val());
                        $('#form_akhir').val($('#tanggal_akhir').val());
                        $('#content-title').html(content_title);
                    });

                    $('#modal-form').validator().on('submit', function(e) {
                        if (!e.preventhefault()) {
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

                    $('[name=select_all]').on('click', function() {
                        $(':checkbox').prop('checked', this.checked);
                    });
                });

                function addForm() {
                    var url = "{{ route('panen.create_horti') }}";
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Tambah Data Panen Horti');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('post');
                    $('#modal-form [name=nama_kecamatan]').focus();
                }

                function editForm(id_produktivitas) {
                    var url = "{{ url('panen/panen_horti/update/') }}" + "/" + id_produktivitas;
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Data Panen Horti');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('put');

                    $.ajax({
                        method: "get",
                        url: "{{ route('panen.edit_horti') }}",
                        data: {
                            id_produktivitas: id_produktivitas
                        },
                        success: function(resp) {
                            $('#id_kecamatan').val(resp.kecamatan_id);
                            $('#id_kecamatan').attr('disabled', 'disabled');
                            // $('#id_kecamatan').select2().trigger('change');
                            $('#id_desa').val(resp.desa_id);
                            $('#id_desa').attr('disabled', 'disabled');
                            // $('#id_desa').select2().trigger('change');
                            $('#id_tanaman').val(resp.tanaman_id);
                            $('#id_tanaman').select2().trigger('change');
                            $('#modal-form [name=luas_lahan]').val(resp.luas_lahan);
                            $('#modal-form [name=kadar]').val(resp.kadar);
                            $('#modal-form [name=produksi]').val(resp.produksi);
                            $('#modal-form [name=provitas]').val(resp.provitas);
                            $('#modal-form [name=harga]').val(resp.harga);
                        },
                        error: function(err) {
                            alert('Tidak dapat menampilkan data');
                            return;
                        }
                    });
                }

                function deleteData(id) {
                    if (confirm('Yakin ingin menghapus data terpilih?')) {
                        var url = "{{URL::to('/panen/panen_horti/delete/')}}"+ "/" + id
                        $.post(url, {
                                '_token': $('[name=csrf-token]').attr('content'),
                                '_method': 'delete'
                            })
                            .done((response) => {
                                console.log(response);
                                table.ajax.reload();
                            })
                            .fail((errors) => {
                                console.log(errors);
                                alert('Tidak dapat menghapus data');
                                return;
                            });
                    }
                }

                function deleteSelected(url) {
                    if ($('input:checked').length > 1) {
                        if (confirm('Yakin ingin menghapus data terpilih?')) {
                            $.post(url, $('.form-panen-horti').serialize())
                                .done((response) => {
                                    table.ajax.reload();
                                })
                                .fail((errors) => {
                                    alert('Tidak dapat menghapus data');
                                    return;
                                });
                        }
                    } else {
                        alert('Pilih data yang akan dihapus');
                        return;
                    }
                }

                function updatePeriode() {
                    $('#modal-content').modal('show');
                }
                $('.export_pdf').click(function() {
                    // var url = "{{ route('panen.pdf_horti') }}";
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
                        url: "{{ route('gethesa') }}",
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

@extends('app')

@section('title')
Data Tanam Pajale
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Tanam Pajale</li>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                    {{-- <button class="btn btn-info"><i class="fa fa-plus-circle"></i> Filter Periode</button>
                    <br>
                    <br> --}}
                    {{-- <button onclick="#" class="btn btn-danger "> <i class="fa fa-trash"> Hapus</i></button> --}}
                    <button onclick="addForm();" class="btn btn-success "> <i class="fa fa-plus"> Tambah</i></button>
                    {{-- <button onclick="#" class="btn btn-success "> <i class="fa fa-upload"> Import</i></button> --}}
                    <form id="form_pdf" action="{{ route('tanam.pdf_pajale') }}" method="get" style="display: none;">
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
                    <form id="form_excel" action="{{ route('tanam.excel_pajale') }}" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" value="{{-- $tanggalAwal --}}">
                        <input type="hidden" name="form_akhir" id="form_akhir" value="{{-- $tanggalAkhir --}}">
                    </form>
                </div>
                <div class="box-body table-responsive">
                    <form action="" method="post" class="form-tanam-pajale">
                        @csrf
                        <table class="table table-stiped table-bordered">
                            <thead>
                                {{-- <th>
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th> --}}
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kecamatan</th>
                                <th>Desa</th>
                                <th>Tanaman </th>
                                <th>Luas Tanam</th>
                                <th>Nama Penginput</th>
                                <th><i class="fa fa-cog"></i> Aksi</th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>

            @includeIf('tanam.form_pajale')
        @endsection

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                            url: '{{ route('tanam_pajale.data') }}',
                        },
                        columns: [
                            // {
                            //     data: 'select_all',
                            //     searchable: false,
                            //     sortable: false
                            // },
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
                                data: 'created_by'
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
                        var content_title = `Daftar Data Tanam Pajale` + tanggal_awal + ` - ` + tanggal_akhir;
                        table.draw();
                        e.preventDefault();
                        $('#modal-form').modal("hide");
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

                    $('[name=select_all]').on('click', function() {
                        $(':checkbox').prop('checked', this.checked);
                    });
                });

                function addForm() {
                    var url = "{{ route('tanam.create_pajale') }}";
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Tambah Data Tanam Pajale');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('post');
                    $('#modal-form [name=nama_kecamatan]').focus();
                }

                function editForm(id_produktivitas) {
                    var url = "{{ url('tanam/tanam_pajale/update/') }}"+ "/" +id_produktivitas;
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Data Tanam Pajale');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('put');

                    $.ajax({
                        method: "get",
                        url: "{{ route('tanam.edit_pajale') }}",
                        data: {
                            id_produktivitas: id_produktivitas
                        },
                        success: function(resp) {
                            $('#id_kecamatan').val(resp.kecamatan_id);
                            $('#id_kecamatan').select2().trigger('change');
                            $('#id_desa').val(resp.desa_id);
                            $('#id_desa').select2().trigger('change');
                            $('#id_tanaman').val(resp.tanaman_id);
                            $('#id_tanaman').select2().trigger('change');
                            $('#modal-form [name=luas_lahan]').val(resp.luas_lahan);
                        },
                        error: function(err) {
                            alert('Tidak dapat menampilkan data');
                            return;
                        }
                    });
                }

                function deleteData(url) {
                    if (confirm('Yakin ingin menghapus data terpilih?')) {
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
                            $.post(url, $('.form-tanam-pajale').serialize())
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
                $('.export_pdf').click(function() {
                    // var url = "{{ route('tanam.pdf_pajale') }}";
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
                                html += '<option value="' + v.id_desa + '">' + v.nama_desa + '</option>';
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

@extends('app')

@section('title')
    Panen Pajale
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Panen Pajale</li>
@endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <button class="btn btn-info"><i class="fa fa-plus-circle"></i> Filter Periode</button>
                    <br>
                    <br>
                    <button onclick="#" class="btn btn-danger "> <i class="fa fa-trash"> Hapus</i></button>
                    <button onclick="addForm();" class="btn btn-success "> <i class="fa fa-plus"> Tambah</i></button>
                    <button onclick="#" class="btn btn-success "> <i class="fa fa-upload"> Import</i></button>
                    <form id="form_pdf" action="{{ route('panen.pdf_pajale') }}" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" value="{{-- $tanggalAwal --}}">
                        <input type="hidden" name="form_akhir" id="form_akhir" value="{{-- $tanggalAkhir --}}">
                    </form>
                    <button target="_blank" class="btn btn-success export_pdf">
                        <i class="fa fa-file-excel-o"></i> PDF
                    </button>
                    <form id="form_excel" action="{{ route('panen.excel_pajale') }}" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" value="{{-- $tanggalAwal --}}">
                        <input type="hidden" name="form_akhir" id="form_akhir" value="{{-- $tanggalAkhir --}}">
                    </form>
                    <button class="btn btn-primary export_excel"> <i class="fa fa-file-excel-o"> Excel</i></button>
                </div>
                <div class="box-body table-responsive">
                    <form action="" method="post" class="form-panen-pajale">
                        @csrf
                        <table class="table table-stiped table-bordered">
                            <thead>
                                <th>
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th>
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
                                <th><i class="fa fa-cog"></i> Aksi</th>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>

            @includeIf('panen.form_pajale')
        @endsection

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.select2').select2();
                });
            </script>
            <script src="{{ asset('/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
            </script>
            <script>
                let table;

                $(function() {
                    table = $('.table').DataTable({
                        processing: true,
                        autoWidth: false,
                        ajax: {
                            url: '{{ route('pajale.data') }}',
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
                                data: 'produksi'
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
                        var content_title = `Daftar Data Panen Horti` + tanggal_awal + ` - ` + tanggal_akhir;
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
                    var url = "{{ route('panen.create_pajale') }}";
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Tambah Data Panen Horti');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('post');
                    $('#modal-form [name=nama_kecamatan]').focus();
                }

                function editForm(id_produktivitas) {
                    var url = "{{ url('panen/pajale/update/') }}"+ "/" +id_produktivitas;
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Data Panen Pajale');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('put');

                    $.ajax({
                        method: "get",
                        url: "{{ route('panen.edit_pajale') }}",
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
                            $.post(url, $('.form-panen-pajale').serialize())
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
                    // var url = "{{ route('panen.pdf_pajale') }}";
                    // $('#export-penjualan-form form').attr('action', url);

                    $('#form_pdf').submit();
                });
                $('.export_excel').click(function() {
                    $('#form_excel').submit();
                });
            </script>
        @endpush

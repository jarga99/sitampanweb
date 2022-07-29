@extends('app')

@section('title')
    Panen Horti
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Horti</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <button onclick="addForm('{{ route('panen.horti_store') }}')" class="btn btn-info"><i class="fa fa-plus-circle"></i> Filter Periode</button>
                    <br>
                    <br>
                    <button onclick="#" class="btn btn-danger "> <i class="fa fa-trash"> Hapus</i></button>
                    <button onclick="#" class="btn btn-success "> <i class="fa fa-plus"> Tambah</i></button>
                    <button onclick="#" class="btn btn-success "> <i class="fa fa-upload"> Import</i></button>
                    <a href="#" target="_blank" class="btn btn-success "
                        onclick="event.preventDefault();document.getElementById('export-penjualan-form').submit();">
                        <i class="fa fa-file-excel-o"></i> Export PDF
                    </a>
                    <form id="export-penjualan-form" action="#" method="get" style="display: none;">
                        @csrf
                        <input type="hidden" name="form_awal" id="form_awal" value="{{-- $tanggalAwal --}}">
                        <input type="hidden" name="form_akhir" id="form_akhir" value="{{-- $tanggalAkhir --}}">
                    </form>
                    <button onclick="#" class="btn btn-primary "> <i class="fa fa-file-excel-o"> Excel</i></button>
                </div>
                <div class="box-body table-responsive">
                    <form action="" method="post" class="form-panen-horti">
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

                function addForm(url) {
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Tambah Data Panen Horti');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('post');
                    $('#modal-form [name=nama_kecamatan]').focus();
                }

                function editForm(url) {
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Produk');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url);
                    $('#modal-form [name=_method]').val('put');

                    $.get(url)
                        .done((response) => {

                            // new
                            $('#modal-form [name=nama_kecamatan]').val(response.mst_kecamtan.nama_kecamatan);
                            $('#modal-form [name=nama_desa]').val(response.mst_desa.nama_desa);
                            $('#modal-form [name=nama_tanaman').val(response.mst_tanaman.nama_tanaman);
                            $('#modal-form [name=luas_lahan]').val(response.tb_produktivitas.luas_lahan);
                            $('#modal-form [name=kadar]').val(response.tb_produktivitas.kadar);
                            $('#modal-form [name=produksi]').val(response.tb_produktivitas.produksi);
                            $('#modal-form [name=provitas]').val(response.tb_produktivitas.provitas);
                            $('#modal-form [name=harga]').val(response.tb_produktivitas.harga);
                        })
                        .fail((errors) => {
                            alert('Tidak dapat menampilkan data');
                            return;
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
            </script>
        @endpush

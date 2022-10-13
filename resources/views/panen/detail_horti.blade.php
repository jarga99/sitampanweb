@push('css')
    <style>
        .modal-ku {
            width: 90%;
            margin: auto;
        }
    </style>
@endpush
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail">
    <div class="modal-dialog modal-ku" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Data Horti</h4>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-detail">
                    <thead>
                        <tr class="warning">
                            <th rowspan="2">No</th>
                            <th rowspan="2">Tanggal Buat</th>
                            <th rowspan="2">Tanggal Edit</th>
                            <th rowspan="2">Kecamatan</th>
                            <th rowspan="2">Desa</th>
                            <th rowspan="2">Tanaman </th>
                            <th colspan="2" style="text-align: center;">Luas Panen</th>
                            <th rowspan="2">Kadar</th>
                            <th colspan="2" style="text-align: center;">Produksi</th>
                            <th rowspan="2">Provitas</th>
                            <th rowspan="2">Harga</th>
                            <th rowspan="2">Penginput</th>
                            <th rowspan="2">Pengedit</th>
                        <tr class="warning">
                            <th>Hbs</th>
                            <th>Blm Hbs</th>
                            <th>Hbs</th>
                            <th>Blm Hbs</th>
                        </tr>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    let table1;

    $(function() {
        table1 = $('.table-detail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false,
                },
                {
                    data: 'created_at'
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
                {
                    data: 'updated_by'
                },
            ]
        })
    })

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
    }
</script>

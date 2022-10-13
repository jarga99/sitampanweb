<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group row" id="panel-kecamatan">
                        <label for="id_kecamatan" class="col-lg-2 col-lg-offset-1 control-label">Kecamatan</label>
                        <div class="col-lg-6">
                            <select name="id_kecamatan" id="id_kecamatan" class="form-control select2" required>
                                <option value="">Pilih Kecamatan</option>
                                @foreach ($kecamatans as $kecamatan)
                                    <option value="{{ $kecamatan->id_kecamatan }}">{{ $kecamatan->nama_kecamatan }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_desa" class="col-lg-2 col-lg-offset-1 control-label">Desa</label>
                        <div class="col-lg-6">
                            <select name="id_desa" id="id_desa" class="form-control select2" required>
                                <option value="">Pilih Desa</option>
                                @foreach ($desas as $desa)
                                    <option value="{{ $desa->id_desa }}">{{ $desa->nama_desa }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_tanaman" class="col-lg-2 col-lg-offset-1 control-label">Tanaman</label>
                        <div class="col-lg-6">
                            <select name="id_tanaman" id="id_tanaman" class="form-control select2" required>
                                <option value="">Pilih Tanaman</option>
                                @foreach ($tanamans as $tanaman)
                                    <option value="{{ $tanaman->id_tanaman }}">{{ $tanaman->nama_tanaman }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lh_habis" class="col-lg-2 col-lg-offset-1 control-label">Luas Panen Habis (ha)</label>
                        <div class="col-lg-6">
                            <input type="number" step="0.01" name="lh_habis" id="lh_habis" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lh_blm_habis" class="col-lg-2 col-lg-offset-1 control-label">Luas Panen Belum Habis (ha)</label>
                        <div class="col-lg-6">
                            <input type="number" step="0.01" name="lh_blm_habis" id="lh_blm_habis" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kadar" class="col-lg-2 col-lg-offset-1 control-label">Kadar</label>
                        <div class="col-lg-6">
                            <input type="number" step="0.01" name="kadar" id="kadar" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="habis" class="col-lg-2 col-lg-offset-1 control-label">Produksi Habis (ton)</label>
                        <div class="col-lg-6">
                            <input type="number" step="0.01" name="habis" id="habis" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="blm_habis" class="col-lg-2 col-lg-offset-1 control-label">Produksi Belum Habis (ton)</label>
                        <div class="col-lg-6">
                            <input type="number" step="0.01" name="blm_habis" id="blm_habis" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="provitas" class="col-lg-2 col-lg-offset-1 control-label">Provitas (ku/ha)</label>
                        <div class="col-lg-6">
                            <input type="number" step="0.01" name="provitas" id="provitas" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga" class="col-lg-2 col-lg-offset-1 control-label">Harga</label>
                        <div class="col-lg-6">
                            <input type="number" name="harga" id="harga" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                            class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

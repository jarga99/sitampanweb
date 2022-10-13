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
                    <div class="form-group row">
                        <label for="tanggal" class="col-lg-2 col-lg-offset-1 control-label">Tanggal</label>
                        <div class="col-lg-6">
                            <input type="date" name="tanggal" id="tanggal" class="form-control datepicker" value="{{old('tanggal')}}" required>
                        <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
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
                        <label for="luas_lahan" class="col-lg-2 col-lg-offset-1 control-label">Luas Panen (ha)</label>
                        <div class="col-lg-6">
                            <p class="text-danger"><b>Harap baca!!!</b> <br> khusus tanaman <u><i>Padi Sawah, Jagung Sawah, Kedelai Sawah</i></u> <br> luas panen perlu dikonversi dengan cara nilai luas panen * 0,9683</p>
                            <input type="number" step="0.01" name="luas_lahan" id="luas_lahan" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kadar" class="col-lg-2 col-lg-offset-1 control-label">Kadar (%)</label>
                        <div class="col-lg-6">
                            <input type="number" step="0.01" name="kadar" id="kadar" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="produksi" class="col-lg-2 col-lg-offset-1 control-label">Produksi (ton)</label>
                        <div class="col-lg-6">
                            <p class="text-danger"><b>Harap baca!!!</b> <br> khusus tanaman <u><i>Padi Sawah, Jagung Sawah, Kedelai Sawah</i></u><br> nilai produksi perlu di hitung dengan rumus yaitu : <br> Produksi = LP * Provitas (LP = luas panen yang sudah dikonversi) <br> produksi = hasil/10 <br> produksi = nilai produksi yang akan diinputkan </p>
                            <input type="number" step="0.01" name="produksi" id="produksi" class="form-control" required>
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

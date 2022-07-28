@extends('app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <form action="#" method="post" class="form-profil" data-toggle="validator" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="alert alert-info alert-dismissible" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fa fa-check"></i> Perubahan berhasil disimpan
                    </div>
                    <div class="form-group row">
                        <label for="nama" class="col-lg-2 control-label">Nama</label>
                        <div class="col-lg-6">
                            <input type="text" name="nama" class="form-control" id="nama" required autofocus value="{{ old('nama') }}">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="foto" class="col-lg-2 control-label">Foto</label>
                        <div class="col-lg-4">
                            <input type="file" name="foto" class="form-control" id="foto"
                                onchange="preview('.tampil-foto', this.files[0])">
                            <span class="help-block with-errors"></span>
                            <br>
                            <div class="tampil-foto">
                                <img src="#" width="200">preview('.tampil-foto', this.files[0])
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_lama" class="col-lg-2 control-label">Password Lama</label>
                        <div class="col-lg-6">
                            <input type="password" name="password_lama" id="password_lama" class="form-control"
                            minlength="6">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_baru" class="col-lg-2 control-label">Password Baru</label>
                        <div class="col-lg-6">
                            <input type="password" name="password_baru" id="password_baru" class="form-control"
                            minlength="6">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="konfirmasi_password" class="col-lg-2 control-label">Konfirmasi Password</label>
                        <div class="col-lg-6">
                            <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control"
                                data-match="#password">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

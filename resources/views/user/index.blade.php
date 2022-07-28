@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="#" class="btn btn-success "><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered">
                    <thead >
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th><i class="fa fa-cog"></i>Aksi</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('app')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 >{{$count_tanam_pajale}}</h3>

                    <p >Total Data Tanam Pajale</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tree "></i>
                </div>
                <a href="{{route('tanam.index_pajale')}}" class="small-box-footer"> Detail <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- Small boxes (Stat box) -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$count_tanam_horti}}</h3>

                    <p>Total Data Tanam Horti</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tree "></i>
                </div>
                <a href="{{route('tanam.index_horti')}}" class="small-box-footer">  Detail  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{$count_tanam_perkebunan}}</h3>

                    <p>Total Data Tanam Perkebunan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tree "></i>
                </div>
                <a href="{{route('tanam.index_perkebunan')}}" class="small-box-footer">  Detail  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{$count_panen_pajale}}</h3>

                    <p>Total Data Panen Pajale</p>
                </div>
                <div class="icon">
                    <i class="fa fa-download "></i>
                </div>
                <a href="{{route('panen.index_pajale')}}" class="small-box-footer">  Detail  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- Small boxes (Stat box) -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{$count_panen_horti}}</h3>

                    <p>Total Data Panen Horti</p>
                </div>
                <div class="icon">
                    <i class="fa fa-download "></i>
                </div>
                <a href="{{route('panen.index_horti')}}" class="small-box-footer">  Detail  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-orange">
                <div class="inner">
                    <h3>{{$count_panen_perkebunan}}</h3>

                    <p>Total Data Panen Perkebunan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-download "></i>
                </div>
                <a href="{{route('panen.index_perkebunan')}}" class="small-box-footer">  Detail  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$count_puso_pajale}}</h3>

                    <p>Total Data Puso Pajale</p>
                </div>
                <div class="icon">
                    <i class="fa fa-times-circle-o "></i>
                </div>
                <a href="{{route('puso.index_pajale')}}" class="small-box-footer">  Detail  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <!-- Small boxes (Stat box) -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$count_puso_horti}}</h3>

                    <p>Total Data Puso Horti</p>
                </div>
                <div class="icon">
                    <i class="fa fa-times-circle-o "></i>
                </div>
                <a href="{{route('puso.index_horti')}}" class="small-box-footer">  Detail  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{$count_puso_perkebunan}}</h3>

                    <p>Total Data Puso Perkebunan</p>
                </div>
                <div class="icon">
                    <i class="fa fa-times-circle-o  "></i>
                </div>
                <a href="{{route('puso.index_perkebunan')}}" class="small-box-footer">  Detail  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    @endsection

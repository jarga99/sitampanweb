<!-- master dari dashboard -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SITAMPAN</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="{{ asset('/img/sitampan.jpg') }}" type="image/png">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @stack('css')
</head>

<body class="container-fluid">
    <div class="wrapper">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header text-center">
                <h1 class="text-success"><b>SISTEM INFORMASI TANAM PANEN</b></h1>
                <h3 style="margin-top: -3px">DINAS KETAHANAN PANGAN DAN PERTANIAN</h3>
                <h3 style="margin-top: -10px">KABUPATEN BOJONEGORO</h3>
            </section>
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#tugel-nav" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{url('/')}}"><span>SITAMPAN</span></a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="tugel-nav">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">TANAM<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('user.tanam.index_pajale') }}"> Tanam Pajale</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ route('user.tanam.index_horti') }}">Tanam Horti</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ route('user.tanam.index_perkebunan') }}">Tanam Perkebunan</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false">PANEN <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ route('user.panen.index_pajale') }}">Panen Pajale</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ route('user.panen.index_horti') }}">Panen Horti</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{ route('user.panen.index_perkebunan') }}">Panen Perkebunan</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="{{route('login')}}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                          </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>

            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 id="content-title">
                        @yield('title')
                    </h1>
                </section>
                <section class="content">
                    {{-- content --}}
                    @yield('content')
                </section>
            </div>

        </div>
    </div>
    <!-- jQuery 3 -->
    <script src="{{ asset('js/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- Validator -->
    <script src="{{ asset('js/validator.min.js') }}"></script>


    @stack('scripts')
</body>

</html>

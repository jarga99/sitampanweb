<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            {{-- hader navigasi --}}
            <li class="active">
                <a href="#">
                    <i class="fa fa-arrows-alt text-teal"></i> <span>MASTER DATA</span>
                </a>
            </li>
            {{-- end navigasi --}}
            @if (auth()->user()->level == 1)
            <li>
                <a href="{{route('counter')}}">
                    <i class="fa fa-dashboard text-light"></i> <span>Dashboard</span>
                </a>
            </li>

            {{-- Tanam --}}
            <li class=" treeview">
                <a href="#">
                    <i class="fa fa-tree text-success"></i> <span>Tanam</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu " style="display: none">
                    <li><a href="{{route('tanam.index_pajale')}}"><i class="fa fa-th-list"></i>Tanam Pajale</a></li>
                    <li><a href="{{route('tanam.index_horti')}}"><i class="fa fa-th-list"></i>Tanam Horti</a></li>
                    <li><a href="{{route('tanam.index_perkebunan')}}"><i class="fa fa-th-list"></i>Tanam Perkebunan</a></li>
                </ul>
            </li>

            {{-- Panen --}}
            <li class=" treeview">
                <a href="#">
                    <i class="fa fa-download text-warning"></i> <span>Panen</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu " style="display: none">
                    <li><a href="{{route('panen.index_pajale')}}"><i class="fa fa-th-list"></i>Panen Pajale</a></li>
                    <li><a href="{{route('panen.index_horti')}}"><i class="fa fa-th-list"></i>Panen Horti</a></li>
                    <li><a href="{{route('panen.index_perkebunan')}}"><i class="fa fa-th-list"></i>Panen Perkebunan</a></li>
                </ul>
            </li>

            {{-- User & setting --}}
            <li class="active">
                <a href="#">
                    <i class="fa fa-users text-primary"></i> <span>User</span>
                </a>
            </li>
            <li><a href="{{route('user.index')}}"><i class="fa fa-user-plus text-aqua"></i> <span>Manajemen User</span></a></li>
            @elseif (auth()->user()->level == 2)
            <li>
                <a href="{{route('counter')}}">
                    <i class="fa fa-dashboard text-light"></i> <span>Dashboard</span>
                </a>
            </li>

            {{-- Tanam --}}
            <li class=" treeview">
                <a href="#">
                    <i class="fa fa-tree text-success"></i> <span>Tanam</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu " style="display: none">
                    <li><a href="{{route('tanam.index_pajale')}}"><i class="fa fa-th-list"></i>Tanam Pajale</a></li>
                    <li><a href="{{route('tanam.index_horti')}}"><i class="fa fa-th-list"></i>Tanam Horti</a></li>
                    <li><a href="{{route('tanam.index_perkebunan')}}"><i class="fa fa-th-list"></i>Tanam Perkebunan</a></li>
                </ul>
            </li>

            {{-- Panen --}}
            <li class=" treeview">
                <a href="#">
                    <i class="fa fa-download text-warning"></i> <span>Panen</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu " style="display: none">
                    <li><a href="{{route('panen.index_pajale')}}"><i class="fa fa-th-list"></i>Panen Pajale</a></li>
                    <li><a href="{{route('panen.index_horti')}}"><i class="fa fa-th-list"></i>Panen Horti</a></li>
                    <li><a href="{{route('panen.index_perkebunan')}}"><i class="fa fa-th-list"></i>Panen Perkebunan</a></li>
                </ul>
            </li>
            @endif
        </ul>


        {{-- end Panen --}}
    </section>
    <!-- /.sidebar -->
</aside>

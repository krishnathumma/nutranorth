@extends('template.main')
@section('title', 'Dashboard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('title')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">@yield('title')</a></li>

                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $user }}</h3>
                                <p>User</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fa-solid fa-user"></i>
                            </div>
                            <a href="/user" class="small-box-footer">More info 
                                <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $emp }}</h3>
                                <p>Employee</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fa-solid fa-user-nurse"></i>
                            </div>
                            <a href="/employee" class="small-box-footer">More info 
                                <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $task }}</h3>
                                <p>Tasks</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fa-solid fa-tasks"></i>
                            </div>
                            <a href="/task" class="small-box-footer">More info 
                                <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $npn }}</h3>
                                <p>Npns</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fa-solid fa-money-bill"></i>
                            </div>
                            <a href="/npn" class="small-box-footer">More info 
                                <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $supplier }}</h3>
                                <p>Suppliers</p>
                            </div>
                            <div class="icon">
                                <i class="nav-icon fa-solid fa-truck-field"></i>
                            </div>
                            <a href="/supplier" class="small-box-footer">More info 
                                <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    
                   
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

@endsection

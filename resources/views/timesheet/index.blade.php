@extends('template.main')
@section('title', 'Timesheet')
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
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">@yield('title')</li>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="text-right">
                                    <a href="/timesheet/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add
                                    Timesheet</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-striped table-bordered table-hover text-center"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Agency</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Date</th>
                                            <th>Time In</th>
                                            <th>Time Out</th>
                                            <th>Lunch Break</th>
                                            <th>Paid Break</th>
                                            <th>Total Hours</th>
                                            @if($role->role == "Administor")
                                            <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($timesheet as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucfirst($data->name) }}</td>
                                                <td>{{ ucfirst($data->agency) }}</td>
                                                <td>{{ ($data->email) }}</td>
                                                <td>{{ $data->mobile }}</td>
                                                <td>{{ ($data->date) }}</td>
                                                <td>{{ $data->time_in }}</td>
                                                <td>{{ $data->time_out }}</td>
                                                <td>{{ $data->lunch_break }}</td>
                                                <td>{{ $data->paid_hours }}</td>
                                                <td>{{ $data->total_hours }}</td>
                                                @if($role->role == "Administor")
                                                <td>
                                                    <form class="d-inline" action="/timesheet/{{ $data->id }}/edit"
                                                        method="GET">
                                                        <button type="submit" class="btn btn-success btn-sm mr-1">
                                                            <i class="fa-solid fa-pen"></i> Edit
                                                        </button>
                                                    </form>
                                                    <!-- <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#createModal">
                                                            <i class="fa-solid fa-eye"></i> View
                                                        </button> -->

                                                    <form class="d-inline" action="/timesheet/{{ $data->id }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            id="btn-delete"><i class="fa-solid fa-trash-can"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                                @endif
                                                <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModal" >
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Task Description</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $data->product}}</p>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Task Upload files Donload : </p>
                                                                <a href="{{ URL::to( '/task/download/' . $data->filename)  }}" >File Download</a>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        </div>
    </div>

@endsection




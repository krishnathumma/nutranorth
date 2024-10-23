@extends('template.main')
@section('title', 'Suppliers')
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
                                    <a href="/supplier/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add
                                    supplier</a>
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
                                            <th>Place</th>
                                            <th>Email</th>
                                            <th>Currency</th>
                                            <th>Mobile</th>
                                            <th>Price</th>
                                            @if($role->role == "Administor")
                                            <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach ($suppliers as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucfirst($data->name) }}</td>
                                                <td>{{ ucfirst($data->place) }}</td>
                                                <td>{{ $data->email }}</td>
                                                <td>{{ strtoupper($data->currency) }}</td>
                                                <td>{{ $data->mobile }}</td>
                                                <td>{{ $data->price }}</td>
                                                @if($role->role == "Administor")
                                                <td>
                                                    <form class="d-inline" action="/supplier/{{ $data->id }}/edit"
                                                        method="GET">
                                                        <button type="submit" class="btn btn-success btn-sm mr-1">
                                                            <i class="fa-solid fa-pen"></i> Edit
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#createModal_{{ $data->id }}">
                                                        <i class="fa-solid fa-eye"></i> View
                                                    </button>

                                                    <form class="d-inline" action="/supplier/{{ $data->id }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            id="btn-delete"><i class="fa-solid fa-trash-can"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                                @endif
                                                <div class="modal fade" id="createModal_{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="createModal" >
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Supplier - <?php echo ucfirst($data->name); ?></h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>{{ $data->product}}</p>
                                                            </div>
                                                            <?php if($data->files_id) {?>
                                                            <div class="modal-body">
                                                                <a href="{{ URL::to( '/download/' . $data->files_id)  }}" >File Download</a>
                                                            </div>
                                                            <?php } ?>
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




@extends('template.main')
@section('title', 'File Upload')
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
        <div class="col-md-12">
          <div class="card">
            <form class="needs-validation" novalidate action="{{ route('file.upload') }}" method="POST" enctype= "multipart/form-data">
                @csrf
                <div class="card-body">
                    <?php $status = ["npns" => "Npn"]; ?>

                    <div class="row">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="name">Document Type</label>
                        <select class="form-control" name="status" id="npn_status">
                            <option value="">Please Select</option>
                                <?php foreach ($status as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                <?php } ?>
                            </select>
                        @error('status')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="filesname">Supported Documents</label>
                        <input type="file" name="filename" class="form-control @error('filename') is-invalid @enderror" id="filename" />
                        @error('status')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
                        </div>
                    </div>

                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-dark mr-1" type="reset"><i class="fa-solid fa-arrows-rotate"></i>
                    Reset</button>
                    <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i>
                    Save</button>
                </div>
            </form>
          </div>
        </div>
        <!-- /.content -->
      </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <table id="example1" class="table table-striped table-bordered table-hover text-center"  style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>File</th>
                                @if($role->role == "Administor")
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($files as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->file_name }}</td>
                                @if($role->role == "Administor")
                                <td>
                                    <form class="d-inline" action="/file/execute/{{ $data->id }}"  method="GET">
                                        <button type="submit" class="btn btn-success btn-sm mr-1">
                                            <i class="fa-solid fa-pen"></i> upload
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>    
                    </table>
                </div>
            </div>
        </div>

    </div>
  </div>
</div>

@endsection


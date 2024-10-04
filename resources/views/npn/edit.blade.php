@extends('template.main')
@section('title', 'Edit Npn')
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
                        <li class="breadcrumb-item"><a href="/npn">Npn</a></li>
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
                        <div class="card-header">
                            <div class="text-right">
                                <a href="/npn" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                        <form class="needs-validation" novalidate action="/npn/{{ $npn->id }}" method="POST" enctype= "multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                            <?php $status = ["applied" => "Applied", "received" => "Received"]; ?>
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
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="NPN Name" value="{{old('name', $npn->name)}}" required>
                                        @error('name')
                                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="name">Status</label>
                                        <select class="form-control" name="status" id="npn_status_edit">
                                            <option value="">Please Select</option>
                                                <?php foreach ($status as $key => $value) { ?>
                                                    <option value="<?php echo $key; ?>" <?php if($key== $npn->status) echo 'selected="selected"'; ?>><?php echo $value; ?></option>
                                                <?php } ?>
                                            </select>
                                        @error('status')
                                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="name">Number</label>
                                        <input type="text" name="number" class="form-control @error('number') is-invalid @enderror" id="npn_number_edit" placeholder="Npn Number" value="{{old('number',$npn->number)}}" required>
                                        @error('name')
                                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>  
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="name">Location</label>
                                        <select class="form-control" name="location_id" id="npn_location">
                                            <option value="">Please Select</option>
                                            @foreach ($locations as $data)
                                                <option value="{{ $data->id }}" <?php if($data->id == $npn->location_id) echo 'selected="selected"'; ?>>{{ $data->location_name  }}</option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
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
        </div>
    </div>
</div>

@endsection
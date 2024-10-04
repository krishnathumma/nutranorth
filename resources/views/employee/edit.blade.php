@extends('template.main')
@section('title', 'Edit Employee')
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
            <li class="breadcrumb-item"><a href="/employee">Employee</a></li>
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
                <a href="/employee" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                  Back
                </a>
              </div>
            </div>
            <form class="needs-validation" novalidate action="/employee/{{ $employee->id }}" method="POST">
              @csrf
              @method('PUT')
              <div class="card-body">
                <?php $type = ['hired' => 'Hired', 'agency' => 'Agency']; ?>

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
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="role" placeholder="Name" value="{{old('name', $employee->name)}}" required>
                      @error('name')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="type">Type</label>
                      <select name="type" id="type" class="form-control" required>
                          <option value="">Plase Select</option>
                          <?php foreach ($type as $key => $value) { ?>
                                <option value="<?php echo $key; ?>" <?php if($key== $employee->type) echo 'selected="selected"'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                      </select>
                      @error('name')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                </div>
                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="mobile">Mobile</label>
                      <input type="number" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="role" placeholder="Mobile" value="{{old('mobile', $employee->mobile)}}" required>
                      @error('name')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="agency">Agency</label>
                      <select name="agency" id="agency" class="form-control" >
                          <option value="">Plase Select</option>
                            @foreach ($agency as $data)
                              <option value="{{ $data->id }}" <?php if($data->id == $employee->agency) echo 'selected="selected"'; ?>>{{ $data->name }}</option>
                            @endforeach
                      </select>
                      @error('agency')
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
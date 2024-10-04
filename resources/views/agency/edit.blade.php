@extends('template.main')
@section('title', 'Edit Agency')
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
            <li class="breadcrumb-item"><a href="/agency">Agency</a></li>
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
                <a href="/agency" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                  Back
                </a>
              </div>
            </div>
            <form class="needs-validation" novalidate action="/agency/{{ $agency->id }}" method="POST">
              @csrf
              @method('PUT')
              <div class="card-body">

                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{old('name', $agency->name)}}" required>
                      @error('name')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Email</label>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{old('email', $agency->email)}}" required>
                      @error('email')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                </div>

                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Mobile</label>
                      <input type="number" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" placeholder="mobile" value="{{old('mobile', $agency->mobile)}}" required>
                      @error('name')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Location</label>
                      <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location" placeholder="Location" value="{{old('location', $agency->location)}}" required>
                      @error('location')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                </div>

                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Contact Person</label>
                      <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" id="contact_person" placeholder="Contact Person" value="{{old('contact_person', $agency->contact_person)}}" required>
                      @error('contact_person')
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
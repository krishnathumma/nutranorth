@extends('template.main')
@section('title', 'Add Customer Enquiry')
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
            <li class="breadcrumb-item"><a href="/customerenquiry">Customer Enquiry</a></li>
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
                <a href="/customerenquiry" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                  Back
                </a>
              </div>
            </div>
            <form class="needs-validation" novalidate action="/customerenquiry" method="POST">
              @csrf
              <div class="card-body">
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
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{old('name')}}" required>
                      @error('name')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{old('email')}}" required>
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
                      <input type="number" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" placeholder="mobile Number" value="{{old('mobile')}}" required>
                      @error('mobile')
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
                            <option value="{{ $data->id }}">{{ $data->location_name  }}</option>
                          @endforeach
                        </select>
                      @error('status')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

               </div>

               <div class="row">
                  <?php
                    $customer_intrest = ["hot" => "Hot", "moderate" => "Moderate","cool" => "Cool"];
                    $quotetion_status = ["send" => "Send", "inprocess" => "In Process", "recived" => "Recived", "hold" => "Hold"]; 
                  ?>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Customer Intrest</label>
                      <select name="customer_intrest" id="customer_intrest" class="form-control" required>
                          <option value="">Plase Select</option>
                            <?php foreach ($customer_intrest as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                      </select>
                      @error('customer_intrest')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Quotetion Status</label>
                      <select name="quotetion_status" id="quotetion_status" class="form-control" required>
                          <option value="">Plase Select</option>
                          <?php foreach ($quotetion_status as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                      </select>
                      @error('quotetion_status')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                </div>

                <div class="row">
                  <div class="col-lg-12">
                      <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Enter ..."></textarea>
                        @error('description')
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
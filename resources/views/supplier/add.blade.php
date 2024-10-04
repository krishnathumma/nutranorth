@extends('template.main')
@section('title', 'Add Supplier')
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
            <li class="breadcrumb-item"><a href="/role">Supplier</a></li>
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
                <a href="/supplier" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                  Back
                </a>
              </div>
            </div>
            <form class="needs-validation" novalidate action="/supplier" method="POST" enctype= "multipart/form-data">
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
                  <?php $currency = ["usd" => "USD", "cad" => "CAD","inr" => "INR"]; ?>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="role" placeholder="Supplier Name" value="{{old('name')}}" required>
                     
                      @error('name')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="place">Place</label>
                      <input type="text" name="place" class="form-control @error('place') is-invalid @enderror" id="role" placeholder="Supplier place" value="{{old('place')}}" required>
                      @error('place')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                </div>

                <div class="row">
                   
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="email">Email Id</label>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="role" placeholder="Supplier email" value="{{old('email')}}" required>
                      @error('email')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="mobile">Mobile</label>
                      <input type="number" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" placeholder="123-456-7890" value="{{old('mobile')}}"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                      @error('mobile')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                </div>

                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Currency</label>
                      <select name="currency" id="currency" class="form-control" required>
                          <option value="">Plase Select</option>
                          <?php foreach ($currency as $key => $value) { ?>
                                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                            <?php } ?>
                      </select>
                      @error('currency')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="price">Price</label>
                      <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="price" value="{{old('price')}}" step="0.01" required>
                      @error('price')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                </div>

                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="filens">Supported Documents</label>
                      <input type="file" name="filename" class="form-control @error('filename') is-invalid @enderror" id="filename" />
                      @error('source')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="received_date">Received Date</label>
                      <input type="date" name="received_date" class="form-control @error('received_date') is-invalid @enderror" id="received_date" placeholder="Received Date" value="{{old('received_date')}}" required>
                      @error('received_date')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>


                </div>

                <div class="row">
                  <div class="col-lg-12">
                      <div class="form-group">
                        <label for="product">Product</label>
                        <textarea class="form-control" name="product" rows="3" placeholder="Enter ..."></textarea>
                        @error('product')
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
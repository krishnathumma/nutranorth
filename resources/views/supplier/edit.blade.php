@extends('template.main')
@section('title', 'Edit Suppliers')
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
            <li class="breadcrumb-item"><a href="/role">Suppliers</a></li>
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
            <form class="needs-validation" novalidate action="/supplier/{{ $supplier->id }}" method="POST" enctype= "multipart/form-data">
              @csrf
              @method('PUT')
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
                      <label for="name">Supplier Name</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="role" value="{{old('name', $supplier->name)}}" required>
                     
                      @error('name')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="contact_person">Contact Person</label>
                      <input type="text" name="contact_person" class="form-control @error('contact_person') is-invalid @enderror" id="contact_person" value="{{old('contact_person', $supplier->contact_person)}}" required>
                      @error('contact_person')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                </div>

                <div class="row">
                   
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="email">Email Id</label>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="role" value="{{old('email', $supplier->email)}}" required>
                      @error('email')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="mobile">Mobile</label>
                      <input type="number" name="mobile" class="form-control @error('mobile') is-invalid @enderror" id="mobile" value="{{old('mobile', $supplier->mobile)}}"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required>
                      @error('mobile')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                </div>

                <div class="row">
                  <?php 
                  $selected_ara = explode(",",$supplier->category);
                   ?>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Category Of Material</label>
                      <select name="category[]" select2 select2-hidden-accessible id="dynamicAttributes" class="form-control" required multiple="true" data-tags="true">
                          <option value="">Plase Select</option>
                          <?php foreach ($category as $value) { 
                              $selected = "";
                              if(in_array($value->name, $selected_ara)){
                                $selected = " Selected ";
                              }
                            ?>
                                <option value="<?php echo $value->id; ?>" <?php echo $selected; ?>><?php echo $value->name; ?></option>
                            <?php } ?>
                      </select>
                      @error('currency')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="selling_materials">Main Selling Materials</label>
                      <input type="text" name="selling_materials" class="form-control @error('selling_materials') is-invalid @enderror" id="selling_materials" placeholder="Selling Materials" value="{{old('selling_materials', $supplier->selling_materials)}}" required>
                      @error('selling_materials')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                </div>

                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Main Address</label>
                      <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" placeholder="Main Address" value="{{old('address',  $supplier->address)}}" required>     
                      @error('address')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="location">Shipping Locations</label>
                      <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" id="location" placeholder="Shipping Location" value="{{old('location',  $supplier->location)}}" required>
                      @error('location')
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
                      <input type="date" name="received_date" class="form-control @error('received_date') is-invalid @enderror" id="received_date" placeholder="Received Date" value="{{old('received_date', $supplier->received_date)}}" required>
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
                        <textarea class="form-control" name="product" rows="3">{{ $supplier->product }}</textarea>
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
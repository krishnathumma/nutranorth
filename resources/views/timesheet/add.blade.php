@extends('template.main')
@section('title', 'Add Timesheet')
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
            <li class="breadcrumb-item"><a href="/timesheet">Timesheet</a></li>
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
                <a href="/timesheet" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                  Back
                </a>
              </div>
            </div>
            <form class="needs-validation" novalidate action="/timesheet" method="POST" enctype= "multipart/form-data">
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
                      <label for="name">Employee Name</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="role" placeholder="Name" value="{{old('name')}}" required>
                     
                      @error('name')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="place">Agency</label>
                      <select name="agency" id="agency" class="form-control" required>
                          <option value="">Plase Select</option>
                          @foreach ($agencies as $data)
                          <option value="{{ $data->id }}">{{ $data->name }}</option>
                          @endforeach
                      </select>
                      @error('agency')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                </div>

                <div class="row">
                   
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="email">Email Id</label>
                      <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{old('email')}}" required>
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
                      <label for="received_date">Date</label>
                      <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" id="date" placeholder="Time Out" value="{{old('date')}}"  step="0.01" required>
                      @error('received_date')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Time In</label>
                      <input type="time" name="time_in" class="form-control @error('time_in') is-invalid @enderror" id="time_in" placeholder="Time In" value="{{old('time_in')}}"  step="0.01" required>
                      @error('time_in')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  

                </div>

                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="price">Time Out</label>
                      <input type="time" name="time_out" class="form-control @error('time_out') is-invalid @enderror" id="time_in" placeholder="Time Out" value="{{old('time_out')}}"  step="0.01" required>
                      @error('time_out')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="filens">Lunch Break</label>
                      <input type="time" name="lunch_break" class="form-control @error('lunch_break') is-invalid @enderror" id="time_in" placeholder="Time Out" value="{{old('lunch_break')}}"  step="0.01" required>
                      @error('source')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="received_date">Paid Break</label>
                      <input type="time" name="paid_break" class="form-control @error('paid_break') is-invalid @enderror" id="paid_break" placeholder="Time Out" value="{{old('paid_break')}}"  step="0.01" required>
                      @error('received_date')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                      <div class="form-group">
                        <label for="product">Total Hours</label> total_hours
                        <input type="time" name="total_hours" class="form-control @error('total_hours') is-invalid @enderror" id="total_hours" placeholder="Time Out" value="{{old('total_hours')}}"  step="0.01" required>
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
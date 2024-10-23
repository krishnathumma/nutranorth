@extends('template.main')
@section('title', 'Edit User')
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
            <li class="breadcrumb-item"><a href="/user">User</a></li>
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
                <a href="/user" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                  Back
                </a>
              </div>
            </div>
            
            <form class="needs-validation" novalidate action="/user/{{ $user->id_user }}" method="POST">
              @csrf
              @method('PUT')
            
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" value="{{old('name', $user->name)}}" required>
                      @error('name')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{old('email', $user->email)}}" required>
                      @error('email')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="location">Location</label>
                      <select name="location_id" id="location_id" class="form-control" required>
                          <option value="">Plase Select</option>
                          @foreach ($locations as $location)
                              <option value="{{ $location->id }}" <?php if( $location->id == $user->location_id) echo 'selected="selected"'; ?>>
                                  {{ $location->location_name  }}
                              </option>
                          @endforeach
                      </select> 
                      @error('location')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="Role">Role</label>
                      <select name="role_id" id="role_id" class="form-control" required>
                          <option value="">Plase Select</option>
                          @foreach ($roles as $role)
                              <option value="{{ $role->id }}" <?php if( $role->id == $user->role_id) echo 'selected="selected"'; ?>>
                                  {{ $role->role  }}
                              </option>
                          @endforeach
                      </select>
                      @error('role')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>

                <?php 
                  $department = [
                    'qa' => 'QA',
                    'purchase' => "Purchase",
                    'costing' => 'Costing',
                    'sales/marketing' => 'Sales/Marketing',
                    'digital_design' => "Digital Design",
                    'it' => "IT",
                    'production' => "Production",
                    'accounts' => "Accounts",
                    'administration' => "Administration",
                    'others' => "Others"
                  ];
                ?>
                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="location">Department</label>
                      <select name="department" id="department_id" class="form-control" required>
                          <option value="">Plase Select</option>
                          @foreach ($department as $key => $value)
                              <option value="{{ $key }}" <?php if( $key == $user->department) echo 'selected="selected"'; ?>>
                                  {{ $value  }}
                              </option>
                          @endforeach
                      </select> 
                      @error('department')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="designation">Designation</label>
                      <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" id="designation" value="<?php echo $user->designation; ?>" required>
                      @error('designation')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

              </div>  

                <!-- <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" value="{{old('password')}}" required>
                      @error('password')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                </div> -->
                
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
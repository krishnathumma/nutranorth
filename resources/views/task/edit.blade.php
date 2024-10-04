@extends('template.main')
@section('title', 'Edit Task')
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
            <li class="breadcrumb-item"><a href="/role">Role</a></li>
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
                <a href="/task" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                  Back
                </a>
              </div>
            </div>
            <form class="needs-validation" novalidate action="/task/{{ $task->id }}" method="POST" enctype= "multipart/form-data">
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
                  <?php
                    $category = ["quotation" => "Quotation", "purchase" => "Purchase","qa" => "QA","others" => "Others"];
                    $type = ["urgent" => "Urgent", "normal" => "Normal", "on_going" => "On Going"]; 
                    $options = ['pending' => 'Pending','inprogress' => 'In Progress','completed' => 'Completed'];
                  ?>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Category</label>
                      <select name="task_category" id="task_category" class="form-control" required>
                          <option value="">Plase Select</option>
                            <?php foreach ($category as $key => $value) { ?>
                                <option value="<?php echo $key; ?>" <?php if($key== $task->task_category) echo 'selected="selected"'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                      </select>
                      @error('task_category')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Type</label>
                      <select name="task_type" id="task_type" class="form-control" required>
                          <option value="">Plase Select</option>
                          <?php foreach ($type as $key => $value) { ?>
                                <option value="<?php echo $key; ?>" <?php if($key== $task->task_type) echo 'selected="selected"'; ?>><?php echo $value; ?></option>
                            <?php } ?>
                      </select>
                      @error('task_type')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                </div>

                <div class="row">
                   
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="assigned_to">Assigned To</label>
                      <select name="assigned_to" id="assigned_to" class="form-control" required>
                          <option value="">Plase Select</option>
                          @foreach ($users as $user)
                              <option value="{{ $user->id_user }}" <?php if($user->id_user== $task->assigned_to) echo 'selected="selected"'; ?>>
                                  {{ $user->name  }}
                              </option>
                          @endforeach
                      </select>
                      @error('assigned_to')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="assigned_date">Assigned Date</label>
                      <input type="datetime" name="assigned_date" class="form-control @error('assigned_date') is-invalid @enderror" id="assigned_date" value="{{ $task->assigned_date }} " required>
                      @error('assigned_date')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                </div>

                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="source">source</label>
                      <input type="text" name="source" class="form-control @error('source') is-invalid @enderror" id="source" placeholder="source" value="{{old('source', $task->source)}}" required>
                      @error('source')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="due_date">Due Date</label>
                      <input type="datetime" name="due_date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" placeholder="due_date" value="{{ $task->due_date }}" required>
                      @error('due_date')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>

                </div>

                <div class="row">

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="files">Supported Documents</label>
                      <input type="file" name="filename" class="form-control @error('filename') is-invalid @enderror" id="filename" />
                      @error('filename')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Status</label>
                      <select name="status" id="status" class="form-control" required>
                          <option value="">Plase Select</option>
                          <?php foreach ($options as $key => $value) { ?>
                                <option value="<?php echo $key; ?>" <?php if($key== $task->status) echo 'selected="selected"'; ?> ><?php echo $value; ?></option>
                            <?php } ?>
                      </select>
                      @error('status')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>


                </div>

                <div class="row">
                  <div class="col-lg-12">
                      <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" rows="3" value= "{{ $task->discription }}"></textarea>
                        @error('source')
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
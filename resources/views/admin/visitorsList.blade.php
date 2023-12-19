@extends('admin.layouts.master')
@section('title','Visitors List')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Visitors List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li> --}}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                  <table id="visitors_list" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Mobile</th>
                      <th>DATE/TIME</th>
                      <th>Last Logged In</th>
                    </tr>
                    </thead>
                    <tbody>
                  
                  </tbody>
                    
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
    <!-- /.content -->
  </div>

  @endsection
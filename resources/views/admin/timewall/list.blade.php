@extends('admin.layouts.master')
@section('title','Time Wall')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Time Wall</h1>
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
                    <a class="btn btn-success bg-light border-light" href="{{url('admin/timewall/create')}}" type="submit">Add New</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="timewall_list" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>S.no</th>
                      <th>VIDEO THUMBNAIL</th>
                      <th>VIDEO NAME</th>
                      <th>VIDEO</th>
                      <th>DATE/TIME</th>
                      <th>ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                  
                  </tbody>
                    {{-- <tfoot>
                    <tr>
                      <th>S.no</th>
                      <th>VIDEO THUMBNAIL</th>
                      <th>VIDEO NAME</th>
                      <th>VIDEO</th>
                      <th>DATE/TIME</th>
                      <th>ACTION</th>
                    </tr>
                    </tfoot> --}}
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
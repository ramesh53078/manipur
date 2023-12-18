<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('admin/assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{url('admin/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{url('admin/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{url('admin/assets/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('admin/assets/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{url('admin/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('admin/assets/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{url('admin/assets/plugins/summernote/summernote-bs4.min.css')}}">

  <link rel="stylesheet" href="{{url('admin/assets/plugins/toastr/toastr.min.css')}}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{url('admin/assets/dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  @include('admin.layouts.header')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('content')
  <!-- /.content-wrapper -->
  @include('admin.layouts.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{url('admin/assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('admin/assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{url('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{url('admin/assets/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{url('admin/assets/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{url('admin/assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('admin/assets/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{url('admin/assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{url('admin/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{url('admin/assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{url('admin/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('admin/assets/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('admin/assets/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('admin/assets/dist/js/pages/dashboard.js')}}"></script>

<script src="{{url('admin/assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{url('admin/assets/plugins/toastr/toastr.min.js')}}"></script>

<script src="{{url('admin/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{url('admin/assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{url('admin/assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
     $(function () {

        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if(session('error'))
            toastr.error('{{ session('error') }}');
        @endif

            $("#timewall_list").DataTable({
                                    "responsive": true,
                                    "lengthChange": false,
                                    "autoWidth": false,
                                    "serverSide": true,
                                    "ajax": {
                                        "url": "{{ route('admin.timewall.list') }}",
                                        "type": "GET", // Adjust the HTTP request method if needed
                                        "dataType": "json", // Specify the data type you expect from the server
                                    },
                                    "columns": [
                                        { "data": 'DT_RowIndex', "name": 'DT_RowIndex' },
                                        {"data": 'thumbnail', "name": 'thumbnail'},
                                        { "data": 'video_name', "name": 'video_name' },
                                        {"data": 'video', "name": 'video'},
                                        { "data": 'created_at', "name": 'created_at'},
                                        { "data": 'action', "name": 'action', "orderable": false, "searchable": false },
                                    ],
                                    "processing": true, // Display a loading indicator while loading data
                                });

                                $("#largevideowall_list").DataTable({
                                    "responsive": true,
                                    "lengthChange": false,
                                    "autoWidth": false,
                                    "serverSide": true,
                                    "ajax": {
                                        "url": "{{ route('admin.largevideowall.list') }}",
                                        "type": "GET", // Adjust the HTTP request method if needed
                                        "dataType": "json", // Specify the data type you expect from the server
                                    },
                                    "columns": [
                                        { "data": 'DT_RowIndex', "name": 'DT_RowIndex' },
                                        {"data": 'thumbnail', "name": 'thumbnail'},
                                        { "data": 'video_name', "name": 'video_name' },
                                        {"data": 'video', "name": 'video'},
                                        { "data": 'created_at', "name": 'created_at'},
                                        { "data": 'action', "name": 'action', "orderable": false, "searchable": false },
                                    ],
                                    "processing": true, // Display a loading indicator while loading data
                                });
     });
</script>
</body>
</html>

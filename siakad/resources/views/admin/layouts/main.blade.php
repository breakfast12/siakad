<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('DataTables/DataTables/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('DataTables/Responsive/css/responsive.bootstrap5.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css">

    <link
        href="{{ asset('font/Nunito/Nunito-Italic-VariableFont_wght.ttf') }}"
        rel="stylesheet">
        <link
        href="{{ asset('font/Nunito/Nunito-VariableFont_wght.ttf') }}"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/siakad.css') }}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('admin.layouts.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('admin.layouts.navbar')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('container')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" onclick="logout()">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>

 <!-- Bootstrap core JavaScript-->
 <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
 <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
 <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
 <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('popper/popper.min.js') }}"></script>

 <!-- Core plugin JavaScript-->
 <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

 <!-- Custom scripts for all pages-->
 <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
 <script src="{{ asset('DataTables/DataTables/js/dataTables.bootstrap5.min.js') }}"></script>
 <script src="{{ asset('DataTables/Responsive/js/responsive.bootstrap5.min.js') }}"></script>
 <script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
 <script src="{{ asset('js/index.js') }}"></script>
 <script src="{{ asset('js/jurusan.js') }}"></script>
 <script src="{{ asset('js/matkul.js') }}"></script>
 <script src="{{ asset('js/dosen.js') }}"></script>
</html>
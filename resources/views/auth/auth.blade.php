<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ uploadAndDownloadUrl() }}admin/assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css"
        rel="stylesheet" />
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/css/pace.min.css" rel="stylesheet" />
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/css/app.css" rel="stylesheet">
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ uploadAndDownloadUrl() }}admin/assets/css/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="{{ uploadAndDownloadUrl() }}admin/assets/js/toaster/toastr.css">
    <title>@yield('title')</title>
</head>

<body class="bg-login">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="mb-4 text-center">
                            <img src="{{ uploadAndDownloadUrl() }}admin/assets/images/logo-icon.png" width="75" alt="" />
                            {{-- <h4> Agri App</h4> --}}
                        </div>
                        @yield('content')
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/jquery.min.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/login_common.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/notify/bootstrap-notify.min.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/sweet-alert/sweetalert.min.js"></script>
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/toaster/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/app.js"></script>
    @yield('script')
    @include('layouts.flashMessage')
</body>

</html>

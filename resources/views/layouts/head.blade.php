<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    <!--favicon-->
    <link rel="icon" href="{{ uploadAndDownloadUrl() }}admin/assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/css/pace.min.css" rel="stylesheet" />
    <script src="{{ uploadAndDownloadUrl() }}admin/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/css/app.css" rel="stylesheet">
    <link href="{{ uploadAndDownloadUrl() }}admin/assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ uploadAndDownloadUrl() }}admin/assets/css/dark-theme.css" />
    <link rel="stylesheet" href="{{ uploadAndDownloadUrl() }}admin/assets/css/semi-dark.css" />
    <link rel="stylesheet" href="{{ uploadAndDownloadUrl() }}admin/assets/css/header-colors.css" />
    <link rel="stylesheet" type="text/css" href="{{ uploadAndDownloadUrl() }}admin/assets/css/sweetalert2.css">
    <link rel="stylesheet" type="text/css" href="{{ uploadAndDownloadUrl() }}admin/assets/js/toaster/toastr.css">
    <link href="{{uploadAndDownloadUrl()}}/admin/assets/js/select2/css/select2.min.css" rel="stylesheet" />
    <link href="{{uploadAndDownloadUrl()}}/admin/assets/js/select2/css/select2-bootstrap4.css" rel="stylesheet" />
    
    <title>@yield('title')</title>

    @yield('style')
</head>
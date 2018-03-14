<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta property="fb:admins" content=""/>
    <meta property="fb:app_id" content=""/>

    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="shortcut icon" href="https://dashboard.mintheinkha.com/assets/uploads/astrologer/mintheinkha_logo.png" type="image/x-icon" />

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Font Awesome
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">-->
    <!-- Ionicons -->
   <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- <link rel="stylesheet" href="https://dashboard.mintheinkha.com//assets/template/dist/css/AdminLTE.css">
     --><!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">

    <!-- jvectormap -->
    <link rel="stylesheet" href="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
  
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="{{asset('bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

    <link rel="stylesheet" href="{{asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.css')}}">


    <link rel="stylesheet" href="{{asset('bower_components/jquery-ui/themes/base/jquery-ui.css')}}">

    <!-- jQuery 2.2.3 -->
    <script src="{{asset('js/jquery.js')}}"></script>


    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    
    <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>WZ</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Wun Zin</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                         <a href="{{'SignOut'}}" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-sign-out"></i>
                         </a>
                    </li>

                </ul>
            </div>

        </nav>
    </header>
    <aside class="main-sidebar">

        <section class="sidebar">

            <ul class="sidebar-menu">
                <li class="header">MAIN NAVIGATION</li>


                <li  class="treeview">
                    <a href="{{url('BookEntry')}}">
                        <i class="fa fa-book"></i>
                        <span>Add New Book</span>
                        <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>


                </li>

                <li>
                    <a href="{{url('BookListing')}}">
                        <i class="fa fa-credit-card"></i>
                        <span>Book Listing</span>
                        <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>


                </li>

                <li>
                    <a href="{{url('StatusEntry')}}">
                        <i class="fa fa-credit-card"></i>
                        <span>Add New Status</span>
                        <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                </li>

                <li>
                    <a href="{{url('GetStatusList')}}">
                        <i class="fa fa-credit-card"></i>
                        <span>Status Listing</span>
                        <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                </li>



            </ul>
        </section>

    </aside>


    <div class="content-wrapper">

        <div class="row">
            <div class="col-md-12">
                <center>@yield('success')</center>
                <center style="color: red;">@yield('error')</center>
            </div>
        </div>

        @yield('content')

    </div> <!-- /.content -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.5
        </div>
        <strong>Copyright &copy; 2014-2018 <a href="http://baganinnovation.com">Bagan Innovation Technology</a>.</strong> All rights
        reserved.
    </footer>

</div><!-- ./wrapper -->


<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>

<!-- jvectormap -->
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>

<script src="{{asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{'js/daterangepicker.js'}}"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/app.js')}}"></script>


</body>
</html>

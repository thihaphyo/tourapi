<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | Login</title>
    <link rel="shortcut icon" href="https://dashboard.mintheinkha.com/assets/uploads/astrologer/mintheinkha_logo.png" type="image/x-icon" />
    <!-- Bootstrap -->
    <link href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet" media="screen">
    <link href="{{asset('css/style.css')}}" rel="stylesheet" media="screen">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
 
    <style>
        #login{
            background: #FAFAFA;
        }
    </style>
</head>
<body id="login">
<div class="container login-card text-center">

    <form method="POST" class="form-signin" action="{{'LoginCheck'}}">

        {{csrf_field()}}

        <div class="row">
            <div class="col-md-12">
              <center>
                <img src="https://dashboard.mintheinkha.com/assets/uploads/astrologer/mintheinkha_logo.png" alt="User Image" class="img-circle img-responsive" width="100px" height="100px">
              </center>  
            </div>
        </div>

        <div class="row">
            <h4 class="h4 text-center">
                <b>Min Thein Kha Reports</b>
            </h4>
        </div>

        <div class="row" style="margin-bottom: 1%;">
            <div class="col-md-12">
                <center style="color: red">{{count(\Session::get('Err')) == 0 ? '' : \Session::get('Err')}}</center>
                <center> 
                    <input type="text" class="" placeholder="Username" name="username">
                </center>
            </div>
        </div>

        <div class="row" style="margin-bottom: 1.5%;">
            <div class="col-md-12">
                <center> 
                     <input type="password" class="" placeholder="Password" name="password">
                </center>
            </div>
        </div>

         <div class="row" style="margin-bottom: 1%;">
            <div class="col-md-12">
                <center> 
                         <button class="btn btn-large  btn-primary" type="submit">Sign in</button>
                </center>
            </div>
        </div>

       

       

    
    </form>

</div> <!-- /container -->
<script src="https://dashboard.mintheinkha.com/assets/vendors/jquery-1.9.1.min.js"></script>
<script src="https://dashboard.mintheinkha.com/assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
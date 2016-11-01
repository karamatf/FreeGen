<?php
error_reporting (E_ALL ^ E_NOTICE); /* 1st line (recommended) */

include 'db.php';
include 'dbc.php';

$result = mysqli_query($con, "SELECT * FROM `settings`");
$settings = mysqli_fetch_array($result);


if($_POST['doRegister'] == 'Register') 
{ 

if (!isUserID($_POST['username'])) {
$msg = "Invalid user name. It can contain alphabet, number and underscore.";
}

if (!checkPwd($_POST['password'],$_POST['confirmPassword'])) {
$msg = "Invalid Password or mismatch. Enter 5 chars or more";
}
	  
$user_ip = $_SERVER['REMOTE_ADDR'];

$sha1pass = PwdHash($_POST['password']);

$user_email = $_POST['email'];
$user_name = $_POST['username'];

$sql = "SELECT * FROM users WHERE user_email='$user_email' OR user_name='$user_name'";
$result = mysqli_query($con, $sql);
$total = mysqli_num_rows($result);

if ($total > 0) {
$msg = "The username/email already exists. Please try again with different username and email.";
}

if(empty($msg)) {

$sql = "INSERT into `users`(`md5_id`,`full_name`,`user_email`,`pwd`,`date`,`users_ip`,`approved`,`user_name`,`users_info`,`ckey`,`ctime`) VALUES ('','User','$user_email','$sha1pass',now(),'$user_ip','1','$user_name','','','')";
			
mysqli_query($con, $sql);

  $done = "Please now sign in <a href='login.php'>here</a>.";

               }
} 	

?>
<html><head>
    <meta charset="utf-8">
    <title><?php echo $settings['title']; ?> - Register</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">
    <link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
    <link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
   <![endif]-->
</head>

<body class="external-page sb-l-c sb-r-c">

    <!-- Start: Settings Scripts -->
    <script>
    var boxtest = localStorage.getItem('boxed');
    if (boxtest === 'true') {
        document.body.className += ' boxed-layout';
    }
    </script>
    <!-- End: Settings Scripts -->

    <!-- Start: Main -->
    <div id="main" class="animated fadeIn">

        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">

            <!-- begin canvas animation bg -->
            <div id="canvas-wrapper">
                <canvas id="demo-canvas"></canvas>
            </div>

            <!-- Begin: Content -->
            <section id="content" class="">

                <div class="admin-form theme-info mw700" style="margin-top: 3%;" id="login1">

                    <div class="row mb15 table-layout">

                        <div class="col-xs-6 va-m pln">
                            <a>
                                
                            </a>
                        </div>

                        <div class="col-xs-6 text-right va-b pr5">
                            <div class="login-links">
                                <a href="login.php" class="" title="Sign In">Sign In</a>
                                <span class="text-white"> | </span>
                                <a href="register.php" class="active" title="Register">Register</a>
                            </div>

                        </div>

                    </div>

                    <div class="panel panel-info mt10 br-n">

                        <div class="panel-heading heading-border bg-white">
 <?php                      
     
if(!empty($msg)){

echo "<div class=\"alert .alert-micro alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
<i class=\"fa fa-remove pr10\"></i>
<strong>Error!</strong> $msg</div>";

}

if(!empty($done)){

echo "<div class=\"alert .alert-micro alert-success alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
<i class=\"fa fa-remove pr10\"></i>
<strong>Great news!</strong> $done</div>";

}

?>

                        </div>

                        <form method="post" action="register.php">
                            <div class="panel-body p25 bg-light">
                                <div class="section-divider mt10 mb40">
                                    <span>Set up your account</span>
                                </div>
                                <!-- .section-divider -->

                                
                                <!-- end .section row section -->

                                <div class="section">
                                    
                                        <input type="email" name="email" id="email" class="gui-input" placeholder="Email address" required="">
                                  
                                </div>
                                <!-- end section -->

                                <div class="section">
                                    
                                        <input type="text" name="username" id="username" class="gui-input" placeholder="Username" required="">
                                      
                                </div>
                                <!-- end section -->

                                <div class="section">
                                    <input type="password" name="password" id="password" class="gui-input" placeholder="Create a password" required="">
                                </div>
                                <!-- end section -->

                                <div class="section">
                                    <input type="password" name="confirmPassword" id="confirmPassword" class="gui-input" placeholder="Retype your password" required="" equalto="#password">
                                </div>
                                <!-- end section -->

                                <div class="section-divider mv40">
                                    <span>Review the Terms</span>
                                </div>
                                <!-- .section-divider -->

                                <div class="section mb15">
                                    
                                    <label class="option block mt15">
                                        <input type="checkbox" name="terms" required="">
                                        <span class="checkbox"></span>I agree to the
                                        <a href="tos.php" class="smart-link"> terms of use. </a>
                                    </label>
                                </div>

                            </div>
                            <!-- end .form-body section -->
                            <div class="panel-footer clearfix">
                                <input type="submit" class="button btn-primary pull-right" name="doRegister" value="Register">
                            </div>
                        </form>
                    </div>
                </div>

            </section>

        </section>

    </div>




</body></html>
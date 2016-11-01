<?php
error_reporting (E_ALL ^ E_NOTICE); /* 1st line (recommended) */

include 'db.php';
include 'dbc.php';

$result = mysqli_query($con, "SELECT * FROM `settings`");
$settings = mysqli_fetch_array($result);

if ($_POST['doLogin']=='Login')
{
$user_name = $_POST['username'];
$pass = $_POST['password'];

$sql = "SELECT `id`,`pwd`,`user_name`,`approved`,`user_level` FROM users WHERE user_name='$user_name' AND `banned` = '0'";

$result = mysqli_query($con, $sql);

$num = mysqli_num_rows($result);

  // Match row found with more than 1 results  - the user is authenticated. 
    if ( $num > 0 ) { 
	
	list($id,$pwd,$user_name,$approved,$user_level) = mysqli_fetch_row($result);
	
	if(!$approved) {
	$msg = "Account not activated. Please check your email for activation code";
	 }
	 
		//check against salt
	if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
	if(empty($msg)){			

     // this sets session and logs user in  
       session_start();
	   session_regenerate_id (true); //prevent against session fixation attacks.

	   // this sets variables in the session 
		$_SESSION['user_id']= $id;  
		$_SESSION['user_name'] = $user_name;
		$_SESSION['user_level'] = $user_level;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
		
		//update the timestamp and key for cookie
		$stamp = time();
		$ckey = GenKey();
                $sql = "update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'";
		mysqli_query($con, $sql);
		
		//set a cookie 
		
	   if(isset($_POST['remember'])){
				  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				   }
header("Location: index.php");

		 }
		}
		else
		{
		$msg = "Invalid Login. Please try again with correct user email and password. ";
	
		}
	} else {
		$msg = "Invalid login. No such user exists";
	  }		
}

?>

<html><head>
    <meta charset="utf-8">
    <title><?php echo $settings['title']; ?> - Sign In</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">
    <link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
    <link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
    <link rel="shortcut icon" href="assets/img/favicon.ico">
<style type="text/css"></style><style type="text/css"></style></head>

<body class="external-page sb-l-c sb-r-c onload-check">

    <div id="main" class="animated fadeIn">

        <section id="content_wrapper">

            <div id="canvas-wrapper" style="height: 464px;">
                <canvas id="demo-canvas" width="1366" height="464"></canvas>
            </div>

            <section id="content">

                <div class="admin-form theme-info" id="login1">

                    <div class="row mb15 table-layout">

                        <div class="col-xs-6 va-m pln">
                            <a> </a>
                        </div>

                        <div class="col-xs-6 text-right va-b pr5">
                            <div class="login-links">
                                <a href="login.php" class="active" title="Sign In">Sign In</a>
                                <span class="text-white"> | </span>
                                <a href="register.php" class="" title="Register">Register</a>
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

?>
                            
                        </div>

                        <form action="login.php" method="post">
                            <div class="panel-body bg-light p30">
<div class="section-divider mt10 mb40">
                                    <span>Sign In</span>
                                </div> 
                                <div class="row">
                                    <div class="col-sm-12 pr30">
                                        <div class="section">
                                            
                                                <input type="text" name="username" id="username" class="gui-input" placeholder="Enter username">
                                             
                                        </div>                                      
                                        <div class="section">
                                            
                                                <input type="password" name="password" id="password" class="gui-input" placeholder="Enter password">
                                             
                                        </div>
                                        

                                    </div>
                                    
                                </div>
                            </div>
                            
                             <div class="panel-footer clearfix p10 ph15">
                                <input type="submit" class="button btn-primary mr10 pull-right" name="doLogin" value="Login">
                                <label class="switch block switch-primary pull-left input-align mt10">
                                    <input type="checkbox" name="remember" id="remember" checked>
                                    <label for="remember" data-on="YES" data-off="NO"></label>
                                    <span>Remember me</span>
                                </label>
                            </div>
                        </form>
                    </div>
                </div>

            </section>

        </section>

    </div>



<div class="jvectormap-label"></div><div class="jvectormap-label"></div></body></html>
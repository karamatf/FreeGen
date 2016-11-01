<?php
error_reporting (E_ALL ^ E_NOTICE); /* 1st line (recommended) */

include 'db.php';
include 'dbc.php';

page_protect();

$result = mysqli_query($con, "SELECT * FROM `settings`");
$settings = mysqli_fetch_array($result);

if($_POST['doUpdate'] == 'Update')  {

$user_name = $_SESSION['user_name'];
$pass = $_POST['pwd_old'];

$sql = "SELECT `id`,`pwd`,`user_name`,`approved`,`user_level` FROM users WHERE user_name='$user_name'";
$result = mysqli_query($con, $sql);
	
	list($id,$pwd,$user_name,$approved,$user_level) = mysqli_fetch_row($result);
	
if ($pwd === PwdHash($pass,substr($pwd,0,9))) { 
	$newsha1 = PwdHash($_POST['pwd_new']);
        $sql = "UPDATE users SET pwd='$newsha1' WHERE user_name='$user_name'";
	mysqli_query($con, $sql);
	$msg = "Your new password is updated";
}
else{
	$err = "Your old password is invalid";
}
}

if($_POST['doConfigure'] == 'Update') {
if(checkAdmin()){

$title = $_POST['title'];
$email = $_POST['email'];
$price = $_POST['price'];
$tos = $_POST['tos'];
$types = $_POST['types'];

$sql = "UPDATE settings SET title='$title', email='$email', price='$price', tos='$tos', types='$types'";
mysqli_query($con, $sql);

$msg = "You have updated the website settings. Please re-enter the url for the changes to take effect on this page.";


}
}

?>
<html><head>
    
    <meta charset="utf-8">
    <title><?php echo $settings['title']; ?> - Settings</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">
    <link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
    <link rel="shortcut icon" href="assets/img/favicon.ico">
   
    <div id="main">        
        <header class="navbar navbar-fixed-top bg-light">
            <div class="navbar-branding dark">
                <a class="navbar-brand" href="index.php"> <b><?php echo $settings['title']; ?></b> </a>
            </div>
        </header>  
        <aside id="sidebar_left" class="nano nano-primary sidebar-default">
            <div class="nano-content">
                <ul class="nav sidebar-menu">
                    <li class="sidebar-label pt20">Menu</li>
                    <li>
                        <a href="index.php">
                            <span class="glyphicons glyphicons-home"></span>
                            <span class="sidebar-title">Dashboard</span>
                        </a>
                    </li> 
                    <li class="active">
                        <a href="settings.php">
                            <span class="glyphicons glyphicons-cogwheel"></span>
                            <span class="sidebar-title">Account Settings</span>
                        </a>
                    </li>
<?php
if(checkAdmin()){
?>                  
                    <li>
                        <a class="accordion-toggle menu-open" href="#">
                            <span class="glyphicons glyphicons-cogwheel"></span>
                            <span class="sidebar-title">Admin Settings</span>
                            <span class="caret"></span>
                        </a>
                        <ul class="nav sub-nav" style="">
                            <li>
                                <a href="add.php">
                                    <span class="glyphicons glyphicons-book"></span> Add Accounts </a>
                            </li>
                            <li>
                                <a href="accounts.php">
                                    <span class="glyphicons glyphicons-show_big_thumbnails"></span> Manage Accounts </a>
                            </li>
                            <li>
                                <a href="users.php">
                                    <span class="glyphicons glyphicons-sampler"></span> Manage Users </a>
                            </li>
                        </ul>
                    </li>
<?php
}
if(checkPaid()){
?>
                    <li>
                        <a href="generator.php">
                            <span class="glyphicons glyphicons-cup"></span>
                            <span class="sidebar-title">Generator</span>                           
                        </a>                        
                    </li>
<?php
}
?>               
                    <li>
                        <a href="purchase.php">
                            <span class="glyphicons glyphicons-shopping_cart"></span>
                            <span class="sidebar-title">Purchase</span>
                            </a>                        
                    </li>
                    <li>
                        <a href="logout.php">
                            <span class="glyphicons glyphicons-fire"></span>
                            <span class="sidebar-title">Log Out</span>
                        </a>
                    </li> 
                    <div style="position: absolute; bottom: 5px"><li class="sidebar-label pt20">Created by <a href="https://github.com/welshman/FreeGen" target="_blank">Welshman</a></li></div>
                </ul>
            </div>
        </aside>
        <section id="content_wrapper">
        <section id="content" class="">
<?php
if(!empty($msg)){

echo "<div class=\"alert alert-success alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"fa fa-check pr10\"></i><strong>Well done! </strong>$msg</div>";

}
if(!empty($err)){

echo "<div class=\"alert alert-danger alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"fa fa-remove pr10\"></i><strong>Snap! </strong>$err</div>";

}
?>
        <div class="row">
  <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title">Update Password</span>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post">
                                    
                                    <div class="ph30">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-key"></i>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Old Password" name="pwd_old">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-key"></i>
                                                </span>
                                                <input class="form-control" type="text" placeholder="New Password" name="pwd_new">
                                            </div>
                                        </div>


<input class="btn btn-primary" type="submit" value="Update" name="doUpdate">
 
                                        
                                        
                                    </div>

                                </form>
                            </div>
                        </div>


                    </div>




          </div>
<?php
if(checkAdmin()){
?>
<div class="row">
  <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title">Configure Website Settings</span>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post">
<span class="help-block mt5"><center>This Section Will Only Be Shown To Admin Accounts</center></span>
                                    <div class="ph30">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-rocket"></i>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Title" value="<?php echo $settings['title']; ?>" name="title">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            

<div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i>
                                                </span>
                                                <input class="form-control" type="email" placeholder="Email" value="<?php echo $settings['email']; ?>" name="email">
                                            </div>


                                        </div>


<div class="form-group">
                                            

<div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-key"></i>
                                                </span>
                                                <input class="form-control" type="number" placeholder="Lifetime Price" value="<?php echo $settings['price']; ?>" name="price">
                                            </div>


                                        </div><div class="form-group">
                                            

<div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-exclamation"></i>
                                                </span>
                                                <textarea class="form-control textarea-grow" rows="4" name="tos" required="" value="<?php echo $settings['tos']; ?>" placeholder="Type Here..."><?php echo $settings['tos']; ?></textarea>
                                            </div>
<span class="help-block mt5"><i class="fa fa-bell"></i> Reminder: Use "< br >" (no spaces) for line break.</span>


                                        </div><div class="form-group">
                                            

<div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-fighter-jet"></i>
                                                </span>
                                                <input class="form-control" type="text" value="<?php echo $settings['types']; ?>" placeholder="Account Types" name="types">
                                            </div>
<span class="help-block mt5"><i class="fa fa-bell"></i> Reminder: Account Types In This Format - "Type 1, Type 2, Type 3"</span>


                                        </div>




<input class="btn btn-primary" type="submit" value="Update" name="doConfigure">
 
                                        
                                        
                                    </div>

                                </form>
                            </div>
                        </div>


                    </div>




          </div>
<?php
}
?>
        </section>

    </section></div>
       
    <script type="text/javascript" src="vendor/jquery/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>   
    <script type="text/javascript" src="assets/js/bootstrap/bootstrap.min.js"></script>   
    <script type="text/javascript" src="assets/js/utility/utility.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
    <script type="text/javascript" src="assets/js/demo.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {

            "use strict";

            // Init Theme Core    
            Core.init();

            // Init Theme Core    
            Demo.init();

        });
    </script>
<div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div>
<div class="jvectormap-label"></div></body></html>
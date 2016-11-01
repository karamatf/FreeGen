<?php
error_reporting (E_ALL ^ E_NOTICE); /* 1st line (recommended) */

include 'db.php';
include 'dbc.php';

page_protect();

if(!checkPaid()) {
header("Location: login.php");
exit();
}

$result = mysqli_query($con, "SELECT * FROM `settings`");
$settings = mysqli_fetch_array($result);

$types1 = preg_split("/,/", $settings['types']); 

foreach ($types1 as $types2){ 

$types3 .= "<option value=\"$types2\">$types2</option>";

}

if(checkPaid()){
if(!empty($_POST['doGenerate'])){
$type = $_POST['type'];
$sql = "SELECT * FROM accounts WHERE used='0' AND type='$type' ORDER BY RAND() LIMIT 1";
$result = mysqli_query($con, $sql);
$accountrows = mysqli_num_rows($result);
if($accountrows == "0"){
$err = "There are no $type accounts available.";
}
else{
$account = mysqli_fetch_array($result);
$id = $account['id'];
$email = $account['email'];
$password = $account['password'];
$user_na = $_SESSION['user_name'];
$sql = "UPDATE accounts SET used='1', bywho='$user_na' WHERE id='$id'";
mysqli_query($con, $sql);
}
}
}

?>
<html><head>
    
    <meta charset="utf-8">
    <title><?php echo $settings['title']; ?> - Generator</title>
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
                <a class="navbar-brand" href="index.php"> <b><?php echo $settings['title']; ?></b></a>
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
                    <li>
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
                    <li class="active">
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

if(!empty($err)){
echo "<div class=\"alert alert-danger alert-dismissable\">
<button type='button' class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"fa fa-remove pr10\"></i><strong>Snap! </strong>$err</div>";
}

?>

<div class="row">

                    
<div class="col-md-12">

                        

                        

                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title">Generator</span>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post">
                                    
                                    <div class="ph30">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i>
                                                </span>
                                                <input class="form-control" type="text" value="<?php echo $email; ?>" placeholder="Email / Username" name="email-single">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-key"></i>
                                                </span>
                                                <input class="form-control" type="text" value="<?php echo $password; ?>" placeholder="Password" name="password-single">
                                            </div>
                                        </div>
<span class="help-block mt5"><i class="fa fa-bell"></i> Reminder: Please select an Account Type from below before clicking Generate Account</span>
<div class="tab-content pn br-n admin-form"><label for="product-category" class="field select">
                                                <select id="product-category" name="type" class="empty">
                                                    
<?php

    echo $types3;										
?>
                                                                                                       
                                                    
                                                </select>
                                                <i class="arrow"></i>
  </label></div>

<br><input class="btn btn-primary" type="submit" value="Generate Account" name="doGenerate">
 
                                        
                                        
                                    </div>

                                </form>
                            </div>
                        </div>


                    </div>


                    
                </div>
            </section>
            <!-- End: Content -->

        </section>

        
        
        

    </div>
    

    

    
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
    




<div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div></body></html>
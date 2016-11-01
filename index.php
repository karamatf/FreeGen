<?php

include 'db.php';
include 'dbc.php';

page_protect();

$result = mysqli_query($con, "SELECT * FROM `settings`");
$settings = mysqli_fetch_array($result);


?>
<html><head>
    
    <meta charset="utf-8">
    <title><?php echo $settings['title']; ?> - Dashboard</title>
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
                    <li class="active">
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

$sql = "SELECT * FROM users";
$result = mysqli_query($con, $sql);
$a_users = mysqli_num_rows($result);

$user_name = $_SESSION['user_name'];
$sql = "SELECT * FROM users WHERE user_name='$user_name'";
$result = mysqli_query($con, $sql);
$a_rank = mysqli_fetch_array($result);
$a_ranks = $a_rank['user_level'];
if($a_ranks == "1"){
$a_ranko = "Registered";
}
if($a_ranks == "3"){
$a_ranko = "Upgraded";
}
if($a_ranks == "5"){
$a_ranko = "Admin";
}

$sql = "SELECT * FROM accounts WHERE used='0'";
$result = mysqli_query($con, $sql);
$a_accounts = mysqli_num_rows($result);

?>

<div class="row mb10">
                    <div class="col-md-4">
                        <div class="panel bg-info light of-h mb10">
                            <div class="pn pl20 p5">
                                <div class="icon-bg"> <i class="fa fa-group"></i> </div>
                                <h2 class="mt15 lh15"> <b><?php echo $a_users; ?></b> </h2>
                                <h5 class="text-muted">Users</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel bg-danger light of-h mb10">
                            <div class="pn pl20 p5">
                                <div class="icon-bg"> <i class="fa fa-user"></i> </div>
                                <h2 class="mt15 lh15"> <b><?php echo $a_ranko; ?></b> </h2>
                                <h5 class="text-muted">Your Rank</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel bg-warning light of-h mb10">
                            <div class="pn pl20 p5">
                                <div class="icon-bg"> <i class="fa fa-font"></i> </div>
                                <h2 class="mt15 lh15"> <b><?php echo $a_accounts; ?></b> </h2>
                                <h5 class="text-muted">Accounts Available</h5>
                            </div>
                        </div>
                    </div>
</div class="row">

<div class="panel mb50 sort-disable" data-animate="fadeIn" id="p3" data-panel-color="false" data-panel-remove="false" data-panel-title="false" data-panel-collapse="false">
                                            <div class="panel-heading">
                                                <span class="panel-title">Support</span>
                                            <span class="panel-controls"><a href="#" class="panel-control-loader"></a><a href="#" class="panel-control-fullscreen"></a></span></div>
                                            <div class="panel-body">
                                                <p><div align="center">Email: <a href="mailto:<?php echo $settings['email']; ?>"><?php echo $settings['email']; ?> </a></p>
                                            </div>
                                            </div>
<div class="panel mb50 sort-disable" data-animate="fadeIn" id="p3" data-panel-color="false" data-panel-remove="false" data-panel-title="false" data-panel-collapse="false">
                                            <div class="panel-heading">
                                                <span class="panel-title">Terms of Service</span>
                                            <span class="panel-controls"><a href="#" class="panel-control-loader"></a><a href="#" class="panel-control-fullscreen"></a></span></div>
                                            <div class="panel-body">
                                                <p> <?php echo $settings['tos']; ?> </p>
                                            </div>
                                        </div>

</div>
                </div>

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
<div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div>
</body></html>
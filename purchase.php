<?php
error_reporting (E_ALL ^ E_NOTICE); /* 1st line (recommended) */

include 'db.php';
include 'dbc.php';

page_protect();

$result = mysqli_query($con, "SELECT * FROM `settings`");
$settings = mysqli_fetch_array($result);

$host  = $_SERVER['HTTP_HOST'];
$path   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');

?>
<html><head>
    
    <meta charset="utf-8">
    <title><?php echo $settings['title']; ?> - Purchase</title>
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
                    <li class="active">
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
if($_GET['action'] == 'completed'){
echo "<div class=\"alert alert-success alert-dismissable\">
<button type='button' class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"fa fa-check pr10\"></i><strong>Well done! </strong>You have upgraded your account. Please log out and sign back in for changes to take effect. Click <a href='logout.php'>here</a> to do so.</div>";
}
?>
        <div class="row">

<div class="panel mb50 sort-disable" data-animate="fadeIn" id="p3" data-panel-color="false" data-panel-remove="false" data-panel-title="false" data-panel-collapse="false">
                                            <div class="panel-heading">
                                                <span class="panel-title">Price</span>
                                            <span class="panel-controls"><a href="#" class="panel-control-loader"></a><a href="#" class="panel-control-fullscreen"></a></span></div>
                                            <div class="panel-body">
                                                <p> <div align="center">Lifetime Price $<?php echo $settings['price']; ?> </p>
                                            </div>
                                            </div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_xclick">
  <input name="notify_url" value="<?php echo "http://$host$path/ipn.php"; ?>" type="hidden">
  <input name="return" value="<?php echo "http://$host$path/purchase.php?action=completed"; ?>" type="hidden">
  <input type="hidden" name="business" value="<?php echo $settings['email']; ?>">
  <input type="hidden" name="lc" value="US">
  <input type="hidden" name="item_name" value="Upgrade">
  <input type="hidden" name="amount" value="<?php echo $settings['price']; ?>">
  <input type="hidden" name="currency_code" value="USD">
  <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
  <input type="hidden" name="custom" value="<?php echo $_SESSION['user_id']; ?>">
  <input type="submit" class="btn btn-lg btn-info btn-block" value="Purchase Using PayPal">
</form>
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
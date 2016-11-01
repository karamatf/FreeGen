<?php
error_reporting (E_ALL ^ E_NOTICE); /* 1st line (recommended) */

include 'db.php';
include 'dbc.php';

page_protect();

if(!checkAdmin()) {
header("Location: login.php");
exit();
}

$result = mysqli_query($con, "SELECT * FROM `settings`");
$settings = mysqli_fetch_array($result);

$types1 = preg_split("/,/", $settings['types']); 

foreach ($types1 as $types2){ 

$types3 .= "<option value=\"$types2\">$types2</option>";

}
if(checkAdmin()){
if(!empty($_POST['add-single'] == "Add Account")){
$email = $_POST['email-single'];
$password = $_POST['password-single'];
$type = $_POST['type-single'];
$sql = "INSERT INTO accounts (email,password,type,bywho) VALUES ('$email','$password','$type','')";
if(!mysqli_query($con, $sql)){

$err = "There was an error adding the account to the server.";

        }
        else{

$msg = "Account has been uploaded to the server.";

}
}

if(!empty($_POST['add-bulk'] == "Add Accounts")){
$bulkadd = $_POST['email-pass'];
$bulktype = $_POST['type-bulk'];
foreach(preg_split('/[\r\n]+/', $bulkadd) as $bulksplit)
	{
        list($email, $password) = @split('[:]', $bulksplit);
        $sql = "Insert Into accounts(email,password,type,bywho) Values('$email','$password','$bulktype','')";
        
        if(!mysqli_query($con, $sql)){

$err = "There was an error adding the accounts to the server.";

        }
        else{

$msg = "Accounts have been uploaded to the server.";

}

	} 
}
}

?>
<html><head>
    
    <meta charset="utf-8">
    <title><?php echo $settings['title']; ?> - Add Accounts</title>
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
                            <li class="active">
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
<button type='button' class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"fa fa-check pr10\"></i><strong>Well done! </strong>$msg</div>";
}
if(!empty($err)){
echo "<div class=\"alert alert-danger alert-dismissable\">
<button type='button' class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><i class=\"fa fa-remove pr10\"></i><strong>Snap! </strong>$err</div>";
}

?>
<div class="row">

                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title">Add Account</span>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post">
                                    
                                    <div class="ph30">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Email / Username" name="email-single">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-key"></i>
                                                </span>
                                                <input class="form-control" type="text" placeholder="Password" name="password-single">
                                            </div>
                                        </div>
<span class="help-block mt5"><i class="fa fa-bell"></i> Reminder: Please select an Account Type from below before clicking Add Account</span>
<div class="tab-content pn br-n admin-form"><label for="product-category" class="field select">
                                                <select id="product-category" name="type-single" class="empty">
                                                    
<?php

    echo $types3;										
?>
                                                    
                                                    
                                                </select>
                                                <i class="arrow"></i>
  </label></div>

<br><input class="btn btn-primary" type="submit" value="Add Account" name="add-single">
 
                                        
                                        
                                    </div>

                                </form>
                            </div>
                        </div>


                    </div>

<div class="col-md-6">

                        

                        

                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title">Add Accounts</span>
                            </div>
                            <div class="panel-body">
                                <form class="form-horizontal" role="form" method="post">
                                    
                                    <div class="ph30">
                                        <div class="form-group">
                                        
                                        <textarea class="form-control textarea-grow" rows="4" name="email-pass"></textarea>
</div>
<span class="help-block mt5"><i class="fa fa-bell"></i> Use the 'email:pass' format when adding accounts to the list</span>
<span class="help-block mt5"><i class="fa fa-bell"></i> Reminder: Please select an Account Type from below before clicking Add Accounts</span>
<div class="tab-content pn br-n admin-form"><label for="product-category" class="field select">
                                                <select id="product-category" name="type-bulk" class="empty">
                                                    
<?php

    echo $types3;										
?>
                                                    
                                                   
                                                </select>
                                                <i class="arrow"></i>
  </label></div>

<br><input class="btn btn-primary" type="submit" value="Add Accounts" name="add-bulk">
 
                                        
                                        
                                    </div>

                                </form>
                            </div>
                        </div>              
                    </div>                   
                </div>
            </section>
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
    




<div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div><div class="jvectormap-label"></div></body></html>
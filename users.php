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

foreach($_POST as $key => $value) {
	$post[$key] = filter($value);
}
if(checkAdmin()){
if($post['doBan'] == 'Ban Selected') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
$sql = "UPDATE users SET banned='1' WHERE id='$id' AND `user_name` <> 'admin'";
mysqli_query($con, $sql);
	}
 }
}

if($_POST['doUnban'] == 'Unban Selected') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
$sql = "UPDATE users SET banned='0' WHERE id='$id'";
mysqli_query($con, $sql);
	}
 }

}

if($_POST['doNormal'] == 'Set Normal') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
$sql = "UPDATE users SET user_level='1' WHERE id='$id'";
mysqli_query($con, $sql);
	}
 }
}

if($_POST['doPaid'] == 'Set Paid') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
$sql = "UPDATE users SET user_level='3' WHERE id='$id'";
mysqli_query($con, $sql);
	}
 }

}

if($_POST['doAdmin'] == 'Set Admin') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
$sql = "UPDATE users SET user_level='5' WHERE id='$id'";
mysqli_query($con, $sql);
	}
 }

}

if($_POST['doDelete'] == 'Delete Selected') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
$sql = "DELETE FROM users WHERE id='$id' AND `user_name` <> 'admin'";
mysqli_query($con, $sql);

	}
 }

}

if($_POST['doApprove'] == 'Approve') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);

$sql = "UPDATE users SET approved='1' where id='$id'";
mysqi_query($con, $sql);
			 
	}
 }
 
}
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?php echo $settings['title']; ?> - Manage Users</title>
    <meta name="keywords" content="" />
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">
    <link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/media/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="vendor/plugins/datatables/extensions/Editor/css/dataTables.editor.css">
<link rel="stylesheet" type="text/css" href="assets/admin-tools/admin-forms/css/admin-forms.css">
    <link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">
    <link rel="shortcut icon" href="assets/img/favicon.ico">
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">
</head>

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
                            <li class="active">
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
                       <form action="users.php" method="post">
					   
                        <div class="col-md-12">
                            <div class="panel panel-visible" id="spy2">
                                <div class="panel-heading">
                                    <div class="panel-title hidden-xs">
                                        <span class="glyphicon glyphicon-tasks"></span>Accounts</div>
                                </div>
                                <div class="panel-body pn">
                                    <table class="table table-striped table-hover" id="datatable2" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Date</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>User Level</th>
                                                <th>Banned</th>
                                           </tr>
                                        </thead>
                                        <tbody>
                                            
<?php
$user_get = $_GET['user'];
if(!empty($_GET['user'])){
$query = "SELECT * FROM users WHERE user_name='$user_get'";
}
else{
$query = "SELECT * FROM users";
}
$result = mysqli_query($con, $query);
while($rows = mysqli_fetch_array($result))
{
$id = $rows['id'];
$date = $rows['date'];
$user_name = $rows['user_name'];
$user_email = $rows['user_email'];
$user_level = $rows['user_level'];
if($user_level == '1'){
$user_level = "User";
}
if($user_level == '3'){
$user_level = "Paid";
}
if($user_level == '5'){
$user_level = "Admin";
}
$banned = $rows['banned'];
if($banned == '0'){
$banned = "No";
}
else
{
$banned = "Yes";
}

echo "<tr>";
echo "
<td class=\"text-center\"><label class=\"option block mn\"><input type=\"checkbox\" id='u[]' name='u[]' value=\"$id\"><span class=\"checkbox mn\"></span></label>
</td>
";
echo "<td> <input type='hidden' name='date' value='" . $rows['date'] . "'>$date</input> </td>";
echo "<td> <input type='hidden' name='username' value='" . $rows['user_name'] . "'>$user_name</input> </td>";
echo "<td> <input type = 'hidden' name='email' value='" . $rows['user_email'] . "'>$user_email</input> </td>";
echo "<td> <input type='hidden' name='level' value='" . $user_level . "'>$user_level</input> </td>";
echo "<td> <input type='hidden' name='type' value='" . $banned . "'>$banned</input> </td>";
echo "</tr>";
}
?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
<div class="col-adjust-8 mb30">
                    
                    <div class="row">                 
<div class="col-xs-2">
<input type="submit" name="doBan" value="Ban Selected" class="btn btn-hover btn-warning btn-block">
</div>
<div class="col-xs-2">
<input type="submit" name="doUnban" value="Unban Selected" class="btn btn-hover btn-warning btn-block">
                        </div>
<div class="col-xs-2">
<input type="submit" name="doNormal" value="Set Normal" class="btn btn-hover btn-info btn-block">
                        </div>
<div class="col-xs-2">
<input type="submit" name="doPaid" value="Set Paid" class="btn btn-hover btn-info btn-block">
                        </div>
<div class="col-xs-2">
<input name="doAdmin" value="Set Admin" type="submit" class="btn btn-hover btn-info btn-block">
                        </div>
<div class="col-xs-2">
<input name="doDelete" value="Delete Selected" type="submit" class="btn btn-hover btn-danger btn-block">
                        </div>
                    </div>

                </div>
			
						</form>
					
                    </div>
            </section>
        </section>
        <aside id="sidebar_right" class="nano">
            <div class="sidebar_right_content nano-content">
                <div class="tab-block sidebar-block br-n">
                    <ul class="nav nav-tabs tabs-border nav-justified hidden">
                        <li class="active">
                            <a href="#sidebar-right-tab1" data-toggle="tab">Tab 1</a>
                        </li>
                        <li>
                            <a href="#sidebar-right-tab2" data-toggle="tab">Tab 2</a>
                        </li>
                        <li>
                            <a href="#sidebar-right-tab3" data-toggle="tab">Tab 3</a>
                        </li>
                    </ul>
                    <div class="tab-content br-n">
                        <div id="sidebar-right-tab1" class="tab-pane active">

                            <h5 class="title-divider text-muted mb20"> Server Statistics <span class="pull-right"> 2013 <i class="fa fa-caret-down ml5"></i> </span> </h5>
                            <div class="progress mh5">
                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 44%">
                                    <span class="fs11">DB Request</span>
                                </div>
                            </div>
                            <div class="progress mh5">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 84%">
                                    <span class="fs11 text-left">Server Load</span>
                                </div>
                            </div>
                            <div class="progress mh5">
                                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 61%">
                                    <span class="fs11 text-left">Server Connections</span>
                                </div>
                            </div>

                            <h5 class="title-divider text-muted mt30 mb10">Traffic Margins</h5>
                            <div class="row">
                                <div class="col-xs-5">
                                    <h3 class="text-primary mn pl5">132</h3>
                                </div>
                                <div class="col-xs-7 text-right">
                                    <h3 class="text-success-dark mn"> <i class="fa fa-caret-up"></i> 13.2% </h3>
                                </div>
                            </div>

                            <h5 class="title-divider text-muted mt25 mb10">Database Request</h5>
                            <div class="row">
                                <div class="col-xs-5">
                                    <h3 class="text-primary mn pl5">212</h3>
                                </div>
                                <div class="col-xs-7 text-right">
                                    <h3 class="text-success-dark mn"> <i class="fa fa-caret-up"></i> 25.6% </h3>
                                </div>
                            </div>

                            <h5 class="title-divider text-muted mt25 mb10">Server Response</h5>
                            <div class="row">
                                <div class="col-xs-5">
                                    <h3 class="text-primary mn pl5">82.5</h3>
                                </div>
                                <div class="col-xs-7 text-right">
                                    <h3 class="text-danger mn"> <i class="fa fa-caret-down"></i> 17.9% </h3>
                                </div>
                            </div>

                            <h5 class="title-divider text-muted mt40 mb20"> Server Statistics <span class="pull-right text-primary fw600">USA</span> </h5>
                            <div id="sidebar-right-map" class="hide-jzoom" style="width: 100%; height: 180px;"></div>

                        </div>
                        <div id="sidebar-right-tab2" class="tab-pane"></div>
                        <div id="sidebar-right-tab3" class="tab-pane"></div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</body>

</html>

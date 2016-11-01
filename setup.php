<?php
error_reporting (E_ALL ^ E_NOTICE); /* 1st line (recommended) */

include 'db.php';
// Check connection

if(!empty($_POST['doSetup'])){

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Create table
$sql = "CREATE TABLE accounts
(
id INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(id),
email varchar(300) NOT NULL,
password varchar(300) NOT NULL,
type varchar(200)NOT NULL,
used varchar(200)NOT NULL default '0',
bywho varchar(200)NOT NULL)";

if (mysqli_query($con, $sql)) {
    $msg .= "Table for accounts have been successfully made.<br>";
} else {
$msg .= "Table for accounts has already been created, it's ready to use.<br>";
}

$sql = "CREATE TABLE users
(
id INT NOT NULL AUTO_INCREMENT,
PRIMARY KEY(id),
md5_id varchar(200) CHARACTER SET latin1 collate latin1_general_ci NOT NULL,
full_name varchar(200) CHARACTER SET latin1 collate latin1_general_ci NOT NULL,
user_name varchar(200) CHARACTER SET latin1 collate latin1_general_ci NOT NULL,
user_email varchar(220) CHARACTER SET latin1 collate latin1_general_ci NOT NULL,
user_level tinyint(4) NOT NULL default '1',
pwd varchar(220) CHARACTER SET latin1 collate latin1_general_ci NOT NULL,
date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
users_ip varchar(200) CHARACTER SET latin1 collate latin1_general_ci NOT NULL,
users_info varchar(200) CHARACTER SET latin1 collate latin1_general_ci NOT NULL,
approved int(1) NOT NULL default '0',
activation_code int(10) NOT NULL default '0',
banned int(1) NOT NULL default '0',
ckey varchar(220) CHARACTER SET latin1 collate latin1_general_ci NOT NULL,
ctime varchar(220) CHARACTER SET latin1 collate latin1_general_ci NOT NULL,
UNIQUE KEY user_email (user_email),
FULLTEXT KEY idx_search (user_email,user_name)
)
ENGINE=MyISAM;";

if (mysqli_query($con, $sql)) {
    $msg .=  "Table for login has been created successfully.<br>";
} else {
$msg .= "Table for login has already been created, it's ready to use .<br>";
}

$sql = "INSERT INTO `users`(`id`, `md5_id`, `full_name`, `user_name`, `user_email`, `user_level`, `pwd`, `date`, `users_ip`,`users_info`,`approved`, `activation_code`, `banned`, `ckey`, `ctime`) VALUES (2, '', 'Admin', 'admin', 'admin@localhost', 5, '4c09e75fa6fe36038ac240e9e4e0126cedef6d8c85cf0a1ae', '1000-01-01 00:00:00', '', '', 1, 0, 0, 'uqd1y4v', '1272992243');";

if (mysqli_query($con, $sql)) {
    $msg .=  "Login account has been created successfully. <br>Username = admin<br>Password = admin123<br>";
} else {
$msg .=  "Login account has already been created, it's ready to use. <br>Username = admin<br>Password = admin123<br>";
}

$sql = "CREATE TABLE settings
(
title varchar(200)NOT NULL,
email varchar(300)NOT NULL,
types varchar(1000)NOT NULL,
tos varchar(2000)NOT NULL,
price int(10)NOT NULL)";

if (mysqli_query($con, $sql)) {
    $msg .=  "You have successfully created the table to set up the website settings.<br>";
} else {
$msg .=  "You have already done the table creation of the website settings.<br>";
}

$types = $_POST['hidden-undefined'];
$title = $_POST['title'];
$email = $_POST['paypalemail'];
$tos   = $_POST['tos'];
$price = $_POST['lifetime'];

$sql = "INSERT INTO `settings`(`title`,`email`,`types`,`tos`,`price`) VALUES ('$title','$email','$types','$tos','$price');";

if (mysqli_query($con, $sql)) {
    $msg .=  "You have successfully created the settings to set up the website.<br>";
} else {
$msg .=  "You have already done the created the website settings.<br>";
}

}

?>

<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>Generator Setup</title>
    <meta name="keywords" content="HTML5 Bootstrap 3 Admin Template UI Theme" />
    <meta name="description" content="AdminDesigns - SHARED ON THEMELOCK.COM">
    <meta name="author" content="AdminDesigns">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font CSS (Via CDN) -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">

    <!-- Required Plugin CSS -->
    <link rel="stylesheet" type="text/css" href="assets/js/utility/highlight/styles/googlecode.css">

    <!-- Required Plugin CSS -->
    <link rel="stylesheet" type="text/css" href="vendor/plugins/datepicker/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/plugins/daterange/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="vendor/plugins/colorpicker/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" type="text/css" href="vendor/plugins/tagmanager/tagmanager.css">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/skin/default_skin/css/theme.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body class="form-input-page">

    <!-- Start: Main -->
    <div id="main">


        <!-- Start: Content-Wrapper -->
        <section id="content_wrapper">


            <!-- Begin: Content -->
            <div id="content" class="animated fadeIn">
<?php

if(!empty($msg)){

echo "<div class=\"alert .alert-micro alert-primary alert-dismissable\">
<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>
$msg<br>Now go to your root directory <a href='index.php'>here</a> to start using your website, and please delete this Setup file though keep a backup saved on your PC somewhere. Thanks.</div>";


}

?>
                <div class="row">
<form class="form-horizontal" role="form" action="setup.php" method="post">
                    <div class="col-md-6">

                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title">Settings</span>
                            </div>
                            <div class="panel-body">
                                

                                    <div class="form-group">
                                        <label for="title" class="col-lg-3 control-label">Title</label>
                                        <div class="col-lg-8">
                                            <input type="text" id="title" name="title" class="form-control" required="" placeholder="Type Here...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="paypalemail" class="col-lg-3 control-label">PayPal Email</label>
                                        <div class="col-lg-8">
                                            <input type="text" id="paypalemail" name="paypalemail" class="form-control" required="" placeholder="Type Here...">
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label for="lifetime" class="col-lg-3 control-label">Lifetime Price</label>
                                        <div class="col-lg-8">
                                            <input type="number" name="lifetime" id="lifetime" class="form-control" required="" placeholder="Type Here...">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tos" class="col-lg-3 control-label">Terms of Service</label>
                                        <div class="col-lg-8">
                                            <textarea class="form-control textarea-grow" rows="9" name="tos" required="" placeholder="Type Here..."></textarea>
                                        </div>

                                    </div>     
<span class="help-block mt5"><i class="fa fa-bell"></i> Reminder: Use "< b r >" (no spaces) for line break.</span>                          
                            </div>
                        </div>

                        

                        

                        

                        

                        
                        
<label>If you have already set this up, do not repeat. Delete this file after setup to avoid ANYTHING going wrong.</label>
                        
                        

                        <input type="submit" name="doSetup" value="Setup" class="btn btn-lg btn-info btn-block">
                        

                    </div>

                    <div class="col-md-6">

            
                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title">Account Types</span>
                            </div>
                            <div class="panel-body">
                                
                                    <div class="form-group mbn">
                                        <label for="tagmanager" class="col-md-2 control-label">Types</label>
                                        <div class="col-md-10">
                                            <input type="text" id="tagmanager" class="form-control tm-input" placeholder="Create a new tag..">
                                            <div class="tag-container tags"></div>
                                        </div>
                                    </div>
                             
                            </div>
                        </div>
                    </div>
</form>
                </div>

            </div>
            <!-- End: Content -->
            
        </section>
        <!-- End: Content-Wrapper -->

        <!-- Start: Right Sidebar -->
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
                    <!-- end: .tab-content -->
                </div>
            </div>
        </aside>
        <!-- End: Right Sidebar -->

    </div>
    <!-- End: Main -->

    <!-- Google Map API -->
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>

    <!-- jQuery -->
    <script type="text/javascript" src="vendor/jquery/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>

    <!-- Bootstrap -->
    <script type="text/javascript" src="assets/js/bootstrap/bootstrap.min.js"></script>

    <!-- Page Plugins via CDN -->
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/globalize/0.1.1/globalize.min.js"></script>
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.3/moment.js"></script>

    <!-- via local files 
    <script type="text/javascript" src="vendor/plugins/globalize/src/core.js"></script>
    <script type="text/javascript" src="vendor/plugins/moment/moment.min.js"></script> -->

    <!-- Page Plugins -->
    <script type="text/javascript" src="vendor/plugins/daterange/daterangepicker.js"></script>
    <script type="text/javascript" src="vendor/plugins/datepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="vendor/plugins/colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script type="text/javascript" src="vendor/plugins/jquerymask/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="vendor/plugins/tagmanager/tagmanager.js"></script>

    <!-- Theme Javascript -->
    <script type="text/javascript" src="assets/js/utility/utility.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
    <script type="text/javascript" src="assets/js/demo.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {

            "use strict";

            // Init Theme Core    
            Core.init();

            // Init Demo JS    
            Demo.init();

            // daterange plugin options
            var rangeOptions = {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                startDate: moment().subtract('days', 29),
                endDate: moment()
            }

            // Init daterange plugin
            $('#daterangepicker1').daterangepicker();

            // Init daterange plugin
            $('#daterangepicker2').daterangepicker(
                rangeOptions,
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
            );

            // Init daterange plugin
            $('#inline-daterange').daterangepicker(
                rangeOptions,
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
            );

            // Init datetimepicker - fields
            $('#datetimepicker1').datetimepicker();
            $('#datetimepicker2').datetimepicker();


            // Init datetimepicker - inline + range detection
            $('#datetimepicker3').datetimepicker({
                defaultDate: "9/4/2014",
                inline: true,
            });

            // Init datetimepicker - fields + Date disabled (only time picker)
            $('#datetimepicker5').datetimepicker({
                defaultDate: "9/25/2014",
                pickDate: false,
            });
            // Init datetimepicker - fields + Date disabled (only time picker)
            $('#datetimepicker6').datetimepicker({
                defaultDate: "9/25/2014",
                pickDate: false,
            });
            // Init datetimepicker - inline + Date disabled (only time picker)
            $('#datetimepicker7').datetimepicker({
                defaultDate: "9/25/2014",
                pickDate: false,
                inline: true
            });

            // Init colorpicker plugin
            $('#demo_apidemo').colorpicker({
                color: bgPrimary
            });
            $('.demo-auto').colorpicker();

            // Init jQuery Tags Manager 
            $(".tm-input").tagsManager({
                tagsContainer: '.tags',
                prefilled: [],
                tagClass: 'tm-tag-info',
            });

            // Init Boostrap Multiselect
            $('#multiselect1').multiselect();
            $('#multiselect2').multiselect({
                includeSelectAllOption: true
            });
            $('#multiselect3').multiselect();
            $('#multiselect4').multiselect({
                enableFiltering: true,
            });
            $('#multiselect5').multiselect({
                buttonClass: 'multiselect dropdown-toggle btn btn-default btn-primary'
            });
            $('#multiselect6').multiselect({
                buttonClass: 'multiselect dropdown-toggle btn btn-default btn-info'
            });
            $('#multiselect7').multiselect({
                buttonClass: 'multiselect dropdown-toggle btn btn-default btn-success'
            });
            $('#multiselect8').multiselect({
                buttonClass: 'multiselect dropdown-toggle btn btn-default btn-warning'
            });

            // Init jQuery spinner init - default
            $("#spinner1").spinner();

            // Init jQuery spinner init - currency 
            $("#spinner2").spinner({
                min: 5,
                max: 2500,
                step: 25,
                start: 1000,
                //numberFormat: "C"
            });

            // Init jQuery spinner init - decimal  
            $("#spinner3").spinner({
                step: 0.01,
                numberFormat: "n"
            });

            // jQuery Time Spinner settings
            $.widget("ui.timespinner", $.ui.spinner, {
                options: {
                    // seconds
                    step: 60 * 1000,
                    // hours
                    page: 60
                },
                _parse: function(value) {
                    if (typeof value === "string") {
                        // already a timestamp
                        if (Number(value) == value) {
                            return Number(value);
                        }
                        return +Globalize.parseDate(value);
                    }
                    return value;
                },

                _format: function(value) {
                    return Globalize.format(new Date(value), "t");
                }
            });
            // Init jQuery Time Spinner
            $("#spinner4").timespinner();


            // Init jQuery masked inputs
            $('.date').mask('99/99/9999');
            $('.time').mask('99:99:99');
            $('.date_time').mask('99/99/9999 99:99:99');
            $('.zip').mask('99999-999');
            $('.phone').mask('(999) 999-9999');
            $('.phoneext').mask("(999) 999-9999 x99999");
            $(".money").mask("999,999,999.999");
            $(".product").mask("999.999.999.999");
            $(".tin").mask("99-9999999");
            $(".ssn").mask("999-99-9999");
            $(".ip").mask("9ZZ.9ZZ.9ZZ.9ZZ");
            $(".eyescript").mask("~9.99 ~9.99 999");
            $(".custom").mask("9.99.999.9999");

        });
    </script>
</body>

</html>
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
if(!empty($_POST['doReset1'] == "Reset Selected")){
if(!empty($_POST['u'])) {
foreach ($_POST['u'] as $id) {
$sql = "UPDATE accounts SET used='0', bywho='' WHERE id='$id'";
if(!mysqli_query($con, $sql)){

$err = "There was an error while you tried to reset the selected accounts.";

        }
        else{

$msg = "Selected accounts have been reset.";

}
}
}
}

if(!empty($_POST['doReset2'] == "Reset All")){
$sql = "UPDATE accounts SET used='0', bywho=''";
if(!mysqli_query($con, $sql)){

$err = "There was an error while you tried to reset all accounts.";

        }
        else{

$msg = "All accounts have been reset.";

}
}

if(!empty($_POST['doReset3'] == "Reset Type")){
$type = $_POST['type-reset'];
$sql = "UPDATE accounts SET used='0', bywho='' WHERE type='$type'";
if(!mysqli_query($con, $sql)){

$err = "There was an error while you tried to reset the selected accounts.";

        }
        else{

$msg = "$type accounts have been reset.";

}
}

if(!empty($_POST['doDelete1'] == "Delete Selected")){
if(!empty($_POST['u'])) {
foreach ($_POST['u'] as $id) {
$sql = "DELETE FROM accounts WHERE id='$id'";
if(!mysqli_query($con, $sql)){

$err = "There was an error while you tried to delete the selected accounts.";

        }
        else{

$msg = "Selected accounts have been deleted.";

}
}
}
}

if(!empty($_POST['doDelete2'] == "Delete All")){
$sql = "DELETE FROM accounts";
if(!mysqli_query($con, $sql)){

$err = "There was an error while you tried to delete accounts.";

        }
        else{

$msg = "All accounts have been deleted.";

}
}

if(!empty($_POST['doDelete3'] == "Delete Type")){
$type = $_POST['type-delete'];
$sql = "DELETE FROM accounts WHERE type='$type'";
if(!mysqli_query($con, $sql)){

$err = "There was an error while you tried to delete the selected accounts.";

        }
        else{

$msg = "$type accounts have been deleted.";

}
}
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?php echo $settings['title']; ?> - Manage Accounts</title>
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
                            <li class="active">
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
                       <form action="accounts.php" method="post">
					   
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
                                                <th>Email</th>
                                                <th>Password</th>
                                                <th>Type</th>
                                                <th>Used</th>
                                                <th>Used By</th>
                                           </tr>
                                        </thead>
                                        <tbody>
<?php
$query = "SELECT * FROM accounts";
$result = mysqli_query($con, $query);
while($rows = mysqli_fetch_array($result))
{
$id = $rows['id'];
$type = $rows['type'];
$bywho = $rows['bywho'];
$email = $rows['email'];
$pass = $rows['password'];
echo "<tr>";
echo "
<td class=\"text-center\"><label class=\"option block mn\"><input type=\"checkbox\" id='u[]' name='u[]' value=\"$id\"><span class=\"checkbox mn\"></span></label>
</td>
";
echo "<td> <input type='hidden' name='email' value='" . $rows['email'] . "'>$email</input> </td>";
echo "<td> <input type = 'hidden' name='pass' value='" . $rows['password'] . "'>$pass</input> </td>";
echo "<td> <input type='hidden' name='type' value='" . $rows['type'] . "'>$type</input> </td>";
if($rows['used']=="1"){
$usedorno = "Yes";
}
else{
$usedorno = "No";
}
echo "<td> <input type='hidden' name='type' value='" . $usedorno . "'>$usedorno</input> </td>";
echo "<td> <input type='hidden' name='type' value='" . $rows['bywho'] . "'><a href='users.php?user=$bywho'>$bywho</a></input> </td>";
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
<div class="col-xs-3">
<input type="submit" name="doReset1" value="Reset Selected" class="btn btn-hover btn-warning btn-block">
</div>
<div class="col-xs-3">
<input type="submit" name="doReset2" value="Reset All" class="btn btn-hover btn-warning btn-block">
                        </div>
<div class="col-xs-3">
                            <input type="submit" name="doDelete1" value="Delete Selected" class="btn btn-hover btn-danger btn-block">
                        </div><div class="col-xs-3">
                            <input type="submit" name="doDelete2" value="Delete All" class="btn btn-hover btn-danger btn-block">
                        </div>
                    </div>
                    <div class="row mt20">
<div class="col-xs-3">
                            <div class="tab-content pn br-n admin-form"><label for="product-category" class="field select">
                                                
												<select id="product-category" name="type-reset" class="empty">
                                                    
<?php
    echo $types3;										
?>
												</select>
                                                <i class="arrow"></i></label></div>
                        </div><div class="col-xs-3">
                            <input name="doReset3" value="Reset Type" type="submit" class="btn btn-hover btn-warning btn-block">
                        </div>
<div class="col-xs-3">
                            <div class="tab-content pn br-n admin-form"><label for="product-category" class="field select">
												<select id="product-category" name="type-delete" class="empty">
<?php
    echo $types3;										
?>
												</select>
                                                <i class="arrow"></i></label></div>
                        </div><div class="col-xs-3">
                            <input name="doDelete3" value="Delete Type" type="submit" class="btn btn-hover btn-danger btn-block">
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
    <style>
    
    /*demo styles*/
    body {
        
    }
    .custom-nav-animation li {
        display: none;
    }
    .custom-nav-animation li.animated {
        display: block;
    }
    
    /* nav fixed settings */
    ul.tray-nav.affix {
        width: 319px;
        top: 80px;
    }
    </style>

    <!-- BEGIN: PAGE SCRIPTS -->

    <!-- jQuery -->
    <script type="text/javascript" src="vendor/jquery/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="vendor/jquery/jquery_ui/jquery-ui.min.js"></script>

    <!-- Bootstrap -->
    <script type="text/javascript" src="assets/js/bootstrap/bootstrap.min.js"></script>

    <!-- Datatables -->
    <script type="text/javascript" src="vendor/plugins/datatables/media/js/jquery.dataTables.js"></script>

    <!-- Datatables Tabletools addon -->
    <script type="text/javascript" src="vendor/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>

    <!-- Datatables Editor addon - READ LICENSING NOT MIT  -->
    <script type="text/javascript" src="vendor/plugins/datatables/extensions/Editor/js/dataTables.editor.js"></script>

    <!-- Datatables Bootstrap Modifications  -->
    <script type="text/javascript" src="vendor/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="vendor/plugins/datatables/extensions/Editor/js/editor.bootstrap.js"></script>

    <!-- Theme Javascript -->
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

            // Init tray navigation smooth scroll
            $('.tray-nav a').smoothScroll({
                offset: -145
            });

            // Custom tray navigation animation
            setTimeout(function() {
                $('.custom-nav-animation li').each(function(i, e) {
                    var This = $(this);
                    var timer = setTimeout(function() {
                        This.addClass('animated zoomIn');
                    }, 100 * i);
                });
            }, 600);


           // Init Datatables with Tabletools Addon    
            $('#datatable').dataTable({
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [-1]
                }],
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "",
                        "sNext": ""
                    }
                },
                "iDisplayLength": 5,
                "aLengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "sDom": 't<"dt-panelfooter clearfix"ip>',
                "oTableTools": {
                    "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
                }
            });

            $('#datatable2').dataTable({
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [-1]
                }],
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "",
                        "sNext": ""
                    }
                },
                "iDisplayLength": 5,
                "aLengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "sDom": '<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
                "oTableTools": {
                    "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
                }
            });

            $('#datatable3').dataTable({
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [-1]
                }],
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "",
                        "sNext": ""
                    }
                },
                "iDisplayLength": 5,
                "aLengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "sDom": '<"dt-panelmenu clearfix"Tfr>t<"dt-panelfooter clearfix"ip>',
                "oTableTools": {
                    "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
                }
            });

            $('#datatable4').dataTable({
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [-1]
                }],
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": "",
                        "sNext": ""
                    }
                },
                "iDisplayLength": 5,
                "aLengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                "sDom": 'T<"panel-menu dt-panelmenu"lfr><"clearfix">tip',

                "oTableTools": {
                    "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
                }
            });

            // Multi-Column Filtering
            $('#datatable5 thead th').each(function() {
                var title = $('#datatable5 tfoot th').eq($(this).index()).text();
                $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" />');
            });

            // DataTable
            var table5 = $('#datatable5').DataTable({
                "sDom": 't<"dt-panelfooter clearfix"ip>',
                "ordering": false
            });

            // Apply the search
            table5.columns().eq(0).each(function(colIdx) {
                $('input', table5.column(colIdx).header()).on('keyup change', function() {
                    table5
                        .column(colIdx)
                        .search(this.value)
                        .draw();
                });
            });


            // ABC FILTERING
            var table6 = $('#datatable6').DataTable({
                "sDom": 't<"dt-panelfooter clearfix"ip>',
                "ordering": false
            });

            var alphabet = $('<div class="dt-abc-filter"/>').append('<span class="abc-label">Search: </span> ');
            var columnData = table6.column(0).data();
            var bins = bin(columnData);

            $('<span class="active"/>')
                .data('letter', '')
                .data('match-count', columnData.length)
                .html('None')
                .appendTo(alphabet);

            for (var i = 0; i < 26; i++) {
                var letter = String.fromCharCode(65 + i);

                $('<span/>')
                    .data('letter', letter)
                    .data('match-count', bins[letter] || 0)
                    .addClass(!bins[letter] ? 'empty' : '')
                    .html(letter)
                    .appendTo(alphabet);
            }

            $('#datatable6').parents('.panel').find('.panel-menu').addClass('dark').html(alphabet);

            alphabet.on('click', 'span', function() {
                alphabet.find('.active').removeClass('active');
                $(this).addClass('active');

                _alphabetSearch = $(this).data('letter');
                table6.draw();
            });

            var info = $('<div class="alphabetInfo"></div>')
                .appendTo(alphabet);

            var _alphabetSearch = '';

            $.fn.dataTable.ext.search.push(function(settings, searchData) {
                if (!_alphabetSearch) {
                    return true;
                }
                if (searchData[0].charAt(0) === _alphabetSearch) {
                    return true;
                }
                return false;
            });

            function bin(data) {
                var letter, bins = {};
                for (var i = 0, ien = data.length; i < ien; i++) {
                    letter = data[i].charAt(0).toUpperCase();

                    if (bins[letter]) {
                        bins[letter] ++;
                    } else {
                        bins[letter] = 1;
                    }
                }
                return bins;
            }

            // ROW GROUPING
            var table7 = $('#datatable7').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "sDom": 't<"dt-panelfooter clearfix"ip>',
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;

                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="row-label ' + group.replace(/ /g, '').toLowerCase() + '"><td colspan="5">' + group + '</td></tr>'
                            );
                            last = group;
                        }
                    });
                }
            });

            // Order by the grouping
            $('#datatable7 tbody').on('click', 'tr.row-label', function() {
                var currentOrder = table7.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table7.order([2, 'desc']).draw();
                } else {
                    table7.order([2, 'asc']).draw();
                }
            });


            // MISC DATATABLE HELPER FUNCTIONS

            // Add Placeholder text to datatables filter bar
            $('.dataTables_filter input').attr("placeholder", "Enter Terms...");

        });
    </script>
</body>

</html>

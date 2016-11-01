<?php

include 'db.php';
include 'dbc.php';

$result = mysqli_query($con, "SELECT * FROM `settings`");
$settings = mysqli_fetch_array($result);

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

    
    <script>
    var boxtest = localStorage.getItem('boxed');
    if (boxtest === 'true') {
        document.body.className += ' boxed-layout';
    }
    </script>
    

    
    <div id="main" class="animated fadeIn">

        
        <section id="content_wrapper">

            
            <div id="canvas-wrapper">
                <canvas id="demo-canvas"></canvas>
            </div>

            
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
                                <a href="register.php" title="Register">Register</a>
                            </div>

                        </div>

                    </div>

                    <div class="panel panel-info mt10 br-n">

                        <div class="panel-heading heading-border bg-white">
 
                        </div>

                        <form method="post" action="register.php">
                            <div class="panel-body p25 bg-light">
                                <div class="section-divider mt10 mb40">
                                    <span>Terms of Service</span>
                                </div>                                                            
                                <div class="section">
                                    
                                        <?php echo $settings['tos']; ?>
                                  
                                </div>
                       </div>                          
                    </div>
                </div>

            </section>

        </section>

    </div>




</body></html>
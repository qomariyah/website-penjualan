<?php
    session_start();
    include ("../conn/connection.php");

    $nama = $_SESSION['username'];

    if (empty($nama)) {
        header('location:login.php');
    }
?>

<!DOCTYPE html>
<html class="backend">
    <!-- START Head -->
    <head>
        <!-- START META SECTION -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Handmade's | Lamp Craft</title>
        <meta name="description" content="A place where you can find various handicraft products made from bottles.">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <!--/ END META SECTION -->

        <!-- START STYLESHEETS -->
        <!-- Plugins stylesheet : optional -->
        <link rel="stylesheet" href="../plugins/datatables/css/datatables.css">
        <link rel="stylesheet" href="../plugins/datatables/css/tabletools.css">
        <!--/ Plugins stylesheet : optional -->

        <!-- Application stylesheet : mandatory -->
        <link rel="stylesheet" href="../stylesheet/bootstrap.css">
        <link rel="stylesheet" href="../stylesheet/layout.css">
        <link rel="stylesheet" href="../stylesheet/uielement.css">
        <!--/ Application stylesheet -->

        <!-- Theme stylesheet : optional -->
        <link rel="stylesheet" href="../stylesheet/themes/layouts/fixed-header.css">
        <!--/ Theme stylesheet : optional -->

        <!-- modernizr script -->
        <script type="text/javascript" src="../plugins/modernizr/js/modernizr.js"></script>
        <!--/ modernizr script -->
        <!-- END STYLESHEETS -->
    </head>
    <!--/ END Head -->

    <!-- START Body -->
    <body>
        <!-- START Template Header -->
        <header id="header" class="navbar">
            <!-- START navbar header -->
            <div class="navbar-header">
                <!-- Brand -->
                <a class="navbar-brand" href="#">
                    <span class="ico-lightbulb" style="color: #ffffff"></span>
                    <span class=""></span> <!-- class : logo-text -->
                </a>
                <!--/ Brand -->
            </div>
            <!--/ END navbar header -->

            <!-- START Toolbar -->
            <div class="navbar-toolbar clearfix">
                <!-- START Left nav -->
                <ul class="nav navbar-nav navbar-left">
                    <!-- Sidebar shrink -->
                    <li class="hidden-xs hidden-sm">
                        <a href="#" class="sidebar-minimize" data-toggle="minimize" title="Minimize sidebar">
                            <span class="meta">
                                <span class="icon"></span>
                            </span>
                        </a>
                    </li>
                    <!--/ Sidebar shrink -->

                    <!-- Offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
                    <li class="navbar-main hidden-lg hidden-md hidden-sm">
                        <a href="#" data-toggle="sidebar" data-direction="ltr" rel="tooltip" title="Menu sidebar">
                            <span class="meta">
                                <span class="icon"><i class="ico-paragraph-justify3"></i></span>
                            </span>
                        </a>
                    </li>
                    <!--/ Offcanvas left -->

                    <!-- Message dropdown -->
                    <?php

                        $date = date('Y-m-d');
                        $query = mysqli_query($koneksi, "SELECT * FROM tb_inbox where sudahbaca = 'N' ");
                        $hasil = mysqli_num_rows($query);
                   ?> 
                    <li class="dropdown custom" id="header-dd-message">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="meta">
                                <span class="icon"><i class="ico-bubbles3"></i></span>
                                <span class="badge badge-primary pull-right"><?php echo $hasil ?></span>
                            </span>
                        </a>

                        <!-- mustache template: used for update the `.media-list` requested from server-side -->
                        <script class="mustache-template" type="x-tmpl-mustache">
                        
                            {{#data}}
                            <a href="page-message-rich.html" class="media border-dotted new">
                                <span class="pull-left">
                                    <img src="../image/avatar/{{picture}}" class="media-object img-circle" alt="">
                                </span>
                                <span class="media-body">
                                    <span class="media-heading">{{name}}</span>
                                    <span class="media-text ellipsis nm">{{text}}</span>

                                    {{#meta.star}}<span class="media-meta"><i class="ico-star3"></i></span>{{/meta.star}}
                                    {{#meta.reply}}<span class="media-meta"><i class="ico-reply"></i></span>{{/meta.reply}}
                                    {{#meta.attachment}}<span class="media-meta"><i class="ico-attachment"></i></span>{{/meta.attachment}}
                                    <span class="media-meta pull-right">{{meta.time}}</span>
                                </span>
                            </a>
                            {{/data}}
                        
                        </script>
                        <!--/ mustache template -->

                        <!-- Dropdown menu -->
                        <div class="dropdown-menu" role="menu">
                            <div class="dropdown-header">
                                <span class="title">Messages <span class="count"></span></span>
                                <span class="option text-right"><a href="recent-message.php">View all messages</a></span>
                            </div>
                            <div class="dropdown-body slimscroll">

                                <!-- Message list -->
                                <div class="media-list">
                                <?php
                                    $date = date('Y-m-d');
                                    $query = mysqli_query($koneksi, "SELECT * FROM tb_inbox ORDER BY id_inbox desc LIMIT 10");
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($query)) {
                                ?>
                                    <a href="viewmessage.php?id=<?php echo $data['id_inbox']; ?>" class="media border-dotted read">
                                        <span class="pull-left">
                                            <img src="../image/avatar/avatar.png" class="media-object img-circle" alt="">
                                        </span>
                                        <span class="media-body">
                                            <span class="media-heading text-primary"><?php echo $data['nama_inbox']; ?></span>
                                            <span class="media-text ellipsis nm"><?php echo $data['pesan']; ?></span>
                                            <span class="media-meta pull-right"><?php echo $data['tgl_pesan']; ?></span>
                                        </span>
                                    </a>
                                    <?php
                                        $no++;
                                    }
                                    ?>
                                </div>
                                <!--/ Message list -->
                            </div>
                        </div>
                        <!--/ Dropdown menu -->
                    </li>
                    <!--/ Message dropdown -->

                    <!-- Notification dropdown -->
                    <li class="dropdown custom" id="header-dd-notification">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="meta">
                                <span class="icon"><i class="ico-bell"></i></span>
                                <span class="hasnotification hasnotification-danger"></span>
                            </span>
                        </a>

                        <!-- mustache template: used for update the `.media-list` requested from server-side -->
                        <script class="mustache-template" type="x-tmpl-mustache">
                        
                            {{#data}}
                            <a href="#" class="media border-dotted new">
                                <span class="media-object pull-left">
                                    <i class="{{icon}}"></i>
                                </span>
                                <span class="media-body">
                                    <span class="media-text">{{{text}}}</span>
                                    <span class="media-meta pull-right">{{meta.time}}</span>
                                </span>
                            </a>
                            {{/data}}
                        
                        </script>
                        <!--/ mustache template -->

                        <!-- Dropdown menu -->
                        <div class="dropdown-menu" role="menu">
                            <div class="dropdown-header">
                                <span class="title">Notification <span class="count"></span></span>
                                <span class="option text-right"><a href="#">Clear all</a></span>
                            </div>
                            <div class="dropdown-body slimscroll">
                                <!-- indicator -->
                                <div class="indicator inline"><span class="spinner spinner16"></span></div>
                                <!--/ indicator -->

                                <!-- Message list -->
                                <div class="media-list">
                                    
                                </div>
                                <!--/ Message list -->
                            </div>
                        </div>
                        <!--/ Dropdown menu -->
                    </li>
                    <!--/ Notification dropdown -->

                    <!-- Search form toggler  -->
                    <li>
                        <a href="#" data-toggle="dropdown" data-target="#dropdown-form">
                            <span class="meta">
                                <span class="icon"><i class="ico-search"></i></span>
                            </span>
                        </a>
                    </li>
                    <!--/ Search form toggler -->
                </ul>
                <!--/ END Left nav -->

                <!-- START navbar form -->
                <div class="navbar-form navbar-left dropdown" id="dropdown-form">
                    <form action="" role="search">
                        <div class="has-icon">
                            <input type="text" class="form-control" placeholder="Search application...">
                            <i class="ico-search form-control-icon"></i>
                        </div>
                    </form>
                </div>
                <!-- START navbar form -->

                <!-- START Right nav -->
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown messages-dropdown">
                        <a href="#"><i class="fa fa-calendar"></i>  <?php
                            date_default_timezone_set("Asia/Jakarta");
                            $Today=date('Y-M-d');
                            $new=date('l, F d, Y',strtotime($Today));
                            echo $new; ?></a>
                    </li>
                    <!-- Profile dropdown -->
                    <li class="dropdown profile">
                        <a href="#" class="dropdown-toggle dropdown-hover" data-toggle="dropdown">
                            <span class="meta">
                                <span class="avatar"><img src="../image/icons/supportservices.png" class="img-circle" alt="" /></span>
                                <span class="text hidden-xs hidden-sm pl5"><?php echo $_SESSION['username'];?></span>
                                <span class="caret"></span>
                            </span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="logout.php"><span class="icon"><i class="ico-exit"></i></span> Sign Out</a></li>
                        </ul>
                    </li>
                    <!-- Profile dropdown -->
                </ul>
                <!--/ END Right nav -->
            </div>
            <!--/ END Toolbar -->
        </header>
        <!--/ END Template Header -->

        <!-- START Template Sidebar (Left) -->
        <aside class="sidebar sidebar-left sidebar-menu">
            <!-- START Sidebar Content -->
            <section class="content slimscroll">
                <h5 class="heading">Main Menu</h5>
                <!-- START Template Navigation/Menu -->
                <ul class="topmenu topmenu-responsive" data-toggle="menu">
                    <li class="active open">
                        <a href="index.php" data-target="#dashboard">
                            <span class="figure"><i class="ico-dashboard2"></i></span>
                            <span class="text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin.php" data-target="#components">
                            <span class="figure"><i class="ico-user22"></i></span>
                            <span class="text">Admin</span>
                        </a>
                    </li>
                    <li>
                        <a href="member.php" data-toggle="submenu">
                            <span class="figure"><i class=" ico-users3"></i></span>
                            <span class="text">Member</span>
                        </a>
                    </li>
                    <li>
                        <a href="product.php" data-toggle="submenu">
                            <span class="figure"><i class="ico-table22"></i></span>
                            <span class="text">Product</span>
                        </a>
                    </li>
                    <li>
                        <a href="orders.php" data-toggle="submenu">
                            <span class="figure"><i class=" ico-cart3"></i></span>
                            <span class="text">Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="message.php" data-toggle="submenu" data-target="#chart" data-parent=".topmenu">
                            <span class="figure"><i class="ico-bubbles5"></i></span>
                            <span class="text">Messages</span>
                        </a>
                    </li>

                </ul>
                <!--/ END Template Navigation/Menu -->
            </section>
            <!--/ END Sidebar Container -->
        </aside>
        <!--/ END Template Sidebar (Left) -->

        <!-- START Template Main -->
        <section id="main" role="main">
            <!-- START Template Container -->
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="page-header page-header-block">
                    <div class="page-header-section">
                        <h4 class="title semibold">Dashboard</h4>
                    </div>
                    <div class="page-header-section">
                        <div class="toolbar">
                            <button class="btn btn-sm btn-primary" onclick="window.location.reload();"><span class=" ico-loop4"></span> Refresh</button>
                        </div>
                    </div>
                </div>
                <!-- Page Header -->

                <?php
                    include ("../conn/connection.php");

                    $date = date('Y-m-d');
                    $query = mysqli_query($koneksi, "SELECT * FROM tb_inbox ORDER BY id_inbox desc");
                    $no = 1;
                    while ($data = mysqli_fetch_array($query)) {
                ?>

                        <!-- START row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default animation delay animating fadeInUp">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><i class="ico-bubble11 text-primary mr5"></i> Message</h3>
                                        <div class="panel-toolbar text-right">
                                            <!-- option -->
                                            <div class="option">
                                                <button class="btn demo" data-toggle="panelrefresh"><i class="reload"></i></button>
                                                <button class="btn up" data-toggle="panelcollapse"><i class="arrow"></i></button>
                                            </div>
                                            <!--/ option -->
                                        </div>
                                    </div>
                                    <div class="panel-collapse pull out">
                                        <!-- panel body -->
                                        <div class="panel-body">
                                            <!-- sender detail -->
                                            <ul class="list-table">
                                                <li style="width:70px;">
                                                    <img class="img-circle" src="../image/avatar/avatar2.jpg" alt="" width="65px" height="65px">
                                                </li>
                                                <li class="text-left">
                                                    <h4 class="semibold ellipsis nm">
                                                        <?php echo $data['nama_inbox'];?> / 
                                                        <small class="text-muted"><a href="#"><?php echo $data['email_inbox'];?></a> to <a href="#">Handmade's Administrator</a></small>
                                                    </h4>
                                                </li>
                                                <li class="text-right">
                                                    <h5 class="semibold text-muted"><?php echo $data['tgl_pesan'];?></h5>
                                                </li>
                                            </ul>
                                            <!--/ sender detail -->
                                            <div class="panel-body">
                                                <blockquote class="mt15 mb15">
                                                    <p><?php echo $data['pesan'];?></p>
                                                </blockquote>
                                            </div>
                                        </div>
                                        <!--/ panel body -->
                                        <!-- panel footer -->
                                        <div class="panel-footer">
                                            <div class="panel-toolbar-wrapper">
                                                <div class="panel-toolbar text-right">
                                                    <a onclick="return confirm('Are you sure wanna delete this record?');" href="deletemessage.php?id=<?php echo $data['id_inbox']; ?>" class="btn btn-danger"><i class="ico-remove2"></i> Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- panel footer -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ END row -->
                    <?php
                        $no++;
                    }
                    ?>
            </div>
            <!--/ END Template Container -->

            <!-- START To Top Scroller -->
            <a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut" data-offset="50%"><i class="ico-angle-up"></i></a>
            <!--/ END To Top Scroller -->
        </section>
        <!--/ END Template Main -->


        <!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
        <!-- Application and vendor script : mandatory -->
        <script type="text/javascript" src="../javascript/vendor.js"></script>
        <script type="text/javascript" src="../javascript/core.js"></script>
        <script type="text/javascript" src="../javascript/backend/app.js"></script>
        <!--/ Application and vendor script : mandatory -->

        <!-- Plugins and page level script : optional -->
        <script type="text/javascript" src="../plugins/datatables/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../plugins/datatables/tabletools/js/dataTables.tableTools.js"></script>
        <script type="text/javascript" src="../plugins/datatables/js/datatables-bs3.js"></script>
        <script type="text/javascript" src="../javascript/backend/tables/datatable.js"></script>
        <!--/ Plugins and page level script : optional -->
        <!--/ END JAVASCRIPT SECTION -->
    </body>
    <!--/ END Body -->
</html>
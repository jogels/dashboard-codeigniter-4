<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>System Information Management OPS</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/components.css">
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        
                    </ul>
                   
                </form>
                <ul class="navbar-nav navbar-right">
                    <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Messages
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-message">
                                <a href="#" class="dropdown-item dropdown-item-unread">
                                    <div class="dropdown-item-avatar">
                                        <img alt="image" src="<?= base_url() ?>/template/assets/img/avatar/avatar-1.png" class="rounded-circle">
                                        <div class="is-online"></div>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>Kusnaedi</b>
                                        <p>Hello, Bro!</p>
                                        <div class="time">10 Hours Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item dropdown-item-unread">
                                    <div class="dropdown-item-avatar">
                                        <img alt="image" src="<?= base_url() ?>/template/assets/img/avatar/avatar-2.png" class="rounded-circle">
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>Dedik Sugiharto</b>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                                        <div class="time">12 Hours Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item dropdown-item-unread">
                                    <div class="dropdown-item-avatar">
                                        <img alt="image" src="<?= base_url() ?>/template/assets/img/avatar/avatar-3.png" class="rounded-circle">
                                        <div class="is-online"></div>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>Agung Ardiansyah</b>
                                        <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <div class="time">12 Hours Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-avatar">
                                        <img alt="image" src="<?= base_url() ?>/template/assets/img/avatar/avatar-4.png" class="rounded-circle">
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>Ardian Rahardiansyah</b>
                                        <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                                        <div class="time">16 Hours Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-avatar">
                                        <img alt="image" src="<?= base_url() ?>/template/assets/img/avatar/avatar-5.png" class="rounded-circle">
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>Alfa Zulkarnain</b>
                                        <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                                        <div class="time">Yesterday</div>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li> -->
                    <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Notifications
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                <a href="#" class="dropdown-item dropdown-item-unread">
                                    <div class="dropdown-item-icon bg-primary text-white">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        Template update is available now!
                                        <div class="time text-primary">2 Min Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-icon bg-info text-white">
                                        <i class="far fa-user"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                                        <div class="time">10 Hours Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-icon bg-success text-white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                                        <div class="time">12 Hours Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-icon bg-danger text-white">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        Low disk space. Let's clean it!
                                        <div class="time">17 Hours Ago</div>
                                    </div>
                                </a>
                                <a href="#" class="dropdown-item">
                                    <div class="dropdown-item-icon bg-info text-white">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        Welcome to Stisla template!
                                        <div class="time">Yesterday</div>
                                    </div>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li> -->
                     <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?php echo base_url() ?>/template/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?= session()->username; ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- <div class="dropdown-title">Logged in 5 min ago</div> -->
                            <!--<a href="features-profile.html" class="dropdown-item has-icon">-->
                            <!--    <i class="far fa-user"></i> Profile-->
                            <!--</a>-->
                            <!-- <a href="features-activities.html" class="dropdown-item has-icon">
                                <i class="fas fa-bolt"></i> Activities
                            </a>
                            <a href="features-settings.html" class="dropdown-item has-icon">
                                <i class="fas fa-cog"></i> Settings
                            </a> -->
                            <div class="dropdown-divider"></div>
                            <a href="<?= site_url('auth/logout') ?>" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="logo brand">
                        <img src="<?= base_url() ?>/template/assets/img/ipsos.png" alt="logo" class="center">
                    </div>
                    <div class="sidebar-brand">
                        <a href="index.html">OPS-IPSOS INDONESIA</a> 
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">OPS</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        </li>
                        <li class="active"><a class="nav-link" href=<?= site_url('Home/index') ?>><i class="fas fa-fire"></i> <span>Home</span></a></li>
                        <!-- <li class="nav-item dropdown"> -->
                        <li><a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Monitor</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-menu"> <span>RTD</span></a>
                                <!--<li class="menu-header">RTD</li>-->
                                    <!--<ul class="dropdown-submenu">-->
                                        <li><a class="nav-link" href="<?php echo site_url('/db_rtd_vendor') ?>">LOAD VENDOR</a></li>
                                        <li><a class="nav-link" href="<?php echo site_url('/db_rtd_int_internal') ?>">LOAD INTERVIEWER</a></li>
                                        <li><a class="nav-link" href="<?php echo site_url('/db_rtd_int_perproj_i') ?>">LIST PROJ BY INTV</a></li>
                                        <li><a class="nav-link" href="<?php echo site_url('/db_rtd_entry') ?>">INTERACTIVE RTD</a></li>
                                        <li><a class="nav-link" href="<?php echo site_url('/db_vendor_entry') ?>">INTERACTIVE VENDOR</a></li>
                                        <!--<li><a class="nav-link" href="bootstrap-breadcrumb.html">DATABASE RTD</a></li>-->
                                    <!--</ul>-->
                                </li>
                            </ul>

                            <!--<ul class="dropdown-menu">-->
                            <!--    <li><a class="dropdown-menu"> <span>QUANTITATIVE</span></a>-->
                            <!--    <li><a class="nav-link" href="<?php echo site_url('/db_sfm_load0') ?>">QUANTITATIVE</a></li>-->
                            <!--    <li><a class="nav-link" href="<?php echo site_url('/db_sfm_load1') ?>">QUANTITATIVE 1</a></li>-->
                            <!--    <li><a class="nav-link" href="<?php echo site_url('/db_sfm_load2') ?>">QUANTITATIVE 2</a></li>-->
                                <!--<li><a class="nav-link" href="bootstrap-breadcrumb.html">DATABASE QUANTY</a></li>-->
                            <!--</ul>-->

                            <!--<ul class="dropdown-menu">-->
                            <!--    <li><a class="nav-link" href="<?php echo site_url('/db_qualyload') ?>">LOAD PIC</a></li>-->
                            <!--    <li><a class="nav-link" href="<?php echo site_url('/db_qualy') ?>">Summary Detail</a></li>-->
                                <!--<li><a class="nav-link" href="bootstrap-breadcrumb.html">DATABASE QUALY</a></li>-->

                            <!--</ul>-->

                            <!--<ul class="dropdown-menu">-->
                            <!--    <li><a href="#" class="dropdown-menu"><span>QC</span></a></li>-->
                            <!--</ul>-->

                            <!--<ul class="dropdown-menu">-->
                            <!--    <li><a class="dropdown-menu"> <span>DP</span></a></li>-->
                            <!--    <li><a class="nav-link" href="<?php echo site_url('/db_dpload') ?>">LOAD DP</a></li>-->
                            <!--    <li><a class="nav-link" href="bootstrap-badge.html">TYPE OF PROCESS</a></li>-->
                            <!--    <li><a class="nav-link" href="bootstrap-breadcrumb.html">DP STATUS</a></li>-->
                            <!--    <li><a class="nav-link" href="bootstrap-breadcrumb.html">DATABASE DP</a></li>-->

                            <!--</ul>-->
                        </li>
                        <!--<li class="nav-item dropdown">-->
                        <!--    <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i> <span>Feedback</span></a>-->
                        <!--    <ul class="dropdown-menu">-->
                        <!--        <li><a class="nav-link" href="components-article.html">RTD</a></li>-->
                        <!--        <li><a class="nav-link beep beep-sidebar" href="components-avatar.html">QUANTY</a></li>-->
                        <!--        <li><a class="nav-link" href="components-chat-box.html">QUALITATIVE</a></li>-->
                        <!--        <li><a class="nav-link beep beep-sidebar" href="components-empty-state.html">DP</a></li>-->
                        <!--    </ul>-->
                        <!--</li>-->
                        <!--<li class="nav-item dropdown">-->
                        <!--    <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Target & General Issue</span></a>-->
                        <!--    <ul class="dropdown-menu">-->
                        <!--        <li><a class="nav-link" href="forms-advanced-form.html">No Error</a></li>-->
                        <!--        <li><a class="nav-link" href="forms-editor.html">On Spec</a></li>-->
                        <!--        <li><a class="nav-link" href="forms-validation.html">On Time</a></li>-->
                        <!--    </ul>-->
                        <!--</li>-->
                        <!--<li class="nav-item dropdown">-->
                        <!--    <a href="#" class="nav-link has-dropdown"><i class="fas fa-file"></i> <span>Library</span></a>-->
                        <!--    <ul class="dropdown-menu">-->
                        <!--        <li><a href="gmaps-advanced-route.html">ISO</a></li>-->
                        <!--        <li><a href="gmaps-draggable-marker.html">Tools</a></li>-->
                        <!--        <li><a href="gmaps-geocoding.html">Books</a></li>-->
                        <!--        <li><a href="gmaps-geolocation.html">Training</a></li>-->
                        <!--        <li><a href="gmaps-marker.html">Other</a></li>-->
                        <!--    </ul>-->
                        <!--</li>-->
                        <!--<li class="nav-item dropdown">-->
                        <!--    <a href="#" class="nav-link has-dropdown"><i class="fas fa-plug"></i> <span>Problem & Solving</span></a>-->
                        <!--    <ul class="dropdown-menu">-->
                        <!--        <li><a class="nav-link" href="modules-calendar.html">Field Work</a></li>-->
                        <!--        <li><a class="nav-link" href="modules-chartjs.html">QC</a></li>-->
                        <!--        <li><a class="nav-link" href="modules-datatables.html">RTD</a></li>-->
                        <!--        <li><a class="nav-link" href="modules-flag.html">DP</a></li>-->
                        <!--    </ul>-->
                        <!--</li>-->
                        <li><a class="nav-link" href="/"><i class="far fa-user"></i> <span>Q&A Internal</span></a></li>


                        <!--<div class="mt-4 mb-4 p-3 hide-sidebar-mini">-->
                        <!--    <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">-->
                        <!--        <i class="fas fa-rocket"></i> Documentation-->
                        <!--    </a>-->
                        <!--</div>-->
                </aside>
            </div>
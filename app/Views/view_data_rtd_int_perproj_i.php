<?php
require 'functionconnsql.php';

function sortmulti($array, $index, $order, $natsort = FALSE, $case_sensitive = FALSE)
{
    if (is_array($array) && count($array) > 0) {
        foreach (array_keys($array) as $key)
            $temp[$key] = $array[$key][$index];
        if (!$natsort) {
            if ($order == 'asc')
                asort($temp);
            else
                arsort($temp);
        } else {
            if ($case_sensitive === true)
                natsort($temp);
            else
                natcasesort($temp);
            if ($order != 'asc')
                $temp = array_reverse($temp, TRUE);
        }
        foreach (array_keys($temp) as $key)
            if (is_numeric($key))
                $sorted[] = $array[$key];
            else
                $sorted[$key] = $array[$key];
        return $sorted;
    }
    // return $sorted;
}

function array_sort($array, $on, $order = SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}



$strquery="SELECT PROJ_Symphoni_num,PROJ_KODENWB,PROJ_StatusFieldFinal,PROJ_Field_start,PROJ_Field_End,PROJ_Project_name FROM tb_Project_ownership Where PROJ_StatusFieldFinal=1 GROUP BY PROJ_Symphoni_num " ;
$bantu01=mysqli_query($conn,$strquery); 
$arrayown=[];
while ($row = mysqli_fetch_assoc($bantu01)) {
       $arrayown[]=$row;
}

$strquery="SELECT NWB_INT,NWB_12digit, SUM(NWB_Num) as SUMACH FROM tb_NWB left join tb_Project_ownership on NWB_ID=PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1 GROUP BY NWB_INT,NWB_12digit" ;
$bantu01=mysqli_query($conn,$strquery); 
$arrayintall=[];
while ($row = mysqli_fetch_assoc($bantu01)) {
       $bantu=[];
       $bantu['NWB_INT']=$row['NWB_INT'];
       $bantu['NWB_12digit']=$row['NWB_12digit'];
       $bantu['SUMACH']=$row['SUMACH'];
       $bantu['int_gab']=$row['NWB_INT'].'#'.$row['NWB_12digit'];
       $arrayintall[]=$bantu;
}
$columns = array_column($arrayintall, "int_gab");
array_multisort($columns, SORT_DESC, $arrayintall);

$strquery="SELECT NWB_INT,NWB_12digit, SUM(NWB_Num) as SUMACH FROM tb_NWB left join tb_Project_ownership on NWB_ID=PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1 AND NWB_STATUS LIKE 'Complete' GROUP BY NWB_INT,NWB_12digit" ;
$bantu01=mysqli_query($conn,$strquery); 
$arrayintcomplete=[];
while ($row = mysqli_fetch_assoc($bantu01)) {
       $bantu=[];
       $bantu['NWB_INT']=$row['NWB_INT'];
       $bantu['NWB_12digit']=$row['NWB_12digit'];
       $bantu['SUMACH']=$row['SUMACH'];
       $bantu['int_gab']=$row['NWB_INT'].'#'.$row['NWB_12digit'];
       $arrayintcomplete[]=$bantu;
}
$columns = array_column($arrayintcomplete, "int_gab");
array_multisort($columns, SORT_DESC, $arrayintcomplete);

$strquery="SELECT NWB_INT,NWB_12digit, SUM(NWB_Num) as SUMCANCEL FROM tb_NWB left join tb_Project_ownership on NWB_ID=PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1 AND NWB_STATUS LIKE 'Cancelled' GROUP BY NWB_INT,NWB_12digit" ;
$bantu01=mysqli_query($conn,$strquery); 
$arrayintcancel=[];
while ($row = mysqli_fetch_assoc($bantu01)) {
       $bantu=[];
       $bantu['NWB_INT']=$row['NWB_INT'];
       $bantu['NWB_12digit']=$row['NWB_12digit'];
       $bantu['SUMCANCEL']=$row['SUMCANCEL'];
       $bantu['int_gab']=$row['NWB_INT'].'#'.$row['NWB_12digit'];
       $arrayintcancel[]=$bantu;
}
$columns = array_column($arrayintcancel, "int_gab");
array_multisort($columns, SORT_DESC, $arrayintcancel);

//$strquery="SELECT RTD_User_ID,RTD_Company_Name,RTD_Gender,RTD_Last_Name,RTD_IDVENDOR,RTD_City,RTD_Phone_home FROM tb_RTD" ; 
$strquery = "SELECT VendorName as RTD_Company_Name,ID_INTV_LAMA as RTD_User_ID,IDVENDOR as RTD_IDVENDOR,Nama as RTD_Last_Name,Jenis_Kelamin as RTD_Gender,Kota as RTD_City,Nomor_Handphone as RTD_Phone_home  FROM RTD_masterdata GROUP BY RTD_User_ID";
$bantu01=mysqli_query($conn,$strquery); 
$listRTD=[];
while ($row = mysqli_fetch_assoc($bantu01)) { 
       $listRTD[]=$row;
}


//$strquery="SELECT VEN_ID,VEN_NAME,VEN_PROV,VEN_PIC FROM tb_vendor" ; 
$strquery = "SELECT id_vendor as VEN_ID,provinsi as VEN_PROV,vendor_name as VEN_NAME,kota_area_cakupan as VEN_AREA,pic as VEN_PIC,telp_pic as VEN_TELPPIC  FROM RTD_vendor GROUP BY VEN_ID";
$bantu01=mysqli_query($conn,$strquery); 
$listvendor=[];
while ($row = mysqli_fetch_assoc($bantu01)) { 
       $listvendor[]=$row;
}


//$arrayAll
$tb_all=[];
$jum=0;
$newarrayown=array_column($arrayown,'PROJ_Symphoni_num');
$newarrayrtd=array_column($listRTD,'RTD_User_ID');
$newarrayvendor=array_column($listvendor,'VEN_ID');
$newarraycancel=array_column($arrayintcancel,'int_gab');
$newarraycomplet=array_column($arrayintcomplete,'int_gab');
//print_r($newarrayown);
foreach($arrayintall as $row){
    $idint=array_search($row['NWB_INT'],$newarrayrtd,true);
    $namavendor=$listRTD[$idint]['RTD_IDVENDOR'];
    $idvendor=array_search($namavendor,$newarrayvendor,true);
    $idown=array_search($row['NWB_12digit'],$newarrayown,true);
    $idgabcancel=array_search($row['int_gab'],$newarraycancel,true);
    $idgabcomplet=array_search($row['int_gab'],$newarraycomplet,true);
    if($idown>=0&&$arrayown[$idown]['PROJ_StatusFieldFinal']==1){
        $arbantu0=[];
        $arbantu0[0]=$idint;
        $arbantu0[1]=$namavendor;
        $arbantu0[2]=$idvendor;
        $arbantu0['id_int']=$row['NWB_INT'];
        $arbantu0['SUMACH']=$arrayintcomplete[$idgabcomplet]['SUMACH'];
        $arbantu0['SUMCANCEL']=$arrayintcancel[$idgabcancel]['SUMCANCEL'];
        $arbantu0['name']=$listRTD[$idint]['RTD_Last_Name'];
        $arbantu0['sex']=$listRTD[$idint]['RTD_Gender'];
        $arbantu0['city']=$listRTD[$idint]['RTD_City'];
        $arbantu0['telp']=$listRTD[$idint]['RTD_Phone_home'];
        $arbantu0['idvendor']=$listRTD[$idint]['RTD_IDVENDOR'];
        $arbantu0['ven_id']=$listvendor[$idvendor]['VEN_ID'];
        $arbantu0['vendor_pic']=$listvendor[$idvendor]['VEN_PIC'];
        $arbantu0['vendor_prov']=$listvendor[$idvendor]['VEN_PROV'];
        $arbantu0['status']=$arrayown[$idown]['PROJ_StatusFieldFinal'];
        $arbantu0['fwstart']=$arrayown[$idown]['PROJ_Field_start'];
        $arbantu0['fwend']=$arrayown[$idown]['PROJ_Field_End'];
        $arbantu0['projname']=$arrayown[$idown]['PROJ_Project_name'];
        $arbantu0['sumphony']=$arrayown[$idown]['PROJ_Symphoni_num'];
        if($listRTD[$idint]['RTD_IDVENDOR']=='11111111'){
            $arbantu0['stat_internal']='internal';
        } else {$arbantu0['stat_internal']='vendor';}
        $tb_all[]=$arbantu0;
    }
}

// print_r($tb_all);
// die();


$tb_all_Internal=[];
foreach($tb_all as $row){
    if($row['stat_internal']=='internal'){
        $arbantu0=[];
        $arbantu0['id_int']=$row['id_int'];
        $arbantu0['SUMACH']=$row['SUMACH'];
        $arbantu0['SUMCANCEL']=$row['SUMCANCEL'];
        $arbantu0['name']=$row['name'];
        $arbantu0['sex']=$row['sex'];
        $arbantu0['city']=$row['city'];
        $arbantu0['telp']=$row['telp'];
        $arbantu0['idvendor']=$row['idvendor'];
        $arbantu0['ven_id']=$row['ven_id'];
        $arbantu0['vendor_pic']=$row['vendor_pic'];
        $arbantu0['vendor_prov']=$row['vendor_prov'];
        $arbantu0['status']=$row['status'];
        $arbantu0['fwstart']=$row['fwstart'];
        $arbantu0['fwend']=$row['fwend'];
        $arbantu0['projname']=$row['projname'];
        $arbantu0['sumphony']=$row['sumphony'];
        $tb_all_Internal[]=$arbantu0;
    }
}
//print_r($tb_all);
// die();
$columns = array_column($tb_all_Internal, "id_int");
array_multisort($columns, SORT_ASC, $tb_all_Internal);


//$columns = array_column($tb_spv, "COUNT_PROJ");
//array_multisort($columns, SORT_DESC, $tb_spv);
//print_r($tb_spv);  
//die(''); 


//$ArINTV=mysqli_fetch_assoc($artes);
?>

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
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                     <div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        <div class="search-backdrop"></div>
                        <div class="search-result">
                            </div>
                    </div>
                </form>
                <ul class="navbar-nav navbar-left">
                    <!-- <li><a class="nav-link "href="<?php echo site_url('/db_rtd_int_perproj_i') ?>" data-toggle="navbar" class="nav-link nav-link-lg message-toggle beep">INTERNAL IPSOS</a></li>-->
                    <!--<li><a class="nav-link "href="<?php echo site_url('/db_rtd_int_perproj_v') ?>" data-toggle="navbar" class="nav-link nav-link-lg message-toggle beep">VENDOR</a></li>-->
                        
                     <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="<?php echo base_url() ?>/template/assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?= session()->username; ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                             <div class="dropdown-title">Logged in 5 min ago</div> 
                            <a href="features-profile.html" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
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
                                        <li><a class="nav-link" href="<?php echo site_url('/db_rtd_int') ?>">LOAD INTERVIEWER</a></li>
                                        <li><a class="nav-link" href="<?php echo site_url('/db_rtd_int_perproj_i') ?>">LIST PROJ BY INTV</a></li>
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


                        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                <!--<i class="fas fa-rocket"></i> Documentation-->
                            </a>
                        </div>
                </aside>
            </div>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>LIST OF PROJECT (INTERNAL INTERVW) <br>
            </h1><br>
        </div>
        
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body col-md-8">


        <!--####MEMBUAT BAR MENU#######-->
        <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">-->
          <!--<a class="navbar-brand" href="#">Navbar</a>-->
        <!--  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">-->
        <!--    <span class="navbar-toggler-icon"></span>-->
        <!--  </button>-->
        <!--  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">-->
        <!--    <div class="navbar-nav">-->
        <!--      <a class="nav-item nav-link active" href="#">INTERNAL IPSOS <span class="sr-only">(current)</span></a>-->
        <!--      <a class="nav-item nav-link" href="#">VENDOR</a>-->
        <!--    </div>-->
        <!--  </div>-->
        <!--</nav>-->
        

                    <div class="card-box table-responsive" width=40>
                    <a href="<?=site_url('/db_rtd_int_perproj_i')?>" class="btn btn-primary">
                        <i class=""></i> Internal
                    </a>
                    <a href="<?=site_url('/db_rtd_int_perproj_v')?>" class="btn btn-primary">
                        <i class=""></i> Vendor
                    </a>
                    <a href="<?=site_url('export/db_rtd_vendor')?>" class="btn btn-primary">
                        <i class="fas fa-file-download"></i>Export Data
                    </a>

                    <table border="1" cellpadding="3" cellspacing="0" width=100% style='border-collapse:collapse; table-layout:absolute ; font-size:11px'>
                        <thead>

                            <tr height=20 style='height:15.0pt' ; bgcolor="darkblue">
                                <th rowspan=2 style='width:5px'>
                                    <font color="white">No</font>
                                </th>
                                <th rowspan=2 style='width:500px'>
                                    <font color="white">ID INTV</font>
                                </th>
                                <th rowspan=2 style='width:100px'>
                                    <font color="white">NAMA INTV</font>
                                </th>
                                <th rowspan=2 style='width:200px'>
                                    <font color="white">GENDER</font>
                                </th>
                                <th rowspan=2 style='width:70px'>
                                    <font color="white">KOTA INTV</font>
                                </th>
                                <th rowspan=2 style='width:15px'>
                                    <font color="white">CODE</font>
                                </th>
                                <!--<th width:"10px">-->
                                <!--    <font color="white">PROV DENDOR</font>-->
                                <!--</th>-->
                                <!--<th rowspan=2 style='width:10px'>-->
                                <!--    <font color="white">PIC</font>-->
                                <!--</th>-->
                                <!--<th rowspan=2 style='width:10px'>-->
                                <!--    <font color="white">PROV VENDOR</font>-->
                                <!--</th>-->
                                <th rowspan=2 style='width:900px'>
                                    <font color="white">PROJECT</font>
                                </th>
                                <th rowspan=2 style='width:900px'>
                                    <font color="white">ACH</font>
                                </th>
                                <th rowspan=2 style='width:900px'>
                                    <font color="white">DROP</font>
                                </th>
                            </tr>
                        </thead>


 <tbody>
                            				    <?php $i=1;?> 
                            				    <?php foreach($tb_all_Internal as $row){ 
                                				   $i=$i+1 ?> 
                    					            <tr style="font-size:11.5px">
                                						<td><?=$i;?></td>
                                						<td><a><?=$row['id_int'];?></a></td>
                                						<td><?=$row['name'];?></a></td>
                                						<td><?=$row['sex'];?></a></td>
                                						<td><?=$row['city'];?></a></td>
                                						<td><?=$row['idvendor'];?></a></td>
                                						<!--<td><?=$row['city'];?></a></td>-->
                                						<!--<td><?=$row['vendor_pic'];?></a></td>-->
                                						<!--<td><?=$row['vendor_prov'];?></a></td>-->
                                						<td><?=$row['projname'];?></a></td>
                                						<td><?=$row['SUMACH'];?></a></td>
                                						<td><?=$row['SUMCANCEL'];?></a></td>
                                					</tr>
                                				<?php } ?>
                            				</tbody>
                            				
                    				</table>
                    				
                    				 <!-- General JS Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
        <script src="<?= base_url() ?>/template/assets/js/stisla.js"></script>

        <!-- JS Libraies -->

        <!-- Template JS File -->
        <script src="<?= base_url() ?>/template/assets/js/scripts.js"></script>
        <script src="<?= base_url() ?>/template/assets/js/custom.js"></script>

        <!-- Page Specific JS File -->
        <!-- <script type="text/javascript">
    function table() {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            document.getElementById("table").innerHTML = this.responseText;
        }
        xhttp.open("GET", "/");
        xhttp.send();
    }

    setInterval(function() {
        table();
    }, 6000);
</script>
<div id="table">

</div> -->
        </body>

        </html>
<?php
require 'functionconnsql.php';
$Index_DB = $_GET["NWB_INT"];
//$resultFW=mysqli_query($conn,"SELECT * FROM tb_main_dashboard_rev WHERE Index_DB LIKE '$Index_DB'") ;
//$ArFW=mysqli_fetch_assoc($resultFW); 
/*
$pos_plus=strpos($Index_DB,";");
$vvendor=trim(substr($Index_DB,0,$pos_plus));
$bantu=trim(substr($Index_DB,$pos_plus+1,strlen($Index_DB)-$pos_plus));

$pos_plus=strpos($bantu,"$");
$vspv=trim(substr($bantu,0,$pos_plus));
$vintv=trim(substr($bantu,$pos_plus+1,strlen($bantu)-$pos_plus));
*/
//print($vvendor);
//print($vspv);
//print($vintv);

$strquery = "SELECT *,SUM(PROJ_Target) as Sum_Target FROM tb_Project_ownership WHERE PROJ_StatusFieldFinal=1 GROUP BY PROJ_Symphoni_num";
$bantu01 = mysqli_query($conn, $strquery);
$SummPROJ = [];
$row = [];
$bantu = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu['PROJ_IDGAB'] = $row['PROJ_ID10DGT'];
    $bantu['PROJ_ID10DGT'] = $row['PROJ_ID10DGT'];
    $bantu['PROJ_ID12DGT'] = $row['PROJ_Symphoni_num'];
    $bantu['PROJ_Target'] = $row['Sum_Target'];
    $bantu['PROJ_Field_start'] = $row['PROJ_Field_start'];
    $bantu['PROJ_Field_End'] = $row['PROJ_Field_End'];
    $bantu['PROJ_DP_End'] = $row['PROJ_DP_End'];
    $bantu['PROJ_Symphoni_num'] = $row['PROJ_Symphoni_num'];
    $bantu['PROJ_Project_name'] = $row['PROJ_Project_name'];
    $bantu['PROJ_name_parent'] = $row['PROJ_name_parent'];
    $bantu['PROJ_StatusFieldFinal'] = $row['PROJ_StatusFieldFinal'];
    //$bantu['RTD_Company_Name']=$row['RTD_Company_Name'];PROJ_StatusFieldFinal=1 
    //$bantu['RTD_Supervisor_Vendor']=$row['RTD_Supervisor_Vendor'];
    $SummPROJ[] = $bantu;
}

$strquery = "SELECT NWB_ID,NWB_10digit,NWB_12digit,NWB_IDPROJ,NWB_INT,SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate,  ";
$strquery= $strquery ."VendorName as RTD_Company_Name,ID_INTV_LAMA as RTD_User_ID,IDVENDOR as RTD_IDVENDOR,Nama as RTD_Last_Name,Jenis_Kelamin as RTD_Gender,Kota as RTD_City,Nomor_Handphone as RTD_Phone_home ";
$strquery= $strquery ." FROM tb_NWB LEFT JOIN RTD_masterdata ON tb_NWB.NWB_INT = ID_INTV_LAMA  LEFT JOIN tb_Project_ownership ON NWB_ID=PROJ_KODENWB ";
$strquery= $strquery ."WHERE PROJ_StatusFieldFinal=1 AND NWB_STATUS LIKE 'Complete' AND NWB_INT LIKE '$Index_DB' GROUP BY NWB_12digit";
$bantu01 = mysqli_query($conn, $strquery);
$SummINT = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummINT[] = $row;
}
//print_r($SummINT);
$lst_int = [];
foreach ($SummINT as $nilai) {
    if (!in_array($nilai['NWB_12digit'], $lst_int, true)) {
        $lst_int[] = $nilai['NWB_12digit'];
    }
}
//print_r($lst_int);

$tb_int = [];
$jum = 0;
$newarray = array_column($SummPROJ, 'PROF_ID12DGT');
//$newarray=array_column($SummINT,'RTD_Supervisor_Vendor');
foreach ($lst_int as $nint) {
    foreach ($SummINT as $row) {
        //$id=array_search($nspv,$newarray,true);
        if ($nint == $row['NWB_12digit']) {
            $id = array_search($row['NWB_12digit'], $newarray, true);
            $arbantu0 = [];
            $arbantu0['NWB_12digit'] = $row['NWB_12digit'];
            $arbantu0['RTD_Last_Name'] = $row['RTD_Last_Name'];
            $arbantu0['RTD_User_ID'] = $row['RTD_User_ID'];
            $arbantu0['NWB_IDPROJ'] = $row['NWB_IDPROJ'];
            $arbantu0['PROJ_Field_start'] = $SummPROJ[$id]['PROJ_Field_start'];
            $arbantu0['PROJ_Field_End'] = $SummPROJ[$id]['PROJ_Field_End'];
            $arbantu0['RTD_Company_Name'] = $row['RTD_Company_Name'];
            //$arbantu0['RTD_Phone_home']=$row['RTD_Phone_home'];
            $jum++;
        }
    }
    $arbantu0['COUNT_INT'] = $jum;
    $jum = 0;
    $tb_int[] = $arbantu0;
}
//print_r($tb_int);





?>

<?php require 'header.php' ?>;

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>RESUME INTERVIEWER <br>
                <strong>
                    <font color="darkblue">INTERVIEWER:<?= $tb_int[0]['RTD_User_ID'] . ' - ' . $tb_int[0]['RTD_Last_Name'] ?></font>
                </strong>
                <br>

                <strong>
                    <font color="darkblue">VENDOR: <?= $tb_int[0]['RTD_Company_Name'] . ' - ' . $tb_int[0]['RTD_Company_Name'] ?></font>
                </strong>
                <br>
            </h1>

        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body col-md-6">
                    <div class="x_content">

                        <body link="#0563C1" vlink="#954F72">
                            <table border="1" cellpadding="3" cellspacing="0" width=100% style='border-collapse:collapse; table-layout:absolute ; font-size:11px'>
                                <thead>

                                    <tr height=20 style='height:15.0pt' ; bgcolor="darkblue">
                                        <th rowspan=2 class=xl120 style='height:10px;  width:30px'>
                                            <font color="white">No</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:30px'>
                                            <font color="white">SYMPHONY NUM</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:100px'>
                                            <font color="white">PRJ NAME</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:40px'>
                                            <font color="white">Start Project</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:40px'>
                                            <font color="white">End Project</font>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    <?php foreach ($tb_int as $row) {
                                        $i = $i + 1 ?>
                                        <tr style="font-size:11.5px">
                                            <td><?= $i; ?></td>
                                            <td><a><?= $row['NWB_12digit']; ?></a></td>
                                            <td><a><?= $row['NWB_IDPROJ']; ?></a></td>
                                            <td><a><?= $row['PROJ_Field_start']; ?></a></td>
                                            <td><a><?= $row['PROJ_Field_End']; ?></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>

                    </div>
                    
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
</body>

</html>
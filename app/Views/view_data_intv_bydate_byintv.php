<?php
require 'functionconnsql.php';
$Index_DB = $_GET["NWB_INT"];
//var_dump($Index_DB);
$pos_plus = strpos($Index_DB, ";");
$idproj = trim(substr($Index_DB, 0, $pos_plus));
$datestart = trim(substr($Index_DB, $pos_plus + 1, strlen($Index_DB) - $pos_plus));
//var_dump($idproj);
//var_dump($datestart);

$strquery = "SELECT *,SUM(NWB_Num) AS SUMACH FROM tb_NWB LEFT JOIN tb_RTD ON NWB_INT=RTD_User_ID WHERE NWB_ID LIKE '$idproj' AND NWB_StartDate LIKE '$datestart' AND NWB_STATUS LIKE 'Complete' GROUP BY NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
$Summ = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $Summ[] = $row;
}
//print_r($Summ);
//die();
$aruniq = [];
$jumuniq = 0;
foreach ($Summ as $row) {
    if (!in_array($row['NWB_INT'], $aruniq)) {
        $aruniq[] = $row['NWB_INT'];
    }
}

$SummLoadINTV = [];
foreach ($aruniq as $row1) {
    $ach = 0;
    $jum = 0;
    $bantu00 = [];
    $bantu00['NWB_10digit'] = "";
    $bantu00['NWB_IDPROJ'] = "";
    $bantu00['NWB_StartDate'] = "";
    $bantu00['NWB_INT'] = "";
    $bantu00['RTD_Last_Name'] = "";
    $bantu00['RTD_Gender'] = "";
    $bantu00['RTD_Supervisor_Vendor'] = "";
    $bantu00['RTD_Company_Name'] = "";
    $bantu00['RTD_City'] = "";
    $bantu00['RTD_Phone_home'] = "";
    foreach ($Summ as $row2) {
        if ($row1 == $row2['NWB_INT']) {
            $jum++;
            $ach = $ach + $row2['SUMACH'];
            $bantu00['NWB_10digit'] = $row2['NWB_10digit'];
            $bantu00['NWB_IDPROJ'] = $row2['NWB_IDPROJ'];
            $bantu00['NWB_StartDate'] = $row2['NWB_StartDate'];
            $bantu00['NWB_INT'] = $row2['NWB_INT'];
            $bantu00['RTD_Last_Name'] = $row2['RTD_Last_Name'];
            $bantu00['RTD_Gender'] = $row2['RTD_Gender'];
            //$bantu00['RTD_Supervisor_Vendor']=$row2['RTD_Supervisor_Vendor']; 
            $bantu00['RTD_Company_Name'] = $row2['RTD_Company_Name'];
            $bantu00['RTD_City'] = $row2['RTD_City'];
            $bantu00['RTD_Phone_home'] = $row2['RTD_Phone_home'];
        }
    }
    $bantu00['NWB_ACH'] = $ach;
    $bantu00['JUM_INTV'] = $jum;
    $bantu00['AVGLOAD'] = 'xxx';
    $bantu00['PROJ_NAME'] = 'xxx';
    $SummLoadINTV[] = $bantu00;
}
//print_r($SummLoadINTV);



//$ArINTV=mysqli_fetch_assoc($artes);
?>

<?php require 'header.php' ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>DAILY REPORT <br>
                <strong>
                    <font color="darkblue"><?= $SummLoadINTV[0]['NWB_IDPROJ'] ?>, DATE: <?= $SummLoadINTV[0]['NWB_StartDate'] ?></font>
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
                            <table border="1" cellpadding="3" cellspacing="0" width=100%>
                                <thead>

                                    <tr height=20 style='height:15.0pt' ; bgcolor="darkblue">
                                        <th rowspan=2 class=xl120 style='height:40px;  width:30px'>
                                            <font color="white">No</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:10px'>
                                            <font color="white">ID INTV</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:80px'>
                                            <font color="white">Intvw NAME</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:10px'>
                                            <font color="white">GENDER</font>
                                        </th>
                                        <!--<th rowspan=2 class=xl122 style='width:60px'><font color="white">SPV VENDOR</font></th>-->
                                        <th rowspan=2 class=xl122 style='width:80px'>
                                            <font color="white">VENDOR NAME</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:50px'>
                                            <font color="white">CITY</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:10px'>
                                            <font color="white">PHONE</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:10px'>
                                            <font color="white">Ach</font>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    <?php foreach ($SummLoadINTV as $row) {
                                        $i = $i + 1 ?>
                                        <tr style="font-size:11.5px">
                                            <td><?= $i; ?></td>
                                            <td><a><?= $row['NWB_INT']; ?></a></td>
                                            <td><a><?= $row['RTD_Last_Name']; ?></a></td>
                                            <td><a><?= $row['RTD_Gender']; ?></a></td>
                                            <!--<td><a><?= $row['RTD_Supervisor_Vendor']; ?></a></td>-->
                                            <td><a><?= $row['RTD_Company_Name']; ?></a></td>
                                            <td><a><?= $row['RTD_City']; ?></a></td>
                                            <td><a><?= $row['RTD_Phone_home']; ?></a></td>
                                            <td><a><?= $row['NWB_ACH']; ?></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>

                            </table>
                        </body>
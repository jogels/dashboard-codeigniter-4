<?php
require 'functionconnsql.php';
$Index_DB = $_GET["NWB_INT"];
//var_dump($Index_DB);
$pos_plus = strpos($Index_DB, ";");
$vsimponi = trim(substr($Index_DB, 0, $pos_plus));
$bt = trim(substr($Index_DB, $pos_plus + 1, strlen($Index_DB) - $pos_plus));
$pos_plus = strpos($bt, ";");
$vnamaproj = trim(substr($bt, 0, $pos_plus));
$avgload = intval(trim(substr($bt, $pos_plus + 1, strlen($bt) - $pos_plus)));
//var_dump($vsimponi);
//var_dump($vnamaproj); 
//var_dump($avgload); 

if($avgload==0){
    die("Data is empty because the method is not F2F, does not need Interviewer, etc");
}

$strquery = "SELECT * FROM tb_Project_ownership";
$bantu01 = mysqli_query($conn, $strquery);
$SummOWN = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummOWN[] = $row;
}
$singleKolomOWN = array_column($SummOWN, 'PROJ_KODENWB');
//print_r($singleKolomOWN);
//die();

$strquery = "SELECT NWB_INT,NWB_StartDate FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID=PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1 AND  NWB_ID LIKE '$vnamaproj' AND NWB_STATUS LIKE 'Complete' GROUP BY NWB_INT,NWB_StartDate ";
//$strquery = "SELECT * FROM tb_NWB LEFT JOIN tb_Project_ownership ON tb_NWB.NWB_INT = tb_Project_ownership.PROJ_KODENWB  WHERE NWB_ID LIKE '$vnamaproj' AND NWB_STATUS LIKE 'Complete' GROUP BY NWB_INT,NWB_StartDate ";
$bantu01 = mysqli_query($conn, $strquery);
$hitjumhari = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $hitjumhari[] = $row;
}
//print_r($hitjumhari);
//die();
$aruniq = [];
$jumuniq = 0;
foreach ($hitjumhari as $row) {
    if (!in_array($row['NWB_INT'], $aruniq)) {
        $aruniq[] = $row['NWB_INT'];
    }
}

$hitjumhari2 = [];
foreach ($aruniq as $row1) {
    $jum = 0;
    $bantu00 = [];
    $bantu00['NWB_INT'] = "";
    foreach ($hitjumhari as $row2) {
        if ($row1 == $row2['NWB_INT']) {
            $jum++;
            $bantu00['NWB_INT'] = $row2['NWB_INT'];
        }
    }
    $bantu00['JUM_DAYS'] = $jum;
    $hitjumhari2[] = $bantu00;
}
//print_r($hitjumhari2);



// $strquery = "SELECT * FROM tb_RTD ";
$strquery = "SELECT VendorName as RTD_Company_Name,ID_INTV_LAMA as RTD_User_ID,IDVENDOR as RTD_IDVENDOR,Nama as RTD_Last_Name,Jenis_Kelamin as RTD_Gender,KOta as RTD_City,Nomor_Handphone as RTD_Phone_home  FROM RTD_masterdata GROUP BY RTD_User_ID";
$bantu01 = mysqli_query($conn, $strquery);
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummRTD[] = $row;
}
//print_r($SummRTD);

$strquery = "SELECT NWB_INT,NWB_ID FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID=PROJ_KODENWB WHERE PROJ_StatusFieldFinal=1 AND NWB_STATUS LIKE 'Complete' GROUP BY NWB_INT,NWB_ID";
$bantu01 = mysqli_query($conn, $strquery);
$SummLoadINTV0 = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) { 
    $SummLoadINTV0[] = $row;
}
$aruniq = [];
$jumuniq = 0;
foreach ($SummLoadINTV0 as $row) {
    if (!in_array($row['NWB_INT'], $aruniq)) {
        $aruniq[] = $row['NWB_INT'];
    }
}
$SummLoadINTV = [];
foreach ($aruniq as $row1) {
    $jum = 0;
    $bantu00 = [];
    $bantu00['NWB_INT'] = "";
    foreach ($SummLoadINTV0 as $row2) {
        if ($row1 == $row2['NWB_INT']) {
            $jum++;
            $bantu00['NWB_INT'] = $row2['NWB_INT'];
            $bantu00['JUM_PROJ'] = $jum;
        }
    }
    $SummLoadINTV[] = $bantu00;
}
//print_r($SummLoadINTV);

$strquery = "SELECT NWB_ID,NWB_10digit,NWB_12digit,NWB_IDPROJ,NWB_INT,SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID=PROJ_KODENWB WHERE PROJ_StatusFieldFinal=1 AND NWB_ID LIKE '$vnamaproj' AND NWB_STATUS LIKE 'Complete' GROUP BY NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
$SummINTV = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummINTV[] = $row;
}
$aruniq = [];
$jumuniq = 0;
foreach ($SummINTV as $row) {
    if (!in_array($row['NWB_INT'], $aruniq)) {
        $aruniq[] = $row['NWB_INT'];
        $jumuniq++;
    }
}

//print_r($aruniq);
$arr_intvload = [];
foreach ($aruniq as $row1) {
    $jum = 0;
    $bantu00 = [];
    $bantu00['NWB_10digit'] = "";
    $bantu00['NWB_12digit'] = "";
    $bantu00['NWB_IDPROJ'] = "";
    $bantu00['NWB_INT'] = "";
    $bantu00['NWB_ACH'] = "";
    $bantu00['NWB_StartDate'] = "";
    $bantu00['NWB_EndDate'] = "";
    foreach ($SummINTV as $row2) {
        if ($row1 == $row2['NWB_INT']) {
            $jum++;
            $bantu00['NWB_ID'] = $row2['NWB_ID'];
            $bantu00['NWB_10digit'] = $row2['NWB_10digit'];
            $bantu00['NWB_12digit'] = $row2['NWB_12digit'];
            $bantu00['NWB_IDPROJ'] = $row2['NWB_IDPROJ'];
            $bantu00['NWB_INT'] = $row2['NWB_INT'];
            $bantu00['NWB_ACH'] = $row2['SUMACH'];
            $bantu00['NWB_StartDate'] = $row2['NWB_StartDate'];
            $bantu00['NWB_EndDate'] = $row2['NWB_EndDate'];
        }
    }
    //$bantu00['NWB_INT']=$jum;
    $arr_intvload[] = $bantu00;
}
//print_r($arr_intvload);

$newarray = array_column($SummRTD, 'RTD_User_ID');
$kolomarray2 = array_column($SummLoadINTV, 'NWB_INT');
$kolomarray3 = array_column($hitjumhari2, 'NWB_INT');
//print_r($newarray);
$arr_dashboard = [];
foreach ($arr_intvload as $row) {
    if(!empty($row['NWB_INT'])){
        // $id0 = array_search($row['NWB_ID'], $singleKolomOWN, true);
        // if(!empty($id0) && $SummOWN[$id0]['PROJ_StatusFieldFinal']==1){
            $id = array_search($row['NWB_INT'], $newarray, true);
            $id2 = array_search($row['NWB_INT'], $kolomarray2, true);
            $id3 = array_search($row['NWB_INT'], $kolomarray3, true);
            $bantu = [];
            $bantu[] = $id;
            $bantu['NWB_10digit'] = $row['NWB_10digit'];
            $bantu['NWB_12digit'] = $row['NWB_12digit'];
            $bantu['NWB_IDPROJ'] = $row['NWB_IDPROJ'];
            $bantu['NWB_INT'] = $row['NWB_INT'];
            $bantu['NWB_ACH'] = $row['NWB_ACH'];
            $bantu['NWB_StartDate'] = $row['NWB_StartDate'];
            $bantu['NWB_EndDate'] = $row['NWB_EndDate'];
            $bantu['RTD_LOAD'] = $SummLoadINTV[$id2]['JUM_PROJ'];
            $bantu['RTD_SUMDAYS'] = $hitjumhari2[$id3]['JUM_DAYS'];
            if ($id == '') {
                $bantu['RTD_NAME'] = '';
                $bantu['RTD_GENDER'] = '';
                $bantu['RTD_VENDOR'] = '';
                $bantu['RTD_HP'] = '';
                $bantu['RTD_CITY'] = '';
            }
            if ($id > 0) {
                $bantu['RTD_NAME'] = $SummRTD[$id]['RTD_Last_Name'];
                $bantu['RTD_GENDER'] = $SummRTD[$id]['RTD_Gender'];
                $bantu['RTD_VENDOR'] = $SummRTD[$id]['RTD_Company_Name'];
                $bantu['RTD_HP'] = $SummRTD[$id]['RTD_Phone_home'];
                $bantu['RTD_CITY'] = $SummRTD[$id]['RTD_City'];
            }
            if ($bantu['RTD_NAME'] != '' && $bantu['RTD_VENDOR'] == '') $bantu['RTD_VENDOR'] = 'Field Force';
            $arr_dashboard[] = $bantu;
        // }
    }
}

//print_r($arr_dashboard);  
//die("");


//$ArINTV=mysqli_fetch_assoc($resultINTV);
?>
<?php require 'header.php' ?>;

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>LIST INTERVIEWER <?= $vnamaproj; ?> <br>
                <strong>
                    <font color="darkblue"><?php if (!is_null($arr_dashboard[0]["NWB_IDPROJ"])) {
                                                echo strtoupper($arr_dashboard[0]["NWB_IDPROJ"]);
                                            } ?></font>
                </strong>
                <br>
                <strong>
                    <font color="darkblue">Average Per Interviewer: <?= $avgload ?></font>
                </strong>
                <strong>
                    <font color="darkblue"><?php if (is_null($arr_dashboard[0]["NWB_IDPROJ"])) {
                                                echo "NA";
                                            } ?></font>
                </strong>
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
                                    <tr height=20 style='height:15.0pt' ; bgcolor="dodgerblue">
                                        <th rowspan=2 class=xl120 style='height:30.75pt;  width:30px'>
                                            <font color="white">No</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:60px'>
                                            <font color="white">ID LOGIN</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:100px'>
                                            <font color="white">NAMA</font>
                                        </th>
                                        <th rowspan=2 class=xl124 style='width:60px'>
                                            <font color="white">Gender</font>
                                        </th>
                                        <!--<th rowspan=2 class=xl124 style='width:60px'><font color="white">SPV</font></th>-->
                                        <th rowspan=2 class=xl124 style='width:100px'>
                                            <font color="white">Company Name</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:50px'>
                                            <font color="white">City</font>
                                        </th>
                                        <th rowspan=2 class=xl132 style='width:30px'>
                                            <font color="white">Ach.</font>
                                        </th>
                                        <th rowspan=2 class=xl132 style='width:60px'>
                                            <font color="white">Telp-Home</font>
                                        </th>
                                        <th rowspan=2 class=xl132 style='width:70px'>
                                            <font color="white">Start Date</font>
                                        </th>
                                        <th rowspan=2 class=xl132 style='width:70px'>
                                            <font color="white">End Date</font>
                                        </th>
                                        <th rowspan=2 class=xl132 style='width:10px'>
                                            <font color="white">#DAYS</font>
                                        </th>
                                        <th rowspan=2 class=xl132 style='width:30px'>
                                            <font color="white">Load (#Proj)</font>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    <?php foreach ($arr_dashboard as $row) {
                                        $i = $i + 1 ?>
                                        <tr style="font-size:11.5px">
                                            <td>
                                                <font color="black"><?= $i; ?></font>
                                            </td>
                                            <td>
                                                <font color="black"><?= $row['NWB_INT']; ?></font>
                                            </td>
                                            <td>
                                                <font color="black"><?= $row['RTD_NAME']; ?></font>
                                            </td>
                                            <td>
                                                <font color="black"><?= $row['RTD_GENDER']; ?></font>
                                            </td>

                                            <td>
                                                <font color="black"><?= $row['RTD_VENDOR']; ?></font>
                                            </td>
                                            <td>
                                                <font color="black"><?= $row['RTD_CITY']; ?></font>
                                            </td>
                                            <!--<td><a><?= $row['NWB_ACH']; ?></a></td>-->

                                            <?php if (round($row['NWB_ACH'] / $avgload, 0) <= 0.50) { ?><td bgcolor="red">
                                                    <font color="white"><?= round($row['NWB_ACH'], 0); ?></font>
                                                </td> <?php } ?>
                                            <?php if (round($row['NWB_ACH'] / $avgload, 0) > 0.50 && round($row['NWB_ACH'] / $avgload, 0) <= 0.75) { ?><td bgcolor="yellow"><?= round($row['NWB_ACH'], 0); ?></td> <?php } ?>
                                            <?php if (round($row['NWB_ACH'] / $avgload, 0) > 0.75) { ?><td>
                                                    <font color="black"><?= round($row['NWB_ACH'], 0); ?></font>
                                                </td> <?php } ?>

                                            <td>
                                                <font color="black"><?= $row['RTD_HP']; ?></font>
                                            </td>
                                            <td>
                                                <font color="black"><?= $row['NWB_StartDate']; ?></font>
                                            </td>
                                            <td>
                                                <font color="black"><?= $row['NWB_EndDate']; ?></font>
                                            </td>
                                            <td>
                                                <font color="black"><?= $row['RTD_SUMDAYS']; ?></font>
                                            </td>
                                            <td><a href="/db_rtd_intproj1?NWB_INT=<?= $row['NWB_INT']; ?>"><?= $row['RTD_LOAD']; ?></a></td>
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
</body>

</html>
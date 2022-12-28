<?php
require 'functionconnsql.php';
$Index_DB = $_GET["NWB_INT"];
$pos_plus = strpos($Index_DB, ";");
$vsimponi = trim(substr($Index_DB, 0, $pos_plus));
$temp1 = trim(substr($Index_DB, $pos_plus + 1, strlen($Index_DB) - $pos_plus));
$pos_plus_1 = strpos($Index_DB, " (S22");
$codenwb=trim(substr($Index_DB, $pos_plus_1 + 2, strlen($Index_DB) - $pos_plus_1));
$codenwb=trim(str_replace(")","",$codenwb));
$pos_plus = strpos($temp1, ";");
$vnamaproj = trim(substr($temp1, 0, $pos_plus));
$temp1 = trim(substr($temp1, $pos_plus + 1, strlen($Index_DB) - $pos_plus));
$pos_plus = strpos($temp1, ";");
$vachiev = trim(substr($temp1, 0, $pos_plus));


$vprojnameori = trim(substr($temp1, $pos_plus + 1, strlen($temp1) - $pos_plus));
//var_dump($vsimponi);
//var_dump($vnamaproj);
//var_dump($vachiev);

// var_dump($vnamaproj);
// var_dump($vprojnameori);
// var_dump($temp1);

$strquery = "SELECT *,CONCAT(ID_NWB,';',NWB_Quota) as GAB, MAX(Target) as MaxTarget FROM tb_target WHERE  ID_NWB LIKE '$codenwb'  GROUP BY NWB_Quota";
$bantu01 = mysqli_query($conn, $strquery);
$arrtarget = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $arrtarget[] = $row;
}

$strquery = "SELECT *,CONCAT(NWB_ID,';',NWB_Quota1) as GAB, SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' AND NWB_ID LIKE '$codenwb'   GROUP BY NWB_Quota1";
$bantu01 = mysqli_query($conn, $strquery);
$quota1 = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $quota1[] = $row;
}
// print_r($quota1); 
// die();
$total = 0;
$total1 = 0;
$qquota1 = [];
foreach ($quota1 as $row) {
    $cc = [];
    $cc['NWB_Quota1'] = $row['NWB_Quota1'];
    $cc['NWB_ID'] = $row['NWB_ID'];
    $cc['NWB_IDPROJ'] = $row['NWB_IDPROJ'];
    $cc['SUMACH'] = $row['SUMACH'];
    $cc['GAB'] = $row['GAB'];
    $cc['NWB_10digit'] = $row['NWB_10digit'];
    $cc['NWB_12digit'] = $row['NWB_12digit'];
    $tgt = 0;

    foreach ($arrtarget as $row2) {
        if ($row2['GAB'] == $row['GAB']) {
            //$row['TARGET']=$row2['MaxTarget'];
            //print($row2['MaxTarget']);
            //array_push($cc,'999');
            $tgt = $row2['MaxTarget'];
            break;
        }
    }

    $cc['target'] = $tgt;
    $qquota1[] = $cc;
    $total += $row['SUMACH'];
    if (TRIM($row['NWB_Quota1']) !== "") $total1++;
}
//print_r($qquota1);  


$strquery = "SELECT *,CONCAT(NWB_ID,';',NWB_Quota2) as GAB, SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' AND NWB_ID LIKE '$codenwb'  GROUP BY NWB_Quota2";
//$strquery="SELECT *,SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_10digit LIKE '$vsimponi' GROUP BY NWB_Quota2";
$bantu01 = mysqli_query($conn, $strquery);
$quota2 = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $quota2[] = $row;
}
$total2 = 0;
$total = 0;
$qquota2 = [];
foreach ($quota2 as $row) {
    $cc = [];
    $cc['NWB_Quota2'] = $row['NWB_Quota2'];
    $cc['NWB_ID'] = $row['NWB_ID'];
    $cc['NWB_IDPROJ'] = $row['NWB_IDPROJ'];
    $cc['SUMACH'] = $row['SUMACH'];
    $cc['GAB'] = $row['GAB'];
    $cc['NWB_10digit'] = $row['NWB_10digit'];
    $cc['NWB_12digit'] = $row['NWB_12digit'];
    $tgt = 0;

    foreach ($arrtarget as $row2) {
        if ($row2['GAB'] == $row['GAB']) {
            //$row['TARGET']=$row2['MaxTarget'];
            //print($row2['MaxTarget']);
            //array_push($cc,'999');
            $tgt = $row2['MaxTarget'];
            break;
        }
    }

    $cc['target'] = $tgt;
    $qquota2[] = $cc;
    $total += $row['SUMACH'];
    if (TRIM($row['NWB_Quota2']) !== "") $total2++;
}

/*
foreach($quota2 as $row){
    if(TRIM($row['NWB_Quota2'])!=="") $total2++;
}
*/


$strquery = "SELECT *,CONCAT(NWB_ID,';',NWB_Quota3) as GAB, SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' AND  NWB_ID LIKE '$codenwb'  GROUP BY NWB_Quota3";
$bantu01 = mysqli_query($conn, $strquery);
$quota3 = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $quota3[] = $row;
}
$total3 = 0;
$total = 0;
$qquota3 = [];
foreach ($quota3 as $row) {
    $cc = [];
    $cc['NWB_Quota3'] = $row['NWB_Quota3'];
    $cc['NWB_ID'] = $row['NWB_ID'];
    $cc['NWB_IDPROJ'] = $row['NWB_IDPROJ'];
    $cc['SUMACH'] = $row['SUMACH'];
    $cc['GAB'] = $row['GAB'];
    $cc['NWB_10digit'] = $row['NWB_10digit'];
    $cc['NWB_12digit'] = $row['NWB_12digit'];
    $tgt = 0;

    foreach ($arrtarget as $row2) {
        if ($row2['GAB'] == $row['GAB']) {
            //$row['TARGET']=$row2['MaxTarget'];
            //print($row2['MaxTarget']);
            //array_push($cc,'999');
            $tgt = $row2['MaxTarget'];
            break;
        }
    }

    $cc['target'] = $tgt;
    $qquota3[] = $cc;
    $total += $row['SUMACH'];
    if (TRIM($row['NWB_Quota3']) !== "") $total3++;
}
/*
foreach($quota3 as $row){
    if(TRIM($row['NWB_Quota3'])!=="") $total3++;
}
*/


$strquery = "SELECT *,CONCAT(NWB_ID,';',NWB_Quota4) as GAB, SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' AND  NWB_ID LIKE '$codenwb'  GROUP BY NWB_Quota4";
//$strquery="SELECT *,SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_10digit LIKE '$vsimponi' GROUP BY NWB_Quota4";
$bantu01 = mysqli_query($conn, $strquery);
$quota4 = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $quota4[] = $row;
}
$total4 = 0;
$total = 0;
$qquota4 = [];
foreach ($quota4 as $row) {
    $cc = [];
    $cc['NWB_Quota4'] = $row['NWB_Quota4'];
    $cc['NWB_ID'] = $row['NWB_ID'];
    $cc['NWB_IDPROJ'] = $row['NWB_IDPROJ'];
    $cc['SUMACH'] = $row['SUMACH'];
    $cc['GAB'] = $row['GAB'];
    $cc['NWB_10digit'] = $row['NWB_10digit'];
    $cc['NWB_12digit'] = $row['NWB_12digit'];
    $tgt = 0;

    foreach ($arrtarget as $row2) {
        if ($row2['GAB'] == $row['GAB']) {
            //$row['TARGET']=$row2['MaxTarget'];
            //print($row2['MaxTarget']);
            //array_push($cc,'999');
            $tgt = $row2['MaxTarget'];
            break;
        }
    }

    $cc['target'] = $tgt;
    $qquota4[] = $cc;
    $total += $row['SUMACH'];
    if (TRIM($row['NWB_Quota4']) !== "") $total4++;
}
/*
foreach($quota4 as $row){
    if(TRIM($row['NWB_Quota4'])!=="") $total4++;
}
*/

$strquery = "SELECT *,CONCAT(NWB_ID,';',NWB_Quota5) as GAB, SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' AND  NWB_ID LIKE '$codenwb' GROUP BY NWB_Quota5";
//$strquery="SELECT *,SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_10digit LIKE '$vsimponi' GROUP BY NWB_Quota5";
$bantu01 = mysqli_query($conn, $strquery);
$quota5 = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $quota5[] = $row;
}
$total5 = 0;
$qquota5 = [];
foreach ($quota5 as $row) {
    $cc = [];
    $cc['NWB_Quota5'] = $row['NWB_Quota5'];
    $cc['NWB_ID'] = $row['NWB_ID'];
    $cc['NWB_IDPROJ'] = $row['NWB_IDPROJ'];
    $cc['SUMACH'] = $row['SUMACH'];
    $cc['GAB'] = $row['GAB'];
    $cc['NWB_10digit'] = $row['NWB_10digit'];
    $cc['NWB_12digit'] = $row['NWB_12digit'];
    $tgt = 0;

    foreach ($arrtarget as $row2) {
        if ($row2['GAB'] == $row['GAB']) {
            //$row['TARGET']=$row2['MaxTarget'];
            //print($row2['MaxTarget']);
            //array_push($cc,'999');
            $tgt = $row2['MaxTarget'];
            break;
        }
    }

    $cc['target'] = $tgt;
    $qquota5[] = $cc;
    $total += $row['SUMACH'];
    if (TRIM($row['NWB_Quota5']) !== "") $total5++;
}
/*
foreach($quota5 as $row){
    if(TRIM($row['NWB_Quota5'])!=="") $total5++;
}
*/


$strquery = "SELECT *,CONCAT(NWB_ID,';',NWB_Quota6) as GAB, SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' AND NWB_ID LIKE '$codenwb'  GROUP BY NWB_Quota6";
//$strquery="SELECT *,SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_10digit LIKE '$vsimponi' GROUP BY NWB_Quota6";
$bantu01 = mysqli_query($conn, $strquery);
$quota6 = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $quota6[] = $row;
}
$total6 = 0;
$qquota6 = [];
foreach ($quota6 as $row) {
    $cc = [];
    $cc['NWB_Quota6'] = $row['NWB_Quota6'];
    $cc['NWB_ID'] = $row['NWB_ID'];
    $cc['NWB_IDPROJ'] = $row['NWB_IDPROJ'];
    $cc['SUMACH'] = $row['SUMACH'];
    $cc['GAB'] = $row['GAB'];
    $cc['NWB_10digit'] = $row['NWB_10digit'];
    $cc['NWB_12digit'] = $row['NWB_12digit'];
    $tgt = 0;

    foreach ($arrtarget as $row2) {
        if ($row2['GAB'] == $row['GAB']) {
            //$row['TARGET']=$row2['MaxTarget'];
            //print($row2['MaxTarget']);
            //array_push($cc,'999');
            $tgt = $row2['MaxTarget'];
            break;
        }
    }

    $cc['target'] = $tgt;
    $qquota6[] = $cc;
    $total += $row['SUMACH'];
    if (TRIM($row['NWB_Quota6']) !== "") $total6++;
}
/*
foreach($quota6 as $row){
    if(TRIM($row['NWB_Quota6'])!=="") $total6++;
}
*/

$strquery = "SELECT *,CONCAT(NWB_ID,';',NWB_Quota7) as GAB, SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' AND NWB_ID LIKE '$codenwb' GROUP BY NWB_Quota7";
//$strquery="SELECT *,SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_10digit LIKE '$vsimponi' GROUP BY NWB_Quota7";
$bantu01 = mysqli_query($conn, $strquery);
$quota7 = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $quota7[] = $row;
}
$total7 = 0;
$qquota7 = [];
foreach ($quota7 as $row) {
    $cc = [];
    $cc['NWB_Quota7'] = $row['NWB_Quota7'];
    $cc['NWB_IDPROJ'] = $row['NWB_IDPROJ'];
    $cc['NWB_ID'] = $row['NWB_ID'];
    $cc['SUMACH'] = $row['SUMACH'];
    $cc['GAB'] = $row['GAB'];
    $cc['NWB_10digit'] = $row['NWB_10digit'];
    $cc['NWB_12digit'] = $row['NWB_12digit'];
    $tgt = 0;

    foreach ($arrtarget as $row2) {
        if ($row2['GAB'] == $row['GAB']) {
            //$row['TARGET']=$row2['MaxTarget'];
            //print($row2['MaxTarget']);
            //array_push($cc,'999');
            $tgt = $row2['MaxTarget'];
            break;
        }
    }

    $cc['target'] = $tgt;
    $qquota7[] = $cc;
    $total += $row['SUMACH'];
    if (TRIM($row['NWB_Quota7']) !== "") $total7++;
}
/*
foreach($quota7 as $row){
    if(TRIM($row['NWB_Quota7'])!=="") $total7++;
}
*/

$strquery = "SELECT *,CONCAT(NWB_ID,';',NWB_Quota8) as GAB, SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' AND NWB_ID LIKE '$codenwb'  GROUP BY NWB_Quota8";
//$strquery="SELECT *,SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_10digit LIKE '$vsimponi' GROUP BY NWB_Quota8";
$bantu01 = mysqli_query($conn, $strquery);
$quota8 = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $quota8[] = $row;
}
$total8 = 0;
$qquota8 = [];
foreach ($quota8 as $row) {
    $cc = [];
    $cc['NWB_Quota8'] = $row['NWB_Quota8'];
    $cc['NWB_ID'] = $row['NWB_ID'];
    $cc['NWB_IDPROJ'] = $row['NWB_IDPROJ'];
    $cc['SUMACH'] = $row['SUMACH'];
    $cc['GAB'] = $row['GAB'];
    $cc['NWB_10digit'] = $row['NWB_10digit'];
    $cc['NWB_12digit'] = $row['NWB_12digit'];
    $tgt = 0;

    foreach ($arrtarget as $row2) {
        if ($row2['GAB'] == $row['GAB']) {
            //$row['TARGET']=$row2['MaxTarget'];
            //print($row2['MaxTarget']);
            //array_push($cc,'999');
            $tgt = $row2['MaxTarget'];
            break;
        }
    }

    $cc['target'] = $tgt;
    $qquota8[] = $cc;
    $total += $row['SUMACH'];
    if (TRIM($row['NWB_Quota8']) !== "") $total8++;
}
/*
foreach($quota8 as $row){
    if(TRIM($row['NWB_Quota8'])!=="") $total8++;
}
*/

//var_dump($total);
//print_r($quota2);

//print_r($arr_dashboard);
//die("");


//$ArINTV=mysqli_fetch_assoc($resultINTV);
?>
<?php require 'header.php' ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>ACHIEVEMENT: <?= $vprojnameori; ?> <br>
                <strong>
                    <font color="darkblue">TOTAL ACHIEVEMENT: <?= $vachiev ?></font>
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
                        
                <div class="float-left ml-1">
                <a href="/db_target_interviewer?NWB_ID=<?= $vnamaproj; ?>" class="btn btn-primary">
                    <i class="pen-to-square"></i> Edit Target Per Interviewer
                </a>
                </div><br><br>

                        <body link="#0563C1" vlink="#954F72">

                            <?php if ($total1 > 0) { ?>
                                <table border="1" cellpadding="3" cellspacing="0" width=700>
                                    <thead>
                                        <tr height=20 style='height:15.0pt' ; bgcolor="dodgerblue">
                                            <th rowspan=2 class=xl120 style='height:30.75pt;  width:30px'>
                                                <a href="/db_quota_int?NWB_ID=<?= $row['NWB_ID']; ?>"><font color="white">No</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:200px'>
                                                <a href="/db_quota_int?NWB_ID=<?= $row['NWB_ID']; ?>"><font color="white">QUOTA</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <a href="/db_quota_int?NWB_ID=<?= $row['NWB_ID']; ?>"><font color="white">ACH</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <a href="/db_quota_int?NWB_ID=<?= $row['NWB_ID']; ?>"><font color="white">TARGET</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <a href="/db_quota_int?NWB_ID=<?= $row['NWB_ID']; ?>"><font color="white">SHORTFALL</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <a href="/db_quota_int?NWB_ID=<?= $row['NWB_ID']; ?>"><font color="white">SHORTFALL (%)</font>
                                            </th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        <?php foreach ($qquota1 as $row) {
                                            $i = $i + 1 ?>
                                            <tr style="font-size:11.5px">
                                                <td><a href="/db_quota_int_perarea?NWB_ID=<?= $row['NWB_ID'].';'.$row['NWB_Quota1']; ?>"><?= $i; ?></a></td>
                                                <td><a href="/db_quota_int_perarea?NWB_ID=<?= $row['NWB_ID'].';'.$row['NWB_Quota1']; ?>"><?= $row['NWB_Quota1']; ?></a></td>
                                                <td><a href="/db_quota_int_perarea?NWB_ID=<?= $row['NWB_ID'].';'.$row['NWB_Quota1']; ?>"><?= $row['SUMACH']; ?></a></td>
                                                <td><a href="/db_quota_int_perarea?NWB_ID=<?= $row['NWB_ID'].';'.$row['NWB_Quota1']; ?>"><?= $row['target']; ?></a></td>
                                                <?php if ($row['target'] > 0) { ?><td><a href="/db_quota_int_perarea?NWB_ID=<?= $row['NWB_ID'].';'.$row['NWB_Quota1']; ?>"><?= $row['target'] - $row['SUMACH']; ?></a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a href="/db_quota_int_perarea?NWB_ID=<?= $row['NWB_ID'].';'.$row['NWB_Quota1']; ?>"><?= '-'; ?></a></td><?php } ?>
                                                <?php if ($row['target'] > 0) { ?><td><a href="/db_quota_int_perarea?NWB_ID=<?= $row['NWB_ID'].';'.$row['NWB_Quota1']; ?>"><?= round(($row['target'] - $row['SUMACH'])/$row['target']*100,0); ?>%</a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a href="/db_quota_int_perarea?NWB_ID=<?= $row['NWB_ID'].';'.$row['NWB_Quota1']; ?>"><?= '-'; ?></a></td><?php } ?>
                                                
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <br>
                            <?php } ?>


                            <?php if ($total2 > 0) { ?>
                                <table border="1" cellpadding="3" cellspacing="0" width=100% style='border-collapse:collapse; table-layout:absolute ; font-size:11px'>
                                    <thead>
                                        <tr height=20 style='height:15.0pt' ; bgcolor="dodgerblue">
                                            <th rowspan=2 class=xl120 style='height:30.75pt;  width:30px'>
                                                <font color="white">No</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:200px'>
                                                <font color="white">QUOTA</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">ACH</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">TARGET</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL (%)</font>
                                            </th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        <?php foreach ($qquota2 as $row) {
                                            $i = $i + 1 ?>
                                            <tr style="font-size:11.5px">
                                                <td><?= $i; ?></td>
                                                <td><a><?= $row['NWB_Quota2']; ?></a></td>
                                                <td><a><?= $row['SUMACH']; ?></a></td>
                                                <td><a><?= $row['target']; ?></a></td>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= $row['target'] - $row['SUMACH']; ?></a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= round(($row['target'] - $row['SUMACH'])/$row['target']*100,0); ?>%</a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                                 
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <br>
                            <?php } ?>

                            <?php "<br/>" ?>
                            <?php if ($total3 > 0) { ?>
                                <table border="1" cellpadding="3" cellspacing="0" width=700>
                                    <thead>
                                        <tr height=20 style='height:15.0pt' ; bgcolor="dodgerblue">
                                            <th rowspan=2 class=xl120 style='height:30.75pt;  width:30px'>
                                                <font color="white">No</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:200px'>
                                                <font color="white">QUOTA</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">ACH</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">TARGET</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL (%)</font>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        <?php foreach ($qquota3 as $row) {
                                            $i = $i + 1 ?>
                                            <tr style="font-size:11.5px">
                                                <td><?= $i; ?></td>
                                                <td><a><?= $row['NWB_Quota3']; ?></a></td>
                                                <td><a><?= $row['SUMACH']; ?></a></td>
                                                <td><a><?= $row['target']; ?></a></td>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= $row['target'] - $row['SUMACH']; ?></a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= round(($row['target'] - $row['SUMACH'])/$row['target']*100,0); ?>%</a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <br>
                            <?php } ?>

                            <?php if ($total4 > 0) { ?>
                                <table border="1" cellpadding="3" cellspacing="0" width=700>
                                    <thead>
                                        <tr height=20 style='height:15.0pt' ; bgcolor="dodgerblue">
                                            <th rowspan=2 class=xl120 style='height:30.75pt;  width:30px'>
                                                <font color="white">No</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:200px'>
                                                <font color="white">QUOTA</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">ACH</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">TARGET</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL (%)</font>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        <?php foreach ($qquota4 as $row) {
                                            $i = $i + 1 ?>
                                            <tr style="font-size:11.5px">
                                                <td><?= $i; ?></td>
                                                <td><a><?= $row['NWB_Quota4']; ?></a></td>
                                                <td><a><?= $row['SUMACH']; ?></a></td>
                                                <td><a><?= $row['target']; ?></a></td>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= $row['target'] - $row['SUMACH']; ?></a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= round(($row['target'] - $row['SUMACH'])/$row['target']*100,0); ?>%</a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <br>
                            <?php } ?>

                            <?php if ($total5 > 0) { ?>
                                <table border="1" cellpadding="3" cellspacing="0" width=700>
                                    <thead>
                                        <tr height=20 style='height:15.0pt' ; bgcolor="dodgerblue">
                                            <th rowspan=2 class=xl120 style='height:30.75pt;  width:30px'>
                                                <font color="white">No</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:200px'>
                                                <font color="white">QUOTA</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">ACH</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">TARGET</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL (%)</font>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        <?php foreach ($qquota5 as $row) {
                                            $i = $i + 1 ?>
                                            <tr style="font-size:11.5px">
                                                <td><?= $i; ?></td>
                                                <td><a><?= $row['NWB_Quota5']; ?></a></td>
                                                <td><a><?= $row['SUMACH']; ?></a></td>
                                                <td><a><?= $row['target']; ?></a></td>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= $row['target'] - $row['SUMACH']; ?></a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= round(($row['target'] - $row['SUMACH'])/$row['target']*100,0); ?>%</a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <br>
                            <?php } ?>

                            <?php if ($total6 > 0) { ?>
                                <table border="1" cellpadding="3" cellspacing="0" width=700>
                                    <thead>
                                        <tr height=20 style='height:15.0pt' ; bgcolor="dodgerblue">
                                            <th rowspan=2 class=xl120 style='height:30.75pt;  width:30px'>
                                                <font color="white">No</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:200px'>
                                                <font color="white">QUOTA</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">ACH</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">TARGET</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL (%)</font>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        <?php foreach ($qquota6 as $row) {
                                            $i = $i + 1 ?>
                                            <tr style="font-size:11.5px">
                                                <td><?= $i; ?></td>
                                                <td><a><?= $row['NWB_Quota6']; ?></a></td>
                                                <td><a><?= $row['SUMACH']; ?></a></td>
                                                <td><a><?= $row['target']; ?></a></td>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= $row['target'] - $row['SUMACH']; ?></a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= round(($row['target'] - $row['SUMACH'])/$row['target']*100,0); ?>%</a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <br>
                            <?php } ?>

                            <?php if ($total7 > 0) { ?>
                                <table border="1" cellpadding="3" cellspacing="0" width=700>
                                    <thead>
                                        <tr height=20 style='height:15.0pt' ; bgcolor="dodgerblue">
                                            <th rowspan=2 class=xl120 style='height:30.75pt;  width:30px'>
                                                <font color="white">No</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:200px'>
                                                <font color="white">QUOTA</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">ACH</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">TARGET</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL (%)</font>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        <?php foreach ($qquota7 as $row) {
                                            $i = $i + 1 ?>
                                            <tr style="font-size:11.5px">
                                                <td><?= $i; ?></td>
                                                <td><a><?= $row['NWB_Quota7']; ?></a></td>
                                                <td><a><?= $row['SUMACH']; ?></a></td>
                                                <td><a><?= $row['target']; ?></a></td>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= $row['target'] - $row['SUMACH']; ?></a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= round(($row['target'] - $row['SUMACH'])/$row['target']*100,0); ?>%</a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <br>
                            <?php } ?>

                            <?php if ($total8 > 0) { ?>
                                <table border="1" cellpadding="3" cellspacing="0" width=700>
                                    <thead>
                                        <tr height=20 style='height:15.0pt' ; bgcolor="dodgerblue">
                                            <th rowspan=2 class=xl120 style='height:30.75pt;  width:30px'>
                                                <font color="white">No</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:200px'>
                                                <font color="white">QUOTA</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">ACH</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">TARGET</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL (%)</font>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        <?php foreach ($qquota8 as $row) {
                                            $i = $i + 1 ?>
                                            <tr style="font-size:11.5px">
                                                <td><?= $i; ?></td>
                                                <td><a><?= $row['NWB_Quota8']; ?></a></td>
                                                <td><a><?= $row['SUMACH']; ?></a></td>
                                                <td><a><?= $row['target']; ?></a></td>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= $row['target'] - $row['SUMACH']; ?></a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                                <?php if ($row['target'] > 0) { ?><td><a><?= round(($row['target'] - $row['SUMACH'])/$row['target']*100,0); ?>%</a></td><?php } ?>
                                                <?php if ($row['target'] <= 0) { ?><td><a><?= '-'; ?></a></td><?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } ?>


                       
                    </div>
                </div>
            </div>
        </div>
    </section>
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
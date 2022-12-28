<?php
require 'functionconnsql.php';
$Index_DB = $_GET["NWB_INT"];
$pos_plus = strpos($Index_DB, ";");
$idproj = trim(substr($Index_DB, 0, $pos_plus));
$achpeday = trim(substr($Index_DB, $pos_plus + 1, strlen($Index_DB) - $pos_plus));
//var_dump($Index_DB);
//var_dump($datestart);

$strquery = "SELECT * FROM tb_Project_ownership WHERE PROJ_KODENWB LIKE '$idproj' GROUP BY PROJ_KODENWB";
$bantu01 = mysqli_query($conn, $strquery);
$Summproj = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $Summproj[] = $row;
}

$strquery = "SELECT *,SUM(NWB_Num) AS SUMACH FROM tb_NWB WHERE NWB_ID LIKE '$idproj' AND NWB_STATUS LIKE 'Complete' GROUP BY NWB_StartDate,NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
$Summ = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $Summ[] = $row;
}
//print_r($Summ);

$aruniq = [];
$jumuniq = 0;
foreach ($Summ as $row) {
    if (!in_array($row['NWB_StartDate'], $aruniq)) {
        $aruniq[] = $row['NWB_StartDate'];
    }
}

$SummLoadINTVpedate = [];
foreach ($aruniq as $row1) {
    $ach = 0;
    $jum = 0;
    $bantu00 = [];
    $bantu00['NWB_StartDate'] = "";
    foreach ($Summ as $row2) {
        if ($row1 == $row2['NWB_StartDate']) {
            $jum++;
            $ach = $ach + $row2['SUMACH'];
            $bantu00['NWB_ID'] = $row2['NWB_ID'];
            $bantu00['NWB_10digit'] = $row2['NWB_10digit'];
            $bantu00['NWB_12digit'] = $row2['NWB_12digit'];
            $bantu00['NWB_IDPROJ'] = $row2['NWB_IDPROJ'];
            $bantu00['NWB_StartDate'] = $row2['NWB_StartDate'];
        }
    }
    $bantu00['NWB_ACH'] = $ach;
    $bantu00['JUM_INTV'] = $jum;
    $bantu00['AVGLOAD'] = 'xxx';
    $bantu00['PROJ_NAME'] = 'xxx';
    $SummLoadINTVpedate[] = $bantu00;
}
//print_r($SummLoadINTVpedate);



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
                    <font color="darkblue"><?= $Summproj[0]['PROJ_name_parent'] ?></font>
                </strong><br>
                <strong>
                    <font color="darkblue">ACHIEVEMENT TOTAL: <?= $achpeday ?></font>
                </strong>
            </h1><br>
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
                                        <th rowspan=2 class=xl120 style='height:40px;  width:30px'>
                                            <font color="white">No</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:100px'>
                                            <font color="white">Date</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:60px'>
                                            <font color="white">Intvw Active</font>
                                        </th>
                                        <th rowspan=2 class=xl122 style='width:80px'>
                                            <font color="white">Ach.</font>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0; ?>
                                    <?php foreach ($SummLoadINTVpedate as $row) {
                                        $i = $i + 1 ?>
                                        <tr style="font-size:11.5px">
                                            <td><?= $i; ?></td>
                                            <td><a><?= $row['NWB_StartDate']; ?></a></td>
                                            <td><a href="/bydatebyintv?NWB_INT=<?= $row['NWB_ID'] . ';' . $row['NWB_StartDate']; ?>"><?= $row['JUM_INTV']; ?></a></td>
                                            <td><?= $row['NWB_ACH']; ?></td>
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
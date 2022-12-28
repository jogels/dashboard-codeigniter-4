<?php
require 'functionconnsql.php';

$strquery = "SELECT *  FROM tb_vendor GROUP BY VEN_ID";
$bantu01 = mysqli_query($conn, $strquery);
$SUMMVENDOR = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SUMMVENDOR[] = $row;
}
//print_r($SUMMVENDOR);

$strquery = "SELECT NWB_INT  FROM tb_NWB GROUP BY NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
$bantu02 = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu02[] = $row;
}
$arr_intvw = array_column($bantu02, 'NWB_INT');
$strquery = "SELECT NWB_INT,NWB_StartDate  FROM tb_NWB GROUP BY NWB_StartDate";
$bantu01 = mysqli_query($conn, $strquery);
$bantu02 = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu02[] = $row;
}
$arr_date = array_column($bantu02, 'NWB_StartDate');
$c_intv = COUNT($arr_intvw);
$min_date = str_replace('-', '/', MIN($arr_date));
$max_date = str_replace('-', '/', MAX($arr_date));


//BUAT LIS VENDOR VS UM INTV
$strquery = "SELECT * FROM tb_NWB LEFT JOIN tb_RTD ON tb_NWB.NWB_INT = tb_RTD.RTD_User_ID WHERE RTD_Company_Name!='' AND NWB_STATUS LIKE 'Complete' GROUP BY RTD_Company_Name,NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
if (!$bantu01) {
    echo mysqli_error($bantu01);
}
$SummRTD = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummRTD[] = $row;
}
//print_r($SummRTD);

$lst_vendor = [];
foreach ($SummRTD as $nilai) {
    if (!in_array($nilai['RTD_Company_Name'], $lst_vendor, true)) {
        $lst_vendor[] = $nilai['RTD_Company_Name'];
    }
}
//print_r($lst_vendor);

$tb_vendorintv = [];
$jum = 0;
//$newarray=array_column($SummRTD,'RTD_Supervisor_Vendor');
foreach ($lst_vendor as $nspv) {
    foreach ($SummRTD as $row) {
        //$id=array_search($nspv,$newarray,true);
        if ($nspv == $row['RTD_Company_Name']) {
            $arbantu0 = [];
            //$arbantu0['RTD_SPV']=$row['RTD_Supervisor_Vendor'];
            $arbantu0['RTD_IDVENDOR'] = $row['RTD_IDVENDOR'];
            $arbantu0['RTD_Company_Name'] = $row['RTD_Company_Name'];
            $arbantu0['RTD_City'] = $row['RTD_City'];
            $arbantu0['RTD_Last_Name'] = $row['RTD_Last_Name'];
            $arbantu0['RTD_Phone_home'] = $row['RTD_Phone_home'];
            $jum++;
        }
    }
    $arbantu0['COUNT_INTV'] = $jum;
    $jum = 0;
    $tb_vendorintv[] = $arbantu0;
}
//print_r($tb_vendorintv);
//die('');

//BUAT LIS VENDOR VS JUM PROJ
$strquery = "SELECT * FROM tb_NWB LEFT JOIN tb_RTD ON tb_NWB.NWB_INT = tb_RTD.RTD_User_ID WHERE NWB_STATUS LIKE 'Complete' AND RTD_Company_Name!='' GROUP BY RTD_IDVENDOR,NWB_10digit";
$bantu01 = mysqli_query($conn, $strquery);
if (!$bantu01) {
    echo mysqli_error($bantu01);
}
$SummRTD = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummRTD[] = $row;
}
//print_r($SummRTD);

$lst_vendor = [];
foreach ($SummRTD as $nilai) {
    if (!in_array($nilai['RTD_IDVENDOR'], $lst_vendor, true)) {
        $lst_vendor[] = $nilai['RTD_IDVENDOR'];
    }
}
//print_r($lst_vendor);

$db_vendor = [];
$jum = 0;
$newarray = array_column($tb_vendorintv, 'RTD_IDVENDOR');
$arr_vendorid = array_column($SUMMVENDOR, 'VEN_ID');
foreach ($lst_vendor as $nspv) {
    $id = array_search($nspv, $newarray, true);
    foreach ($SummRTD as $row) {
        if ($nspv == $row['RTD_IDVENDOR']) {
            $idv = array_search($nspv, $arr_vendorid, true);
            $arbantu0 = [];
            $arbantu0[] = $id;
            //$arbantu0['RTD_SPV']=$row['RTD_Supervisor_Vendor'];
            $arbantu0['RTD_IDVENDOR'] = $row['RTD_IDVENDOR'];
            $arbantu0['VEN_PIC'] = $SUMMVENDOR[$idv]['VEN_PIC'];
            $arbantu0['VEN_AREA'] = $SUMMVENDOR[$idv]['VEN_AREA'];
            //$arbantu0['RTD_Company_Name']=$row['RTD_Company_Name'];
            $arbantu0['VEN_NAME'] = $SUMMVENDOR[$idv]['VEN_NAME'];
            $arbantu0['VEN_PROV'] = $SUMMVENDOR[$idv]['VEN_PROV'];
            $arbantu0['VEN_TELPPIC'] = $SUMMVENDOR[$idv]['VEN_TELPPIC'];
            //$arbantu0['RTD_City']=$row['RTD_City'];
            $jum++;
        }
    }
    $arbantu0['COUNT_PROJ'] = $jum;
    $arbantu0['COUNT_INTV'] = $tb_vendorintv[$id]['COUNT_INTV'];
    $jum = 0;
    $db_vendor[] = $arbantu0;
}
//print_r($db_vendor);
$columns = array_column($db_vendor, "COUNT_INTV");
array_multisort($columns, SORT_DESC, $db_vendor);
$columns = array_column($db_vendor, "COUNT_PROJ");
array_multisort($columns, SORT_DESC, $db_vendor);




/*

$db_intv=[];
$ckjum=0;
foreach($SummRTD as $nilai){
    if(!in_array($nilai['NWB_INT'],$lst_int,true)){
        $lst_int[]=$nilai['NWB_INT'];
        $ckjum++;
    }
}


$arr_intv=array_column($SummRTD,'NWB_INT');
$c_intv=COUNT($arr_intv);
$arr_date=array_column($SummRTD,'NWB_StartDate');
$min_date=str_replace('-','/',MIN($arr_date));
$max_date=str_replace('-','/',MAX($arr_date));
//var_dump($ckjum);
//var_dump($c_intv);
//var_dump($min_date);
//var_dump($max_date);


$lst_spv=[];
foreach($SummRTD as $nilai){
    if(!in_array($nilai['RTD_Supervisor_Vendor'],$lst_spv,true)){
        $lst_spv[]=$nilai['RTD_Supervisor_Vendor'];
    }
}
//print_r($lst_spv);


$tb_spv=[];
$jum=0;
$newarray=array_column($SummRTD,'RTD_Supervisor_Vendor');
foreach($lst_spv as $nspv){
    foreach($SummRTD as $row){
        //$id=array_search($nspv,$newarray,true);
        if($nspv==$row['RTD_Supervisor_Vendor']){
            $arbantu0=[];
            $arbantu0['RTD_SPV']=$row['RTD_Supervisor_Vendor'];
            $arbantu0['RTD_VENDOR']=$row['RTD_Company_Name'];
            $jum++;
        }
    }
    $arbantu0['COUNT_INT']=$jum;
    $jum=0;
    $tb_spv[]=$arbantu0;
}
*/
//print_r($tb_spv);
//die("");


// menghitung row
//$jumlah_barang = mysqli_num_rows($artes);

// Associative array
//$row = mysqli_fetch_assoc($artes);
//printf("%s (%s) - %s\n", $row['Interviewer'], $row['Supervisor_Vendor'],$jumlah_barang);


// Free result set
//mysqli_free_result($artes);
//die('');


//$ArINTV=mysqli_fetch_assoc($artes);
?>

<?php require 'header.php' ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>RESUME RTD <br>
                <strong>
                    <font color="darkblue"><?= 'LOAD VENDOR' ?></font>
                </strong></br>
                <strong>
                    <font color="darkblue">DATE : <?= $min_date ?> - <?= $max_date ?></font>
                </strong></br>
                <strong>
                    <font color="darkblue">TOTAL INTERVIEWER : <?= $c_intv ?></font>
                </strong>
            </h1><br>
        </div>


        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="float-right ml-4">
                <a href="<?=site_url('export/db_rtd_vendor')?>" class="btn btn-primary">
                    <i class="fas fa-file-download"></i> Export Data
                </a>
                </div>
                <div class="card-body col-md-10">
                     <table border="1" cellpadding="3" cellspacing="0" width=100% style='border-collapse:collapse; table-layout:absolute ; font-size:11px'>
                        <thead>

                            <tr height=20 style='height:15.0pt' ; bgcolor="darkblue">
                                <th rowspan=2 class=xl120 style='width:5px'>
                                    <font color="white">No</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:10px'>
                                    <font color="white">ID VENDOR</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:140px'>
                                    <font color="white">VENDOR NAME</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">PIC VENDOR</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:30px'>
                                    <font color="white">NO TELP</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:700px'>
                                    <font color="white">AREA</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:20px'>
                                    <font color="white">CITY</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:10px'>
                                    <font color="white">#PROJ</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:10px'>
                                    <font color="white">#INTV</font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <?php foreach ($db_vendor as $row) {
                                $i = $i + 1 ?>
                                <tr style="font-size:11.5px">
                                    <td><?= $i; ?></td>
                                    <td><a><?= $row['RTD_IDVENDOR']; ?></a></td>
                                    <td><a><?= $row['VEN_NAME']; ?></a></td>
                                    <td><?= $row['VEN_PIC']; ?></a></td>
                                    <td><?= $row['VEN_TELPPIC']; ?></a></td>
                                    <td><?= $row['VEN_AREA']; ?></a></td>
                                    <td><?= $row['VEN_PROV']; ?></a></td>
                                    <td><a href="view_db_rtd_vendor_proj?NWB_10digit=<?= $row['RTD_IDVENDOR'] . ';' . $row['COUNT_PROJ']; ?>"><?= $row['COUNT_PROJ']; ?></a></td>
                                    <td><a href="view_db_rtd_vendor_int?NWB_10digit=<?= $row['RTD_IDVENDOR'] . ';' . $row['COUNT_INTV']; ?>"><?= $row['COUNT_INTV']; ?></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                    
                    <footer class="main-footer">
    <div class="footer-left">
        <!-- Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a> -->
    </div>
    <div class="footer-right">
        2.3.0
    </div>
</footer>
</div>
</div>
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
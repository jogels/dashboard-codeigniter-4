<?php
require 'functionconnsql.php';
$Index_DB = $_GET["NWB_ID"];
$pos_plus = strpos($Index_DB, ";");
$vidnwb = trim(substr($Index_DB, 0, $pos_plus));
$varea = trim(substr($Index_DB, $pos_plus + 1, strlen($Index_DB) - $pos_plus));
//$pos_plus = strpos($temp1, ";");
//$vnamaproj = trim(substr($temp1, 0, $pos_plus));
//$varea = trim(substr($temp1, $pos_plus + 1, strlen($temp1) - $pos_plus));
//var_dump($vsimponi);
//var_dump($vnamaproj);
//var_dump($vachiev);


$strquery = "SELECT *, SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' AND NWB_ID LIKE '$vidnwb' AND NWB_Quota1 like '$varea' GROUP BY NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
$quotanwb = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $quotanwb[] = $row;
}


//print_r($quotanwb); 
//die();




/*
$strquery = "SELECT * FROM tb_vendor";
$bantu01 = mysqli_query($conn, $strquery);
$arrvendor = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $arrvendor[] = $row;
}*/


//$strquery = "SELECT tb_RTD.*,tb_vendor.* FROM tb_RTD left join tb_vendor on VEN_ID=RTD_IDVENDOR WHERE RTD_User_ID LIKE '$Index_DB' ";
$strquery = "SELECT tb_RTD.*,tb_vendor.* FROM tb_RTD left join tb_vendor on VEN_ID=RTD_IDVENDOR ";
$bantu01 = mysqli_query($conn, $strquery);
$arrrtd = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $arrrtd[] = $row;
}
//print_r($arrrtd); 
//die();


////==========final 
$strquery = "SELECT * FROM tb_intv WHERE int_nwb LIKE '$vidnwb' ";
$bantu01 = mysqli_query($conn, $strquery);
$arrintv = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $arrintv[] = $row;
}
//print_r($arrintv); 
//die();

$tb_gabint=[];
$newint = array_column($arrintv, 'int_code');
$newrtd = array_column($arrrtd, 'RTD_User_ID');
//$newvendor = array_column($arrvendor, 'VEN_ID');
foreach ($quotanwb as $row) {

    $id1 = array_search($row['NWB_INT'], $newint, true);
    $id2 = array_search($row['NWB_INT'], $newrtd, true);
    $bantu = [];
    //if($id1>0){
        $bantu[0]=$id1;
        $bantu[1]=$id2;

        $bantu['vendorid'] = '-';
        $bantu['vendorname'] = '-';
        $bantu['projname'] = '-';
        $bantu['ach'] = 0;
        $bantu['telp'] = '-';
        $bantu['nama_int'] = '-';
        $bantu['target'] = 0;
        $bantu['codeint'] = '-';
        $bantu['code_int'] = '-';
        $bantu['vendorid']='-';
        $bantu['vendorname'] ='IPSOS';

        if(!empty($id2))$bantu['vendorid'] = $arrrtd[$id2]['VEN_ID'];
        if(!empty($id2))$bantu['vendorname'] = $arrrtd[$id2]['VEN_NAME'];
        $bantu['projname'] = $row['NWB_IDPROJ'];
        $bantu['ach'] = $row['SUMACH'];
        if(!empty($id2))$bantu['telp'] = $arrrtd[$id2]['RTD_Phone_home'];
        if(!empty($id2))$bantu['nama_int'] = $arrrtd[$id2]['RTD_Last_Name'];
        if(!empty($id1))$bantu['target'] = $arrintv[$id1]['int_target'];
        if(!empty($id1)){$bantu['codeint'] = $row['NWB_INT'];}else{$bantu['codeint']='-';};
        if(!empty($id1)){$bantu['code_int'] = $arrintv[$id1]['int_code'];}else{$bantu['code_int']='-';}
        if(is_null($bantu['vendorid']))$bantu['vendorid']='-';
        if(is_null($bantu['vendorname']))$bantu['vendorname'] ='IPSOS';
        $tb_gabint[]=$bantu;
    //}
}

//print_r($tb_gabint);
//die();

$arrncek = array_column($tb_gabint, 'vendorid');
$jumlah_row = count($arrncek);
//var_dump($jumlah_row);
if($jumlah_row==0){
    echo 'Sorry of the inconvenience because Interviewer Target is still empty' ;
    die("");
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
            <h1>ACHIEVEMENT OF INTERVIEWER <br>
            <strong><?=$tb_gabint[0]['projname'] ;?></strong>
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

                                <table border="1" cellpadding="3" cellspacing="0" width=700>
                                    <thead>
                                        <tr height=20 style='height:15.0pt' ; bgcolor="dodgerblue">
                                            <th rowspan=2 class=xl120 style='height:30.75pt;  width:30px'>
                                                <font color="white">No</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:200px'>
                                                <font color="white">CODE INTV</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">NAME</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">TELP</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">VENDOR NAME</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">TARGET</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">ACH</font>
                                            </th>
                                            <th rowspan=2 class=xl122 style='width:40px'>
                                                <font color="white">SHORTFALL</font>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        <?php foreach ($tb_gabint as $row) {
                                            $i = $i + 1 ?>
                                            <tr style="font-size:11.5px">
                                                <td><?= $i; ?></td>
                                                <td><a><?= $row['codeint']; ?></a></td>
                                                <td><a><?= $row['nama_int']; ?></a></td>
                                                <td><a><?= $row['telp']; ?></a></td>
                                                <td><a><?= $row['vendorname']; ?></a></td>
                                                <td><a><?= $row['target']; ?></a></td>
                                                <td><a><?= $row['ach']; ?></a></td>
                                                <?php if ($row['target'] > 0) {?>
                                                    <td><a><?= round($row['ach']/$row['target']*100,0);?>%</a></td>
                                                <?php if ($row['target'] == 0) {?>
                                                    <td><a>-</a></td>
                                                <?php } ?>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <br>



                       
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
<?php
require 'functionconnsql.php';
$skarang = date("Y-m-d");
//$$$$$$$$$$$$$$$$$$$$$$$$$START FUNCTION $$$$$$$$$$$$$$$$$$$$$$ 
function datedifference($date_1, $date_2)
{

    $date1 = date_create($date_1);
    $date2 = date_create($date_2);
    $diff = date_diff($date1, $date2);
    $hsl = $diff->format("%R%a days");
    $hsl = str_replace("+", "", $hsl);
    $hsl = str_replace(" days", "", $hsl);
    return $hsl;
}

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
//$$$$$$$$$$$$$$$$$$$$$$$$$END FUNCTION $$$$$$$$$$$$$$$$$$$$$$

$strquery = "SELECT VendorName as RTD_Company_Name,ID_INTV_LAMA as RTD_User_ID,IDVENDOR as RTD_IDVENDOR  FROM RTD_masterdata GROUP BY RTD_User_ID";
$bantu01 = mysqli_query($conn, $strquery);
$master_rtd = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $master_rtd[] = $row;
}
$arr_idrtd = array_column($master_rtd, 'RTD_User_ID');

$strquery = "SELECT id_vendor as VEN_ID,provinsi as VEN_PROV,vendor_name as VEN_NAME,kota_area_cakupan as VEN_AREA,pic as VEN_PIC,telp_pic as VEN_TELPPIC  FROM RTD_vendor GROUP BY VEN_ID";
$bantu01 = mysqli_query($conn, $strquery);
$SUMMVENDOR = [];
$arr_idvendor = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SUMMVENDOR[] = $row;
}
//print_r($SUMMVENDOR);
$arr_idvendor = array_column($SUMMVENDOR, 'VEN_ID');
// print_r($arr_idvendor);
// die();


$strquery = "SELECT PROJ_KODENWB,PROJ_ID10DGT,PROJ_name_parent,PROJ_Field_End,PROJ_Field_End_Adj FROM tb_Project_ownership WHERE PROJ_StatusFieldFinal=1  GROUP BY PROJ_KODENWB";
$bantu01 = mysqli_query($conn, $strquery);
$tb_owner = [];
$id_own = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    // $tb_owner1[] = $row;
    // if(datedifference($skarang,$row['PROJ_Field_End_Adj'])>=0){
    $bantu = [];
    $bantu['PROJ_KODENWB'] = $row['PROJ_KODENWB'];
    $bantu['PROJ_ID10DGT'] = $row['PROJ_ID10DGT'];
    $bantu['PROJ_name_parent'] = $row['PROJ_name_parent'];
    $bantu['PROJ_Field_End_Adj'] = $row['PROJ_Field_End_Adj'];
    $bantu['selisih_tgl'] = datedifference($skarang, $row['PROJ_Field_End_Adj']);
    $tb_owner[] = $bantu;
    // }
}
// print_r($tb_owner);
$id_own = array_column($tb_owner, 'PROJ_KODENWB');
// print_r($id_own);
// die();


// $strquery = "SELECT *  FROM tb_NWB  LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB WHERE PROJ_StatusFieldFinal=1 GROUP BY NWB_INT";
// $bantu01 = mysqli_query($conn, $strquery);
// $bantu02 = [];
// while ($row = mysqli_fetch_assoc($bantu01)) {
//     $bantu02[] = $row;
// }
// $arr_intvw = array_column($bantu02, 'NWB_INT');
// $strquery = "SELECT NWB_INT,NWB_StartDate  FROM tb_NWB GROUP BY NWB_StartDate";
// $bantu01 = mysqli_query($conn, $strquery);
// $bantu02 = [];
// while ($row = mysqli_fetch_assoc($bantu01)) {
//     $bantu02[] = $row;
// }
// $arr_date = array_column($bantu02, 'NWB_StartDate');
// $c_intv = COUNT($arr_intvw);
// $min_date = str_replace('-', '/', MIN($arr_date));
// $max_date = str_replace('-', '/', MAX($arr_date));
$c_intv = '';
$min_date = '';
$max_date = '';


//BUAT LIS VENDOR VS JUM INTV
//TESSSS
/*
$strquery = "SELECT PROJ_Symphoni_num,PROJ_Project_name,NWB_ID,NWB_INT,PROJ_Field_End,PROJ_Field_End_Adj,SUM(IF(NWB_STATUS = 'Complete',NWB_Num,0)) AS vValid,SUM(IF(NWB_STATUS = 'Cancelled',NWB_Num,0)) AS vCancel   FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  LEFT JOIN tb_RTD ON tb_NWB.NWB_INT = tb_RTD.RTD_User_ID   WHERE PROJ_StatusFieldFinal=1 and RTD_IDVENDOR LIKE '13824348' GROUP BY NWB_12digit";
$bantu01 = mysqli_query($conn, $strquery);
$TES = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $TES[] = $row;
}
print_r($TES);
// die();
*/

//$strquery = "SELECT * FROM tb_NWB LEFT JOIN tb_RTD ON tb_NWB.NWB_INT = tb_RTD.RTD_User_ID  WHERE RTD_IDVENDOR!=''  GROUP BY NWB_ID,NWB_INT";
$strquery = "SELECT PROJ_Symphoni_num,PROJ_Project_name,NWB_ID,NWB_INT,PROJ_Field_End,PROJ_Field_End_Adj,SUM(IF(NWB_STATUS = 'Complete',NWB_Num,0)) AS vValid,SUM(IF(NWB_STATUS = 'Cancelled',NWB_Num,0)) AS vCancel   FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1  GROUP BY NWB_12digit,NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
if (!$bantu01) {
    echo mysqli_error($bantu01);
}
$bantu02 = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    // if(datedifference($skarang,$row['PROJ_Field_End_Adj'])>=0){
    $bantu = [];
    $bantu['PROJ_Symphoni_num'] = $row['PROJ_Symphoni_num'];
    $bantu['NWB_ID'] = $row['NWB_ID'];
    $bantu['NWB_INT'] = $row['NWB_INT'];
    $bantu['PROJ_projname'] = $row['PROJ_Project_name'];
    $bantu['vValid'] = $row['vValid'];
    $bantu['vCancel'] = $row['vCancel'];
    $bantu['PROJ_Field_End_Adj'] = $row['PROJ_Field_End_Adj'];
    $bantu02[] = $bantu;
    // }
}
$ArrJumINTPerVendor = [];
//$newarray = array_column($tb_vendorintv, 'RTD_IDVENDOR');
// print_r($bantu02);
// die();

$masterdata = [];
foreach ($bantu02 as $row0) {
    $idint = array_search($row0['NWB_INT'], $arr_idrtd, true);
    $bantu3 = [];
    $bantu3['id'] = $idint;
    $bantu3['NWB_INT'] = $row0['NWB_INT'];
    $bantu3['PROJ_Symphoni_num'] = $row0['PROJ_Symphoni_num'];
    $bantu3['PROJ_projname'] = $row0['PROJ_projname'];
    $bantu3['NWB_ID'] = $row0['NWB_ID'];
    $bantu3['vValid'] = $row0['vValid'];
    $bantu3['vCancel'] = $row0['vCancel'];
    if (!($idint == '')) {
        $bantu3['RTD_IDVENDOR'] = $master_rtd[$idint]['RTD_IDVENDOR'];
        $bantu3['RTD_Company_Name'] = $master_rtd[$idint]['RTD_Company_Name'];
        $bantu3['idgab_int'] = $master_rtd[$idint]['RTD_IDVENDOR'] . '#' . $row0['NWB_INT'];
        $bantu3['idgab_proj'] = $master_rtd[$idint]['RTD_IDVENDOR'] . '#' . $row0['PROJ_Symphoni_num'];
    }
    if (($idint == '')) {
        $bantu3['RTD_IDVENDOR'] = '';
        $bantu3['RTD_Company_Name'] = '';
        $bantu3['idgab_int'] = '';
        $bantu3['idgab_proj'] = '';
    }
    $masterdata[] = $bantu3;
}

// //TES TULIS DATA
// $hapus="DELETE FROM CekTb_sementara";
// $conn->query($hapus);
// $id=0;
// foreach ($masterdata as $row) {
//     $sqlstr = "INSERT INTO CekTb_sementara (id, NWB_INT, PROJ_Symphoni_num, NWB_ID,RTD_IDVENDOR,RTD_Company_Name,idgab_int,idgab_proj) VALUES ('";
//     $sqlstr=$sqlstr.$row['id'] ."','";
//     $sqlstr=$sqlstr.$row['NWB_INT'] ."','";
//     $sqlstr=$sqlstr.$row['PROJ_Symphoni_num']."','";
//     $sqlstr=$sqlstr.$row['NWB_ID']."','";
//     $sqlstr=$sqlstr.$row['RTD_IDVENDOR']."','";
//     $sqlstr=$sqlstr.$row['RTD_Company_Name']."','";
//     $sqlstr=$sqlstr.$row['idgab_int']."','";
//     $sqlstr=$sqlstr.$row['idgab_proj'] ."')";
//     print_r($sqlstr);
//     $conn->query($sqlstr);
// }

// die();

// print_r($masterdata);
// die();
$columns = array_column($masterdata, "idgab_proj");
array_multisort($columns, SORT_DESC, $masterdata);
// print_r($masterdata);

$aruniq_vendor_int = [];
$aruniq_vendor_proj = [];
$ar_vendor_int = [];
$ar_summary_vendor_int = [];
$ar_summary_vendor_proj = [];
$ar_uniq_vendor = [];
$ar_uniq_vendor2 = [];
$hitung = 0;
$hitungporj = 0;
foreach ($masterdata as $row) {
    if (!in_array($row['idgab_int'], $aruniq_vendor_int)) {
        $aruniq_vendor_int[] = $row['idgab_int'];
        if (!in_array($row['RTD_IDVENDOR'], $ar_uniq_vendor)) {
            $ar_uniq_vendor[] = $row['RTD_IDVENDOR'];
            $bantu2 = [];
            $bantu2['RTD_IDVENDOR'] = $row['RTD_IDVENDOR'];
            $bantu2['JUMINT'] = 1;
            $bantu2['JUMVALID'] = $row['vValid'];
            $bantu2['JUMCANCEL'] = $row['vCancel'];
            $ar_summary_vendor_int[] = $bantu2;
            $hitung = 1;
            $hitungvalid = $row['vValid'];
            $hitungcancel = $row['vCancel'];
        }
        if (in_array($row['RTD_IDVENDOR'], $ar_uniq_vendor)) {
            $id = array_search($row['RTD_IDVENDOR'], $ar_uniq_vendor, true);
            $ar_summary_vendor_int[$id]['JUMINT'] = $hitung;
            $ar_summary_vendor_int[$id]['JUMVALID'] = $hitungvalid;
            $ar_summary_vendor_int[$id]['JUMCANCEL'] = $hitungcancel;
            $hitung++;
            $hitungvalid = $hitungvalid + $row['vValid'];
            $hitungcancel = $hitungcancel + $row['vCancel'];
        }
        // $bantu=[];
        // $bantu['RTD_IDVENDOR'] = $row['RTD_IDVENDOR'];
        // $bantu['NWB_INT'] = $row['NWB_INT'];
        // // $hitung++;
        // $ar_vendor_int[] = $bantu;
    }
    if (!in_array($row['idgab_proj'], $aruniq_vendor_proj)) {
        $aruniq_vendor_proj[] = $row['idgab_proj'];
        if (!in_array($row['RTD_IDVENDOR'], $ar_uniq_vendor2)) {
            $ar_uniq_vendor2[] = $row['RTD_IDVENDOR'];
            $bantu2 = [];
            $bantu2['RTD_IDVENDOR'] = $row['RTD_IDVENDOR'];
            $bantu2['JUMPROJ'] = 1;
            $bantu2['JUMVALIDPROJ'] = $row['vValid'];
            $bantu2['JUMCANCELPROJ'] = $row['vCancel'];
            $ar_summary_vendor_proj[] = $bantu2;
            $hitungporj = 1;
            $hitungvalid = $row['vValid'];
            $hitungcancel = $row['vCancel'];
        }
        if (in_array($row['RTD_IDVENDOR'], $ar_uniq_vendor2)) {
            $id = array_search($row['RTD_IDVENDOR'], $ar_uniq_vendor2, true);
            $ar_summary_vendor_proj[$id]['JUMPROJ'] = $hitungporj;
            $ar_summary_vendor_proj[$id]['JUMVALIDPROJ'] = $hitungvalid;
            $ar_summary_vendor_proj[$id]['JUMCANCELPROJ'] = $hitungcancel;
            $hitungporj++;
            $hitungvalid = $hitungvalid + $row['vValid'];
            $hitungcancel = $hitungcancel + $row['vCancel'];
        }
    }
}

// print_r($ar_summary_vendor_int);
// print_r($ar_summary_vendor_proj);


$db_vendor = [];
$jum = 0;
$arrjumproj = array_column($ar_summary_vendor_proj, 'RTD_IDVENDOR');
$arrjumint = array_column($ar_summary_vendor_int, 'RTD_IDVENDOR');
// $arr_vendorid = array_column($SUMMVENDOR, 'VEN_ID');
$idproj = -1;
$idint = -1;
foreach ($SUMMVENDOR as $rowvendor) {
    $idproj = array_search($rowvendor['VEN_ID'], $arrjumproj, true);
    $idint = array_search($rowvendor['VEN_ID'], $arrjumint, true);
    // $idactive = array_search($rowvendor['VEN_ID'], $id_own1, true); 
    // if($idactive!=''){
    $arbantu0 = [];
    $jum = 0;
    $arbantu0['RTD_IDVENDOR'] = $rowvendor['VEN_ID'];
    // $arbantu0['id'] = $id;
    $arbantu0['idproj'] = $idproj;
    $arbantu0['idint'] = $idint;
    $arbantu0['VEN_PIC'] = $rowvendor['VEN_PIC'];
    $arbantu0['VEN_AREA'] = $rowvendor['VEN_AREA'];
    $arbantu0['VEN_NAME'] = $rowvendor['VEN_NAME'];
    $arbantu0['VEN_PROV'] = $rowvendor['VEN_PROV'];
    $arbantu0['VEN_TELPPIC'] = $rowvendor['VEN_TELPPIC'];
    if (!($idproj == '')) {
        $arbantu0['COUNT_PROJ'] = $ar_summary_vendor_proj[$idproj]['JUMPROJ'];
        $arbantu0['JUMVALIDPROJ'] = $ar_summary_vendor_proj[$idproj]['JUMVALIDPROJ'];
        $arbantu0['JUMCANCELPROJ'] = $ar_summary_vendor_proj[$idproj]['JUMCANCELPROJ'];
    } else {
        $arbantu0['COUNT_PROJ'] = 0;
        $arbantu0['JUMVALIDPROJ'] = 0;
        $arbantu0['JUMCANCELPROJ'] = 0;
    }
    if (!($idint == '')) {
        $arbantu0['COUNT_INTV'] = $ar_summary_vendor_int[$idint]['JUMINT'];
        $arbantu0['JUMVALID'] = $ar_summary_vendor_int[$idint]['JUMVALID'];
        $arbantu0['JUMCANCEL'] = $ar_summary_vendor_int[$idint]['JUMCANCEL'];
    } else {
        $arbantu0['COUNT_INTV'] = 0;
        $arbantu0['JUMVALID'] = 0;
        $arbantu0['JUMCANCEL'] = 0;
    }

    $db_vendor[] = $arbantu0;
    // }
}
// print_r($db_vendor);
// die();








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
                <!--<strong>-->
                <!--    <font color="darkblue">DATE : <?= $min_date ?> - <?= $max_date ?></font>-->
                <!--</strong></br>-->
                <!--<strong>-->
                <!--    <font color="darkblue">TOTAL INTERVIEWER : <?= $c_intv ?></font>-->
                <!--</strong>-->
            </h1><br>
        </div>


        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="float-right ml-4">
                    <a href="<?= site_url('/export') ?>" class="btn btn-primary">
                        <i class="fas fa-file-download"></i> Export Data
                    </a><br><br>
                    <form method="post" action="<?= site_url('/import') ?>" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" name="fileexcel" class="form-control" id="file" required accept=".xls, .xlsx" /></p>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Upload</button>
                        </div>
                    </form>
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
                                <th rowspan=2 class=xl122 style='width:10px'>
                                    <font color="white">%DROP</font>
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
                                    <td><a href="/db_rtd_vendor_proj?NWB_10digit=<?= $row['RTD_IDVENDOR'] . ';' . $row['COUNT_PROJ'] . ';' . $row['VEN_NAME']; ?>"><?= $row['COUNT_PROJ']; ?></a></td>
                                    <td><a href="/db_rtd_vendor_int?NWB_10digit=<?= $row['RTD_IDVENDOR'] . ';' . $row['COUNT_INTV'] . ';' . $row['VEN_NAME']; ?>"><?= $row['COUNT_INTV']; ?></a></td>
                                    <?php if (($row['JUMVALID'] + $row['JUMCANCEL']) > 0) { ?>
                                        <td><?= round($row['JUMCANCEL'] / ($row['JUMVALID'] + $row['JUMCANCEL']) * 100, 0); ?>% (<?= ($row['JUMVALID'] + $row['JUMCANCEL']); ?>)</td>
                                    <?php } else { ?>
                                        <td>-</td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>

                    <footer class="main-footer">
                        <div class="footer-left">

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
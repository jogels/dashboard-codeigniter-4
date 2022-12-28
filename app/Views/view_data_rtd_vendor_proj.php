<?php
require 'functionconnsql.php';
$skarang = date("Y-m-d");

$Index_DB=$_GET["NWB_10digit"];
//var_dump($Index_DB);
$pos_plus=strpos($Index_DB,";");
$idvendor=trim(substr($Index_DB,0,$pos_plus));
$nilai=trim(substr($Index_DB,$pos_plus+1,strlen($Index_DB)-$pos_plus));
$pos=strpos($nilai,';');
$namavendor=substr($nilai,$pos+1,strlen($nilai));
// var_dump($idvendor);
//die();

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


//$strquery="SELECT *  FROM tb_vendor GROUP BY VEN_ID" ;
$strquery = "SELECT id_vendor as VEN_ID,provinsi as VEN_PROV,vendor_name as VEN_NAME,kota_area_cakupan as VEN_AREA,pic as VEN_PIC,telp_pic as VEN_TELPPIC  FROM RTD_vendor GROUP BY VEN_ID";
$bantu01=mysqli_query($conn,$strquery); 
$SUMMVENDOR=[];
while ($row = mysqli_fetch_assoc($bantu01)) {
       $SUMMVENDOR[]=$row;
}
//print_r($SUMMVENDOR);


$strquery = "SELECT PROJ_KODENWB,PROJ_Symphoni_num,PROJ_name_parent,PROJ_Field_End  FROM tb_Project_ownership WHERE PROJ_StatusFieldFinal=1 GROUP BY PROJ_KODENWB";
$bantu01 = mysqli_query($conn, $strquery);
$tb_owner = [];
$id_own = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    // if(datedifference($skarang,$row['PROJ_Field_End'])>=0){
        $bantu=[];
        $bantu['PROJ_KODENWB']=$row['PROJ_KODENWB'];
        $bantu['PROJ_name_parent']=$row['PROJ_name_parent'];
        $bantu['PROJ_Field_End']=$row['PROJ_Field_End'];
        $bantu['selisih_tgl']=datedifference($skarang,$row['PROJ_Field_End']);
        $tb_owner[]=$bantu;
    // }
}


$colomown=array_column($tb_owner,'PROJ_KODENWB');
$strquery="SELECT NWB_INT,NWB_12digit,NWB_IDPROJ,NWB_ID,IDVENDOR as RTD_IDVENDOR,SUM(IF(NWB_STATUS = 'Complete',NWB_Num,0)) AS vValid,SUM(IF(NWB_STATUS = 'Cancelled',NWB_Num,0)) AS vCancel  FROM tb_NWB LEFT JOIN RTD_masterdata ON tb_NWB.NWB_INT = RTD_masterdata.ID_INTV_LAMA  WHERE RTD_masterdata.IDVENDOR LIKE '".$idvendor."' GROUP BY NWB_12digit,NWB_INT,NWB_ID" ;
$bantu01=mysqli_query($conn,$strquery); 
$bantu03=[];
while ($row = mysqli_fetch_assoc($bantu01)) {
  $id = array_search($row['NWB_ID'], $colomown, true); 
  if($id!=''){
        $bantu02=[];    
        $bantu02['NWB_INT']=$row['NWB_INT'];
        $bantu02['NWB_12digit']=$row['NWB_12digit'];
        $bantu02['NWB_IDPROJ']=$row['NWB_IDPROJ'];
        $bantu02['NWB_ID']=$row['NWB_ID'];
        $bantu02['RTD_IDVENDOR']=$row['RTD_IDVENDOR'];
        $bantu02['vValid']=$row['vValid'];
        $bantu02['vCancel']=$row['vCancel'];
        $bantu02['idgab']=$bantu02['NWB_12digit'].'-'.$bantu02['NWB_INT'];
        $bantu03[]=$bantu02;
  }
}
// print_r($bantu03);
// die();
$columns = array_column($bantu03, "idgab");
array_multisort($columns, SORT_DESC, $bantu03);
// print_r($bantu03);

$db_proj=[];
$cekunikproj=[];
$cekunikint=[];
$newarray=array_column($tb_owner,'PROJ_KODENWB');
$newarray2=array_column($bantu03,'idgab');
foreach($bantu03 as $row){
    $id=array_search($row['NWB_ID'],$newarray,true);
    if(!($id=='')){
        if (!in_array($row['NWB_12digit'], $cekunikproj)) {
            $cekunikproj[]=$row['NWB_12digit'];
            $cekunikint=[];
            $bantu=[];
            $cekunikint[]=$row['idgab'];
            $bantu['NWB_12digit']=$row['NWB_12digit'];
            $bantu['PROJ_name_parent']=$tb_owner[$id]['PROJ_name_parent'];
            $countint=1;
            $bantu['CINT']=1;
            $cvalid = $row['vValid'];
            $ccancel = $row['vCancel'];
            $db_proj[]=$bantu;
        }        
        if (in_array($row['NWB_12digit'], $cekunikproj)) {
            $id2 = array_search($row['NWB_12digit'], $cekunikproj, true); 
            $db_proj[$id2]['CINT']=$countint;
            $db_proj[$id2]['JUMVALID']=$cvalid;
            $db_proj[$id2]['JUMCANCEL']=$ccancel;
            $countint++;
            $cvalid = $cvalid + $row['vValid'];
            $ccancel = $ccancel + $row['vCancel'];
        }
    }
}
// print_r($cekunikproj); 
// print_r($db_proj);







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
                    <font color="darkblue"><?= 'LOAD VENDOR - '?><?=$namavendor?> - <?=$idvendor?></font>
                </strong></br>
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
                                    <font color="white">SYMPHONY</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:140px'>
                                    <font color="white">PROJECT NAME</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:10px'>
                                    <font color="white">#INTV</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:10px'>
                                    <font color="white">%Drop (base)</font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <?php foreach ($db_proj as $row) {
                                $i = $i + 1 ?>
                                <tr style="font-size:11.5px">
                                    <td><?= $i; ?></td>
                                    <td><a><?= $row['NWB_12digit']; ?></a></td>
                                    <td><a><?= $row['PROJ_name_parent']; ?></a></td>
                                    <!--<td><a href="/db_rtd_vendor_int?NWB_10digit=<?= $row['NWB_12digit'] . ';' . $row['CINT']; ?>"><?= $row['CINT']; ?></a></td>-->
                                    <td><a><?= $row['CINT']; ?></a></td>
                                    <?php if (($row['JUMVALID']+$row['JUMCANCEL'])>0){?>
                                        <td><a><?= round($row['JUMCANCEL']/($row['JUMVALID']+$row['JUMCANCEL']),1); ?>% (<?= ($row['JUMVALID']+$row['JUMCANCEL']); ?>)</a></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                    
                    <footer class="main-footer">
    <div class="footer-left">
        <!-- Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a> -->
    </div>
    <!--<div class="footer-right">-->
    <!--    2.3.0-->
    <!--</div>-->
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
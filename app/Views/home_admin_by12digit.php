<?php
date_default_timezone_set("Asia/Bangkok");

require 'functionconnsql.php';
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


$strquery = "SELECT PROJ_Symphoni_num, SUM(QC_Actual_Achievement) as QC_SumACT, SUM(QC_QC_Drop_Total) as QC_SumDROP FROM tb_QC LEFT JOIN tb_Project_ownership ON QC_NWBID=PROJ_KODENWB WHERE PROJ_StatusFieldFinal=1 GROUP BY PROJ_Symphoni_num";
$bantu01 = mysqli_query($conn, $strquery);
$SummQC = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummQC[] = $row;
}
// print_r($SummQC);
// die();

$strquery = "SELECT NWB_ID,NWB_12digit,NWB_INT,SUM(NWB_Num) as SUMACH,MIN(NWB_Num) as MINACH FROM tb_NWB  LEFT JOIN tb_Project_ownership ON NWB_ID=PROJ_KODENWB WHERE NWB_STATUS LIKE 'Complete' AND PROJ_StatusFieldFinal=1 GROUP BY NWB_12digit,NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
$SummINTV = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummINTV[] = $row;
}
$SummINTV_gab = [];
foreach ($SummINTV as $row) {
    $bantu = [];
    $bantu['IDGABUNG'] = $row['NWB_ID'];
    // $bantu['NWB_10digit'] = $row['NWB_10digit'];
    $bantu['NWB_12digit'] = $row['NWB_12digit'];
    $bantu['NWB_INT'] = $row['NWB_INT'];
    $bantu['MINACH'] = $row['MINACH'];
    $bantu['SUMACH'] = $row['SUMACH'];
    $SummINTV_gab[] = $bantu;
}
// print_r($SummINTV_gab);
// die();
$aruniq = [];
$jumuniq = 0;
foreach ($SummINTV_gab as $row) {
    if (!in_array($row['IDGABUNG'], $aruniq)) {
        $aruniq[] = $row['IDGABUNG'];
        $jumuniq++;
    }
}
//print_r($aruniq);
//$newarray=array_column($SummINTV, 'NWB_12digit');
//print_r($aruniq);
$arr_intvload = [];
foreach ($aruniq as $row1) {
    $jum = 0;
    $bantu00 = [];
    $bantu00['IDGABUNG'] = "";
    $bantu00['NWB_10digit'] = "";
    $bantu00['NWB_INT'] = "";
    foreach ($SummINTV_gab as $row2) {
        if ($row1 == $row2['IDGABUNG']) {
            $jum++;
            $bantu00['IDGABUNG'] = $row2['IDGABUNG'];
            // $bantu00['NWB_10digit'] = $row2['NWB_10digit'];
            $bantu00['NWB_12digit'] = $row2['NWB_12digit'];
            //$bantu00['NWB_IDPROJ']=$row2['NWB_IDPROJ']; 
            //$bantu00['NWB_INT']=$row2['NWB_INT'];
        }
    }
    $bantu00['NWB_INT'] = $jum;
    $arr_intvload[] = $bantu00;
}
//print_r($arr_intvload);
//die("");

//$str1 = "SELECT NWB_ID,NWB_10digit,NWB_12digit,NWB_IDPROJ,TimeDownload,COUNT(NWB_Num) as COUNTACH,SUM(NWB_Num) as SUMACH ";
$str1 = "SELECT *,COUNT(NWB_Num) as COUNTACH,SUM(NWB_Num) as SUMACH ";
$str2 = " FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' GROUP BY NWB_12digit,NWB_ID";
$strqry = $str1 . " " . $str2;
$bantu01 = mysqli_query($conn, $strqry);
$SummNWB = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummNWB[] = $row;
}
//print_r($SummNWB);
//die();

//=====>hitung minimal untuk varian
$str1 = "SELECT NWB_ID, NWB_10digit,NWB_12digit,NWB_IDPROJ,TimeDownload,COUNT(NWB_Num) as COUNTACH,SUM(NWB_Num) as SUMACH ";
$str2 = " FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' GROUP BY NWB_ID";
$strqry = $str1 . " " . $str2;
$bantu01 = mysqli_query($conn, $strqry);
$bantu = [];
$row = [];
$ar_ach=[];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu[] = $row;
    $ar_ach[]=$row;
}
$aruniq = [];
$jumuniq = 0;
foreach ($bantu as $row) {
    //if(!in_array($row['NWB_10digit'],$aruniq)){
    if (!in_array($row['NWB_ID'], $aruniq)) {
        $aruniq[] = $row['NWB_ID'];
        $jumuniq++;
    }
}
$arr_varian = [];
//cari nilai minimal SUMACH
foreach ($aruniq as $row1) {
    $jum = 10000000;
    $bantu00 = [];
    foreach ($bantu as $row2) {
        if ($row1 == $row2['NWB_ID']) {
            if ($jum > $row2['SUMACH']) {
                $jum = $row2['SUMACH'];
                $bantu00['NWB_ID'] = $row2['NWB_ID'];
            };
            $bantu00['NWB_10digit'] = $row2['NWB_10digit'];
        }
    }
    $bantu00['NWB_MINACH'] = $jum;
    $arr_varian[] = $bantu00;
}
//print_r($ar_ach);
//print_r($arr_varian);
// die();

$ddate = "2022-01-10";
//$ddate = date("Y-m-d");
$duedt = explode("-", $ddate);
$date = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
$week = (int)date('W', $date);
//echo "Weeknummer: " . $week;

//var_dump($week);
//die();

////==========final 
$strquery0=" PROJ_KODENWB,PROJ_SFM,PROJ_Symphoni_num,PROJ_Remark,PROJ_name_parent,PROJ_STATQC,PROJ_StatusFieldFinal,PROJ_Status_DP,";
$strquery1="MIN(PROJ_Target) as Min_Target,SUM(PROJ_Target) as Sum_Target, MIN(PROJ_Field_start) as minPROJ_Field_start,MAX(PROJ_Field_End) as maxPROJ_Field_End ";
$strquery = "SELECT".$strquery0.$strquery1." FROM tb_Project_ownership WHERE PROJ_Status_DP=1 or PROJ_StatusFieldFinal = 1 GROUP BY PROJ_Symphoni_num";
$bantu01 = mysqli_query($conn, $strquery);
$SummPROJ = [];
$row = [];
$bantu = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu['PROJ_KODENWB'] = $row['PROJ_KODENWB'];
    $bantu['PROJ_SFM'] = $row['PROJ_SFM'];
    // $bantu['PROJ_IDGAB'] = $row['PROF_ID10DGT'];
    // $bantu['PROF_ID10DGT'] = $row['PROF_ID10DGT'];
    $bantu['PROJ_Target'] = $row['Min_Target'];
    $bantu['PROJ_Field_start'] = $row['minPROJ_Field_start'];
    $bantu['PROJ_Field_End'] = $row['maxPROJ_Field_End'];
    // $bantu['PROJ_DP_End'] = $row['PROJ_DP_End'];
    $bantu['PROJ_Symphoni_num'] = $row['PROJ_Symphoni_num'];
    $bantu['PROJ_Remark'] = $row['PROJ_Remark'];
    // $bantu['PROJ_Project_name'] = $row['PROJ_Project_name'];
    $bantu['PROJ_name_parent'] = $row['PROJ_name_parent'];
    $bantu['PROJ_STATQC'] = $row['PROJ_STATQC'];
    $bantu['PROJ_StatusFieldFinal'] = $row['PROJ_StatusFieldFinal'];
    $bantu['PROJ_Status_DP'] = $row['PROJ_Status_DP'];
    $SummPROJ[] = $bantu;
}
print_r($SummPROJ);  
die();
$datenow = date("Y-m-d");
$arr_dashboard = [];

$newarray = array_column($SummPROJ, 'PROJ_KODENWB');
$newarray2 = array_column($arr_intvload, 'IDGABUNG');
$newarray3 = array_column($SummQC, 'QC_NWBID');
$newarray5 = array_column($SummNWB, 'NWB_ID');
$newarray4 = array_column($ar_ach, 'NWB_ID');
// $newarray4 = array_column($arr_varian, 'NWB_ID');
$skarang = date("Y-m-d");
foreach ($SummPROJ as $row) {

    $id = array_search($row['PROJ_KODENWB'], $newarray, true);
    $id2 = array_search($row['PROJ_KODENWB'], $newarray2, true);
    $id3 = array_search($row['PROJ_KODENWB'], $newarray3, true);
    $id4 = array_search($row['PROJ_KODENWB'], $newarray4, true);
    // $id4 = array_search($row['PROJ_KODENWB'], $newarray4, true);
    $id5 = array_search($row['PROJ_KODENWB'], $newarray5, true);

    // if ($row['PROJ_Field_start'] != '0000-00-00' ) {
        //if ($row['PROJ_StatusFieldFinal'] == 1 && (datedifference($row['PROJ_Field_start'], $skarang))>=0) {
        if ($row['PROJ_StatusFieldFinal'] == 1 && (((datedifference($row['PROJ_Field_start'], $skarang))+0)>0&&((datedifference($row['PROJ_Field_End'], $skarang))+0)<=0) ) {
            $bantu = [];
            $bantu['SummPROJ'] = $id;
            $bantu['arr_intvload'] = $id2;
            $bantu['SummQC'] = $id3;
            $bantu['AR_AC'] = $id4;
            $bantu['SummNWB'] = $id5;
            $bantu['CekStartFW'] = datedifference($row['PROJ_Field_start'], $skarang)+0;
            //$index = 0;
            if((datedifference($row['PROJ_Field_start'], $skarang)+0)<=0) {$bantu['Status'] = '1. DP:Scripting';}
            if(((datedifference($row['PROJ_Field_start'], $skarang))+0)>0&&((datedifference($row['PROJ_Field_End'], $skarang))+0)<=0) {$bantu['Status'] = '2. FW Stage';}
            if(((datedifference($row['PROJ_Field_End'], $skarang))+0)>0) {$bantu['Status'] = '3. DP:Tabulation';}
            if ($row['PROJ_Field_start'] != '0000-00-00') {$lfw = datedifference($row['PROJ_Field_start'], $row['PROJ_Field_End']);} else {$lfw='';}
            if($lfw==0)$lfw=1;
            $lnowtoend = datedifference($skarang, $row['PROJ_Field_End']);
            $lstarttonow = datedifference($row['PROJ_Field_start'], $skarang)+0;
            $bantu['NWB_12digit'] = $row['PROJ_Symphoni_num'];
            if (!($id5=='')) {$bantu['TimeDownload'] = $SummNWB[$id5]['TimeDownload'];}else{$bantu['TimeDownload']='';}
            if (!($id2=='')) {$bantu['NWB_INT_ACT'] = $arr_intvload[$id2]['NWB_INT'];}else{$bantu['NWB_INT_ACT']=0;}
            $bantu['PROJ_NAME'] = $row['PROJ_name_parent'];
            $bantu['PROJ_SFM'] = $row['PROJ_SFM'];
            // if(!empty($id4)){$bantu['NWB_ID'] = $arr_varian[$id4]['NWB_ID'];}else{$bantu['NWB_ID']=$row['PROJ_KODENWB'];}
            $bantu['NWB_ID'] = $row['PROJ_KODENWB'];
            // if(!($id4=='')){$bantu['PROJ_NAMEORIGINAL'] = $ar_ach[$id4]['NWB_ID'];}else{$bantu['PROJ_NAMEORIGINAL']='-';}
            // if(!($id4=='')){$bantu['PROJ_NAMEORIGINAL'] = $arr_varian[$id4]['NWB_ID'];}else{$bantu['PROJ_NAMEORIGINAL']='-';}
            if(!($id4=='')){$bantu['PROJ_NAMEORIGINAL'] = $ar_ach[$id4]['NWB_ID'];}else{$bantu['PROJ_NAMEORIGINAL']='-';}
            $bantu['PROJ_Target'] = round($row['PROJ_Target'], 0);
            $bantu['PROJ_Field_start'] = $row['PROJ_Field_start'];
            $bantu['PROJ_Field_End'] = $row['PROJ_Field_End'];
            // if(!empty($id4)){$bantu['NWB_ACH'] = $arr_varian[$id4]['NWB_MINACH'];}else{$bantu['NWB_ACH']='-';}
            if(!($id4=='')){$bantu['NWB_ACH'] = $ar_ach[$id4]['SUMACH'];}else{$bantu['NWB_ACH']='-';}
            $bantu['PROJ_DP_End'] = $row['PROJ_DP_End'];
            $bantu['PROJ_STATQC'] = $row['PROJ_STATQC'];
            $bantu['remark'] = $row['PROJ_Remark'];
            $bantu['DailyRemain'] = '';
            $bantu['now'] = $skarang;
            if ($row['PROJ_Field_start'] != '0000-00-00') {$bantu['PCT_TIME'] = round($lstarttonow / $lfw * 100, 0);} {$bantu['PCT_TIME'] ='-';}
            $bantu['PCT_TIME'] = round($lstarttonow / $lfw * 100, 0);
            // if ($row['PROJ_Target'] > 0) $bantu['PCT_ACH'] = round($arr_varian[$id4]['NWB_MINACH'] / $row['PROJ_Target'] * 100, 0);
            if ($row['PROJ_Target'] > 0 && !($id4=='')) {$bantu['PCT_ACH'] = round($ar_ach[$id4]['SUMACH'] / $row['PROJ_Target'] * 100, 0);}else {$bantu['PCT_ACH'] = 0;}
            if ($row['PROJ_Field_start'] != '0000-00-00') {$rasiotime = $lstarttonow / $lfw;} {$rasiotime ='-';}
            
            //if($rasiotime>1) $rasiotime=1;

            if($rasiotime!='-'){$hitrasio = $rasiotime * $row['PROJ_Target'];} else {$hitrasio=0;}
            //if ($hitrasio > 0) $index = $arr_varian[$id4]['NWB_MINACH'] / $hitrasio;
            if (!($id5=='')&&!($id2=='')) {$bantu['AVGLOAD'] = round($SummNWB[$id5]['SUMACH'] / $arr_intvload[$id2]['NWB_INT'], 0);} else {$bantu['AVGLOAD']=0;}
            //if (!empty($id5)) {$bantu['AVGLOAD'] = round($SummNWB[$id5]['SUMACH'] , 0);} else {$bantu['AVGLOAD']=0;}
            $bantu['cekLongfw'] = $lfw;
            $bantu['cekstartonow'] = $lstarttonow;
            $bantu['ceknowtoend'] = $lnowtoend;
            if(!($id3=='')){
                $bantu['QC_Metodologi'] = $SummQC[$id3]['QC_Metodologi'];
                $bantu['QC_QC_Drop_Total'] = $SummQC[$id3]['QC_SumDROP'];
                $bantu['QC_QC_Remark'] = $SummQC[$id3]['QC_QC_Remark'];
                $bantu['QC_Actual_Achievement'] = $SummQC[$id3]['QC_SumACT'];
            }else{
                $bantu['QC_Metodologi'] = '-';
                $bantu['QC_QC_Drop_Total'] = '-';
                $bantu['QC_QC_Remark'] = '-';
                $bantu['QC_Actual_Achievement'] = '-';
            }
            // if($lfw!='') {if ($lnowtoend < 0) $index = ($lnowtoend / $lfw);}
            //if($lfw!='') {if ($lnowtoend < 0) $index = round($bantu['PCT_ACH'] / $bantu['PCT_TIME']*100,0);}
            //if ($lnowtoend >= 0) $index;
            //$bantu['index'] = $index ;
            if(!($id4=='')) {$bantu['INDEXPCT'] = round($bantu['PCT_ACH'] / $bantu['PCT_TIME']*100,0); ;}else{$bantu['INDEXPCT']=0;}
            if (!($id3=='')) {
                if ($SummQC[$id3]['QC_SumACT'] > 0) {
                    $bantu['QC'] = round($SummQC[$id3]['QC_SumDROP'] / $SummQC[$id3]['QC_SumACT'] * 100, 0) . '%';
                }
                if ($SummQC[$id3]['QC_SumACT'] == 0) {
                    $bantu['QC'] = '0%';
                }
                if ($SummQC[$id3]['QC_SumACT'] == 0 && $SummQC[$id3]['QC_SumDROP'] == 0) {
                    $bantu['QC'] = 'N/A';
                }
            } else {
                $bantu['QC'] = 'N/A';
            }
            if ($id3 == '') {
                $bantu['QC'] = 'N/A';
            }
            $bantu['PROJ_Status_DP'] = $row['PROJ_Status_DP'];
            $bantu['PROJ_StatusFieldFinal']=$row['PROJ_StatusFieldFinal'];
            $bantu['idsort']=$bantu['Status'].'--'.$bantu['PROJ_NAME'];
            $bantu['NWB_10digit'] = $row['PROF_ID10DGT'];
            $bantu['NWB_12digit'] = $row['PROJ_Symphoni_num'];
            $arr_dashboard[] = $bantu;
        }
    // }
}

$timedonload='';
foreach ($arr_dashboard as $row) {
    if(!empty($row['TimeDownload'])){
        $timedonload=$row['TimeDownload'];
        //var_dump($timedonload);
        break;
    }
}

//print_r($timedonload);
// print_r($arr_dashboard);
// die();
//array_sort($arr_dashboard, 'INDEXPCT', SORT_ASC);
//array_sort($arr_dashboard, 'INDEXPCT', SORT_ASC);
$columns = array_column($arr_dashboard, "NWB_12digit");
array_multisort($columns, SORT_ASC, $arr_dashboard);
// print_r($arr_dashboard);
// die();
//sortmulti($arr_dashboard,'INDEXPCT','asc');

$cek_single=[];
$summary_12digit = [];
$bantu=[];
foreach ($arr_dashboard as $row) {
    if (!in_array($row['NWB_12digit'], $cek_single)) {
        $cek_single[]=$row['NWB_12digit'];
        $bantu['PROJ_Target']=$row['PROJ_Target'];
        $bantu['PROJ_Field_start']=$row['PROJ_Field_start'];
        $bantu['PROJ_Field_End']=$row['PROJ_Field_End'];
        $bantu['PROJ_Status_DP']=$row['PROJ_Status_DP'];
        $bantu['PROJ_StatusFieldFinal']=$row['PROJ_StatusFieldFinal'];
        $bantu['PROJ_NAME']=$row['PROJ_NAME'];
        $bantu['']=$row[''];
        $bantu['']=$row[''];
        $bantu['']=$row[''];
        $summary_12digit[]=$bantu;
    }
    if (in_array($row['NWB_INT'], $ar_uniq_proj)) {
        $id = array_search($row['NWB_INT'], $ar_uniq_proj, true); 
        $ar_jum_proj_perint[$id]['jumproj']=$hitung;
        $hitung++;
    }
    
    $id++;
    if(($row['SUMACH'])>0){
        $sqlstr = "INSERT INTO tb_nwb_export (nwb_code,sym_10digit,sym_12digit,proj_name,start_date,int_login,ach_num) VALUES ('";
        $sqlstr=$sqlstr.$row['NWB_ID'] ."','";
        $sqlstr=$sqlstr.$row['NWB_12digit'] ."','";
        $sqlstr=$sqlstr.$row['NWB_IDPROJ'] ."','";
        $sqlstr=$sqlstr.$row['NWB_StartDate'] ."','";
        $sqlstr=$sqlstr.$row['NWB_INT'] ."',";
        $sqlstr=$sqlstr.$row['SUMACH'] .")";
        //print_r($sqlstr);
        //$conn->query($sqlstr);
    }
}


$strquery = "SELECT NWB_ID,NWB_10digit,NWB_12digit,NWB_IDPROJ,NWB_StartDate,NWB_INT,NWB_Quota1,NWB_Quota2,NWB_Quota3,NWB_Quota4,NWB_Quota5,NWB_Quota6,SUM(NWB_Num) as SUMACH FROM tb_NWB LEFT JOIN tb_Project_ownership ON tb_NWB.NWB_ID = tb_Project_ownership.PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1 AND NWB_STATUS LIKE 'Complete' GROUP BY NWB_ID,NWB_INT,NWB_StartDate";
$bantu01 = mysqli_query($conn, $strquery);
$expotdata = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $expotdata[] = $row;
}
$hapus="DELETE FROM tb_nwb_export";
$conn->query($hapus);
$id=0;
foreach ($expotdata as $row) {
    $id++;
    if(($row['SUMACH'])>0){
        $sqlstr = "INSERT INTO tb_nwb_export (nwb_code,sym_10digit,sym_12digit,proj_name,start_date,int_login,ach_num) VALUES ('";
        $sqlstr=$sqlstr.$row['NWB_ID'] ."','";
        $sqlstr=$sqlstr.$row['NWB_12digit'] ."','";
        $sqlstr=$sqlstr.$row['NWB_IDPROJ'] ."','";
        $sqlstr=$sqlstr.$row['NWB_StartDate'] ."','";
        $sqlstr=$sqlstr.$row['NWB_INT'] ."',";
        $sqlstr=$sqlstr.$row['SUMACH'] .")";
        //print_r($sqlstr);
        //$conn->query($sqlstr);
    }
}

?>
<?php require "header.php" ?>;



<!-- MAIN CONTENT -->
<div id="div_refresh">
    <!--<title>Web Ops Indonesia </title>-->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>DASHBOARD</h1>
            </div>
            <?php $session = session() ?>
            <h4>Selamat datang <?php echo $session->get('username') ?> (Anda sebagai Admin) - <strong>LIST OF ACTIVE PROJECTS - FIELD WORK</strong></h4>
           

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">x</button>
                        <b>Success !</b>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                </div>
            <?php endif;  ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">x</button>
                        <b>Error !</b>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                </div>
            <?php endif;  ?>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4></h4>
                    </div>

                    <!-- <div id="div_refresh"> -->
                    <div class="card-box table-responsive" width=40>
                        <h4>
             
                            Upload <?= $timedonload; ?>
                        </h4>
                    <a href="<?=site_url('/home_admin_by12digit')?>" class="btn btn-primary">
                        <i class=""></i> Summary Project
                    </a>
                    <a href="<?=site_url('/home_admin')?>" class="btn btn-primary">
                        <i class=""></i> Active Project
                    </a>
                    <a href="<?=site_url('/home_admin_script')?>" class="btn btn-primary">
                        <i class=""></i> Scripting Process
                    </a>
                    <a href="<?=site_url('/home_admin_tabulasi')?>" class="btn btn-primary">
                        <i class=""></i> Tabulation Process
                    </a>
                    <a href="<?=site_url('/home_admin_close')?>" class="btn btn-primary">
                        <i class=""></i> Close Project
                    </a>
                    <a href="<?=site_url('/home_admin_utility')?>" class="btn btn-primary">
                        <i class=""></i> Utility
                    </a>
                    <a href="<?=site_url('/export_nwb')?>" class="btn btn-primary">
                        <i class=""></i> Export Data
                    </a>
                <br><br>
                        <!-- <a href="<?= site_url('add') ?>" class="btn btn-primary mb-3">Add Data</a> -->
                         <table border="1" cellpadding="3" cellspacing="0" width=100% style='border-collapse:collapse; table-layout:absolute ; font-size:11px'>
                            <thead>
                                <tr height=20 style="font-size:15px" ; bgcolor="dodgerblue">
                                    <th rowspan=2 class=xl120 width=40 style='width:5px'>
                                        <font color="white">No</font>
                                    </th>
                                    <th rowspan=2 class=xl122 width=120 style='width:120px'>
                                        <font color="white">NWB Code</font> 
                                    </th>
                                    <th rowspan=2 class=xl122 width=120 style='width:120px'>
                                        <font color="white">Symphony Code</font> 
                                    </th>
                                    <th rowspan=2 class=xl124 width=200 style='width:200px'>
                                        <font color="white">Project Name</font>
                                    </th>
                                    <th rowspan=2 class=xl124 width=80 style='width:80px'>
                                        <font color="white">FW-Start<br>(YYYY-MM-DD)</font>
                                    </th>
                                    <th rowspan=2 class=xl124 width=80 style='width:80px'>
                                        <font color="white">FW-End<br>(YYYY-MM-DD)</font>
                                    </th>
                                    <th rowspan=2 class=xl124 width=60 style='width:60px'>
                                        <font color="white">Target</font>
                                    </th>
                                    <th rowspan=2 class=xl124 width=60 style='width:60px'>
                                        <font color="white">QC<br>%DROP(Base)</font>
                                    </th>
                                    <th rowspan=2 class=xl132 width=60 style='width:60px'>
                                        <font color="white">Ach<br> </font>
                                    </th>
                                    <th rowspan=2 class=xl124 width=60 style='width:60px'>
                                        <font color="white">Intw. Active</font>
                                    </th>
                                    <!--<th rowspan=2 class=xl132 width=60 style='width:60px'>-->
                                    <!--    <font color="white">Daily-Remain<br> </font>-->
                                    <!--</th>-->
                                    <th rowspan=2 class=xl132 width=60 style='width:60px'>
                                        <font color="white">Time<br> (%)</font>
                                    </th>
                                    <th rowspan=2 class=xl132 width=60 style='width:60px'>
                                        <font color="white">Achiev<br> (%)</font>
                                    </th>
                                    <th rowspan=2 class=xl132 width=60 style='width:60px'>
                                        <font color="white">Remark<br></font>
                                    </th>
                                     <th rowspan=2 class=xl132 width=60 style='width:60px'>
                                        <font color="white">Edit</font>
                                    </th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $ii = 1; ?>
                                <?php foreach ($arr_dashboard as $row) {
                                ?>
                                    <tr style="font-size:15px">
                                        <td bgcolor="white"><font color="black"><?= $ii++; ?></font></td>
                                        <td bgcolor="white"><a href="/profile?NWB_INT=<?= $row['NWB_ID']; ?>"><font color="black"><?= substr($row['NWB_ID'], 0, 50); ?></font></a></td>
                                        <td bgcolor="white"><a href="/profile?NWB_INT=<?= $row['NWB_ID']; ?>"><font color="black"><?= substr($row['NWB_12digit'], 0, 50); ?></font></a></td>
                                        <td bgcolor="white"><a href="/profile?NWB_INT=<?= $row['NWB_ID']; ?>"><font color="black"><?= substr($row['PROJ_NAME'], 0, 50); ?></font></a></td>
                                        <td bgcolor="white"><a href="/bydate?NWB_INT=<?= $row['NWB_ID'] . ';' . $row['NWB_ACH']; ?>"><font color="black"><?= $row['PROJ_Field_start'];?></font></a></td>
                                        <td bgcolor="white"><a href="/bydate?NWB_INT=<?= $row['NWB_ID'] . ';' . $row['NWB_ACH']; ?>"><font color="black"><?= $row['PROJ_Field_End']; ?></font></a></td>


                                        <td><?= $row['PROJ_Target']; ?></td>

                                        <?php if ($row['PROJ_STATQC'] == 1) { ?>
                                            <?php if ($row['QC'] != 'N/A') { ?>
                                                <td><a href="/db_qc?QC_ID_10DIGIT=<?= $row['NWB_ID']; ?>"><?= $row['QC'] . '<br>(' . $row['QC_Actual_Achievement'] . ')'; ?></a></td>
                                                <?php } else {
                                                if ($row['cekstartonow'] <= 1) { ?>
                                                    <td><?= $row['QC']; ?>
                                                    <?php } elseif ($row['cekstartonow'] > 1 && $row['cekstartonow'] <= 3 && $row['PROJ_STATQC'] == 1) { ?>
                                                    <td bgcolor="yellow" style="color:black"><?= $row['QC']; ?></td>
                                                <?php } elseif ($row['cekstartonow'] > 1 && $row['cekstartonow'] <= 3 && $row['PROJ_STATQC'] == 0) { ?>
                                                    <td><?= $row['QC_Metodologi']; ?>
                                                    <?php } elseif ($row['cekstartonow'] > 3 && $row['PROJ_STATQC'] == 1) { ?>
                                                    <td bgcolor="red" style="color: white;"><?= $row['QC']; ?></td>
                                                <?php } elseif ($row['QC'] == 'N/A') { ?>
                                                    <td bgcolor="red" style="color: white;"><?= $row['QC']; ?></td>
                                                <?php } else { ?>
                                                    <?= $row['QC_Metodologi']; ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td ><?= 'No QC' ?></td>
                                        <?php } ?>

                                        <!-- <td><?php echo $row['QC']; ?></td> -->

                                        <td><a href="/db_quota_admin?NWB_INT=<?= $row['NWB_10digit'] . ';' . $row['PROJ_NAMEORIGINAL'] . ';' . $row['NWB_ACH']. ';' . $row['PROJ_NAME']; ?>"><?= $row['NWB_ACH']; ?></td>

                                        <td><a href="/db_intv?NWB_INT=<?= $row['NWB_12digit'] . ';' . str_replace(' & ', ' AND ', $row['PROJ_NAMEORIGINAL']) . ';' . $row['AVGLOAD']; ?>"><?= substr($row['NWB_INT_ACT'], 0, 15); ?></a></td>

                                        <!--<td><?= $row['DailyRemain']; ?></td>-->

                                        <?php if ($row['PCT_TIME'] !='-') { ?>
                                            <?php if ($row['ceknowtoend'] < 0) { ?>
                                                <td bgcolor="black" style="color: white;"><?= round($row['PCT_TIME'], 0); ?>%</td>
                                            <?php } else { ?>
                                                <?php if (round($row['PCT_TIME'], 0) <= 30) { ?>
                                                    <td><?= round($row['PCT_TIME'], 0); ?>%</td>
                                                <?php } elseif (round($row['PCT_TIME'], 0) > 30 && round($row['PCT_TIME'], 0) <= 75) { ?>
                                                    <td><?= round($row['PCT_TIME'], 0); ?>%</td>
                                                <?php } else { ?>
                                                    <td><?= round($row['PCT_TIME'], 0); ?>%</td>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } else {?>
                                            <td><?= '-'; ?>%</td>
                                        <?php } ?>

                                        <?php if ($row['PCT_ACH'] !='-') { ?>
                                            <?php if ($row['ceknowtoend'] < 0) { ?>
                                                <?php if (round($row['PCT_ACH'], 0) < 100) { ?>
                                                    <td bgcolor="black">
                                                        <font color="white"><?= round($row['PCT_ACH'], 0); ?>%</font>
                                                    </td>
                                                <?php } else { ?>
                                                    <td bgcolor="grey">
                                                        <font color="white"><?= round($row['PCT_ACH'], 0); ?>%</font>
                                                    </td>
                                                <?php } ?>
    
                                            <?php } else  {  ?>
    
                                                <?php if (round($row['PCT_ACH'], 0) < 100) { ?>
    
                                                    <?php if (round($row['INDEXPCT'], 0) <= 50) { ?>
                                                        <td bgcolor="red">
                                                            <font color="white"><?= round($row['PCT_ACH'], 0); ?>%</font>
                                                        </td>
                                                    <?php } elseif (round($row['INDEXPCT'], 0) > 50  and round($row['INDEXPCT'], 0) <= 75) { ?>
                                                        <td bgcolor="yellow"><?= round($row['PCT_ACH'], 0); ?>%</td>
                                                    <?php } else { ?>
                                                        <td><?= round($row['PCT_ACH'], 0); ?>%</td>
                                                    <?php } ?>
    
                                                <?php } else { ?>
    
                                                    <?php if (round($row['INDEXPCT'], 0) > 75 && round($row['PCT_ACH'], 0)<100) { ?>
                                                        <?php if ($row['QC'] <= 5) { ?>
                                                            <td><?= round($row['PCT_ACH'], 0); ?>%</td>
                                                        <?php } elseif ($row['QC'] > 5 && $row['QC'] <= 10) { ?>
                                                            <td bgcolor="yellow">
                                                                <font color="black"><?= round($row['PCT_ACH'], 0); ?>%</font>
                                                            </td>
                                                        <?php } elseif ($row['QC'] > 10 && $row['QC'] <= 20) { ?>
                                                            <td bgcolor="red">
                                                                <font color="white"><?= round($row['PCT_ACH'], 0); ?>%</font>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td bgcolor="black">
                                                                <font color="white"><?= round($row['PCT_ACH'], 0); ?>%</font>
                                                            </td>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <td bgcolor="green">
                                                            <font color="white"><?= round($row['PCT_ACH'], 0); ?>%</font>
                                                        </td>
                                                    <?php } ?>
                                                <?php } ?>

                                            <?php } ?>
                                        <?php } else {?>
                                            <td><?= '-'; ?>%</td>
                                        <?php } ?>
                                        
                                        <td><?= $row['remark']; ?></td>

                                        <!-- end pct_ach  -->
                                        <!--substr($row['PROJ_NAME'], 0, 50);-->

                                        <td><a href="<?= site_url('/edit/' . substr($row['NWB_ID'], 0, 15)) ?>" class="btn btn-primary" id="ubah">Edit</a></td>
                    </div>
                </div> 
            </div>
            <!-- end modal  -->
            <?php }
            ?>       
        <!-- end foreach  -->
        </tbody>
        </table>
    </div>
</div>
</div>
</div>
</section>
</div>
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
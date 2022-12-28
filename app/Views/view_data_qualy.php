<?php

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

$strquery = "SELECT *,SUM(NWB_Num) as SUMACH FROM tb_NWB GROUP BY NWB_10digit,NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
$SummINTV = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummINTV[] = $row;
}
//print_r($SummINTV); 

$strquery = "SELECT * FROM tb_qualy";
$bantu01 = mysqli_query($conn, $strquery);
$Summqualy = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $Summqualy[] = $row;
}
//$Summqualy=[];
//print_r($Summqualy);
/*
foreach($SummINTV as $row){
    $bantu=[];
    $bantu['IDGABUNG']=$row['NWB_10digit'];
    $bantu['NWB_10digit']=$row['NWB_10digit'];
    $bantu['NWB_12digit']=$row['NWB_12digit'];
    //$bantu['NWB_IDPROJ']=$row['PROJ_name_parent'];
    $bantu['NWB_INT']=$row['NWB_INT'];
    $SummINTV_gab[]=$bantu;
}
//print_r($SummINTV_gab);
$aruniq=[];
$jumuniq=0;
foreach($SummINTV_gab as $row){
    if(!in_array($row['IDGABUNG'],$aruniq)){
        $aruniq[]=$row['IDGABUNG'];
        $jumuniq++;
    }
}
//print_r($aruniq);
//$newarray=array_column($SummINTV, 'NWB_12digit');
//print_r($aruniq);
$arr_intvload=[];
foreach($aruniq as $row1){
    $jum=0;
    $bantu00=[];
    $bantu00['IDGABUNG']="";
    $bantu00['NWB_10digit']="";
    $bantu00['NWB_INT']="";
    foreach($SummINTV_gab as $row2){
        if($row1==$row2['IDGABUNG']){
            $jum++;
            $bantu00['IDGABUNG']=$row2['IDGABUNG']; 
            $bantu00['NWB_10digit']=$row2['NWB_10digit']; 
            //$bantu00['NWB_IDPROJ']=$row2['NWB_IDPROJ']; 
            //$bantu00['NWB_INT']=$row2['NWB_INT'];
        }
    }
    $bantu00['NWB_INT']=$jum;
    $arr_intvload[]=$bantu00;
}
//print_r($arr_intvload);
//die("");

$strQuota="NWB_Quota1,NWB_Quota2,NWB_Quota3,NWB_Quota4,NWB_Quota5,NWB_Quota6,NWB_Quota7,NWB_Quota8";
$srtVar="NWB_10digit,NWB_12digit,NWB_IDPROJ,NWB_INT,NWB_StartDate,NWB_Quota1,NWB_Quota2,NWB_Quota3,NWB_Quota4,NWB_Quota5,NWB_Quota6,NWB_Quota7,NWB_Quota8";
//$str1="SELECT ".$srtVar.",SUM(NWB_Num) as TOTACH";
$str1="SELECT NWB_10digit,NWB_12digit,NWB_IDPROJ,TimeDownload,COUNT(NWB_Num) as COUNTACH,SUM(NWB_Num) as SUMACH";
$str2=" FROM tb_NWB GROUP BY NWB_10digit";
$strqry=$str1." ".$str2;
$strquery="SELECT * FROM tb_NWB GROUP BY NWB_10digit";
$bantu01=mysqli_query($conn,$strqry); 
$SummNWB=[];
$row=[]; 
while ($row = mysqli_fetch_assoc($bantu01)) {
       $SummNWB[]=$row;
}
//print_r($SummNWB);

$strquery="SELECT *,SUM(PROJ_Target) as Sum_Target FROM tb_Project_ownership GROUP BY PROF_ID10DGT";
$bantu01=mysqli_query($conn,$strquery); 
$SummPROJ=[];
$row=[]; 
$bantu=[];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu['PROJ_IDGAB']=$row['PROF_ID10DGT'];
    $bantu['PROF_ID10DGT']=$row['PROF_ID10DGT'];
    $bantu['PROJ_Target']=$row['Sum_Target'];
    $bantu['PROJ_Field_start']=$row['PROJ_Field_start'];
    $bantu['PROJ_Field_End']=$row['PROJ_Field_End'];
    $bantu['PROJ_DP_End']=$row['PROJ_DP_End'];
    $bantu['PROJ_Symphoni_num']=$row['PROJ_Symphoni_num'];
    $bantu['PROJ_Project_name']=$row['PROJ_Project_name'];
    $bantu['PROJ_name_parent']=$row['PROJ_name_parent'];
    //$bantu['longfwnowtoend']=$row['longfwnowtoend'];
    //$bantu['longfwstarttonow']=$row['longfwstarttonow'];
    //$bantu['LongFW']=$row['LongFW'];
    $SummPROJ[]=$bantu;
}
//print_r($SummPROJ);
$datenow=date("Y-m-d");
$arr_dashboard=[];
$newarray=array_column($SummPROJ, 'PROF_ID10DGT');
$newarray2=array_column($arr_intvload, 'NWB_10digit');
//print_r($newarray);
//print_r($newarray2);
//var_dump($newarray);
//die("");
foreach ($SummNWB as $row){
    $id=array_search($row['NWB_10digit'],$newarray,true);
    $id2=array_search($row['NWB_10digit'],$newarray2,true);
    if($id>0){
    if($SummPROJ[$id]['PROJ_Field_start']!='0000-00-00'){    
    $bantu=[];
    $bantu[0]=$id;
    $bantu[1]=$id2;
    $skarang=date("Y-m-d"); 
    $lfw=datedifference($SummPROJ[$id]['PROJ_Field_start'],$SummPROJ[$id]['PROJ_Field_End']);
    $lnowtoend=datedifference($skarang,$SummPROJ[$id]['PROJ_Field_End']);
    $lstarttonow=datedifference($SummPROJ[$id]['PROJ_Field_start'],$skarang);
    $bantu['NWB_10digit']=$row['NWB_10digit'];
    $bantu['PROJ_NAME']=$SummPROJ[$id]['PROJ_name_parent'];
    $bantu['PROJ_Target']=$SummPROJ[$id]['PROJ_Target'];
    $bantu['PROJ_Field_start']=$SummPROJ[$id]['PROJ_Field_start'];
    $bantu['PROJ_Field_End']=$SummPROJ[$id]['PROJ_Field_End'];
    $bantu['NWB_ACH']=$row['SUMACH'];
    $bantu['NWB_INT_ACT']=$arr_intvload[$id2]['NWB_INT'];
    $bantu['PROJ_DP_End']=$SummPROJ[$id]['PROJ_DP_End'];
    if ($lnowtoend>0) {$bt1=($SummPROJ[$id]['PROJ_Target']-$row['SUMACH'])/$lnowtoend;} else {$bt1=$SummPROJ[$id]['PROJ_Target']-$row['SUMACH'];}
    if($bt1<0) {$bt1=$bt1+-0.5;} else {$bt1=$bt1+0.5;}
    $bantu['DailyRemain']=intval($bt1);
    $bantu['now']=$skarang;
    $bantu['PCT_TIME']=intval($lstarttonow/$lfw*100+0.5);
    $bantu['PCT_ACH']=intval($row['SUMACH']/$SummPROJ[$id]['PROJ_Target']*100+0.5);
    $bantu['TimeDownload']=$row['TimeDownload'];
    $rasiotime=intval($lstarttonow/$lfw+0.5);
    if($rasiotime>1) $rasiotime=1;
    
    $hitrasio=intval($rasiotime+0.5)*$SummPROJ[$id]['PROJ_Target'];
    if($hitrasio>0) $index=$row['SUMACH']/$hitrasio;
    $bantu['INDEX']=$index*100;
    $bantu['AVGLOAD']=round($row['SUMACH']/$arr_intvload[$id2]['NWB_INT'],0);
    $bantu['cekLongfw']=$lfw;
    $bantu['cekstartonow']=$lstarttonow;
    $bantu['ceknowtoend']=$lnowtoend;
    
    $arr_dashboard[]=$bantu;
    }
    }
}
//print_r($arr_dashboard);

//die("");

//$arrNilai=query("SELECT * FROM tb_main_dashboard_rev WHERE Interv_Active_DB>0")[0] ;
*/

?>

<?php require "header.php" ?>;

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>QUALITATIVE <br>
                <?= $tgl; ?>, Upload <?= $SummINTV[0]['TimeDownload']; ?>
            </h1><br>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body col-md-6">

                    <table id="datatable" class="table table-striped table-bordered">
                        <thead>
                            <tr height=20 style='height:15.0pt' ; bgcolor="darkblue">
                                <!--<th rowspan=2 class=xl120 width=40    style='height:40pt;  width:40px'><font color="white">No</font></th>-->
                                <th rowspan=2 class=xl122 width=120 style='width:30px'>
                                    <font color="white">AFM</font>
                                </th>
                                <th rowspan=2 class=xl124 width=200 style='width:30px'>
                                    <font color="white">SPV 1</font>
                                </th>
                                <th rowspan=2 class=xl124 width=80 style='width:30px'>
                                    <font color="white">SPV 2</font>
                                </th>
                                <th rowspan=2 class=xl124 width=80 style='width:100px'>
                                    <font color="white">PROJ NAME</font>
                                </th>
                                <th rowspan=2 class=xl124 width=60 style='width:60px'>
                                    <font color="white">TYPE OF STUDY</font>
                                </th>
                                <th rowspan=2 class=xl124 width=60 style='width:10px'>
                                    <font color="white">AREA</font>
                                </th>
                                <th rowspan=2 class=xl132 width=60 style='width:10px'>
                                    <font color="white">TARGET<br> </font>
                                </th>
                                <th rowspan=2 class=xl124 width=60 style='width:30px'>
                                    <font color="white">START DATE</font>
                                </th>
                                <th rowspan=2 class=xl132 width=60 style='width:30px'>
                                    <font color="white">END DATE<br> </font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <?php foreach ($Summqualy as $row) {
                                $i = $i + 1 ?>
                                <tr style="font-size:11.5px">
                                    <td><?= trim($row['PROF_SPV1']); ?></td>
                                    <td><?= trim($row['PROF_SPV2']); ?></td>
                                    <td><?= trim($row['PROF_SPV3']); ?></td>
                                    <td><?= trim($row['PROF_Project_number']); ?></td>
                                    <td><?= trim($row['PROF_TypeOfStudy']); ?></td>
                                    <td><?= trim($row['PROF_Area']); ?></td>
                                    <td><?= trim($row['PROF_Target']); ?></td>
                                    <td><?= trim($row['PROF_Field_start']); ?></td>
                                    <td><?= trim($row['PROF_Field_End']); ?></td>

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
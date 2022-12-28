<?php
require 'functionconnsql.php';
$Index_DB = $_GET["QC_ID_10DIGIT"];

$strquery = "SELECT *, SUM(QC_Actual_Achievement) as QC_SumACT, SUM(QC_QC_Drop_Total) as QC_SumDROP FROM tb_QC WHERE QC_NWBID LIKE '$Index_DB' GROUP BY QC_NWBID";
$bantu01 = mysqli_query($conn, $strquery);
$SummQC = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummQC[] = $row;
}
//print_r($SummQC);
//die('');

/*
$strquery="SELECT *,SUM(PROJ_Target) as SUMACH FROM tb_Project_ownership WHERE PROF_ID10DGT LIKE '$Index_DB' GROUP BY PROF_ID10DGT" ;
$bantu01=mysqli_query($conn,$strquery); 
$Summprofile=[];
while ($row = mysqli_fetch_assoc($bantu01)) {
       $Summprofile[]=$row;
}
//print_r($Summprofile);

$pos_plus=strpos($Summprofile[0]['PROJ_name_parent']," - ");
//$vsimponi=trim(substr($Index_DB,0,$pos_plus));
$vnamaproj=trim(substr($Summprofile[0]['PROJ_name_parent'],$pos_plus+3,strlen($Summprofile[0]['PROJ_Project_name'])-$pos_plus));
//$Summprofile[0]['PROJ_Project_name']=$vnamaproj;

//print_r($Summprofile);
//die("");
//$Index_DB=$_GET["Index_DB"];
$resultINTV=mysqli_query($conn,"SELECT Region,sum(Progress) as area FROM tb_interviewer_rev WHERE Index_DB LIKE '$Index_DB' GROUP BY Region") ;
$ArINTV=mysqli_fetch_assoc($resultINTV);


if (!$ArFW) {
	die ('Gagal terhubung MySQL: ' . mysqli_connect_error());	
}
*/
?>
<?php require 'header.php' ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>RESUME QC <br>
                <strong>
                    <font color="darkblue"><?php if (!is_null($SummQC[0]['QC_Study_Name'])) {
                                                echo strtoupper($SummQC[0]['QC_Study_Name']);
                                            } ?>
                    </font>
                </strong>
                <strong>
                    <font color="darkblue"><?php if (is_null($SummQC[0]['QC_Study_Name'])) {
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

                            <h6><strong>
                                    <font color="grey">PIC
                                </strong></font>
                            </h6>
                            </br>
                            <li>PIC QC DIGITAL: <?= $SummQC[0]["QC_QC_Digtal"] ?> </li>
                            <li>PIC QC CONVENTIONAL: <?= $SummQC[0]["QC_QC_Conventional"] ?> </li>
                            </br>

                            <h6><strong>
                                    <font color="grey">DATA TARGET
                                </strong></font>
                            </h6>
                            </br>
                            <li>By system: <?= $SummQC[0]["QC_Target_QC_by_system"] ?> </li>
                            <li>By Photos: <?= $SummQC[0]["QC_Target_QC_by_Picture"] ?> </li>
                            <li>Audio recording: <?= $SummQC[0]["QC_Target_QC_Audio_recording"] ?> </li>
                            <li>By phone: <?= $SummQC[0]["QC_Target_QC_by_phone"] ?> </li>
                            <li>QC Visit/F2F: <?= $SummQC[0]["QC_Target_QC_Visit_F2F"] ?> </li>
                            </br>


                            <h6><strong>
                                    <font color="grey">DATA ACTUAL
                                </strong></font>
                            </h6>
                            </br>
                            <li>Actual Achievement: <?= $SummQC[0]["QC_SumACT"] ?> </li>
                            <li>By system (100%): <?= $SummQC[0]["QC_Actual_QC_by_system"] ?> </li>
                            <li>By Photos (100%): <?= $SummQC[0]["QC_Actual_QC_by_Photos"] ?> </li>
                            <li>Audio recording (30%): <?= $SummQC[0]["QC_Actual_QC_Audio_recording"] ?> </li>
                            <li>By phone (30%): <?= $SummQC[0]["QC_Actual_QC_by_phone"] ?> </li>
                            <li>QC Visit/F2F (30%): <?= $SummQC[0]["QC_Actual_QC_VisitF2F"] ?> </li>
                            </br>

                            <h6><strong>
                                    <font color="grey">DATA DROP
                                </strong></font>
                            </h6>
                            </br>
                            <li>TOTAL: <?= $SummQC[0]["QC_SumDROP"] ?> </li>
                            <li>By Photos: <?= $SummQC[0]["QC_QC_Drop_by_Photos"] ?> </li>
                            <li>Audio recording: <?= $SummQC[0]["QC_QC_Drop_Audio_recording"] ?> </li>
                            <li>By phone: <?= $SummQC[0]["QC_QC_Drop_by_phone"] ?> </li>
                            <li>QC Visit/F2F: <?= $SummQC[0]["QC_QC_Drop_VisitF2F"] ?> </li>
                            </br>

                            <h6><strong>
                                    <font color="grey">FNAL DROP (%)
                                </strong></font>
                            </h6>
                            </br>
                            
                            <li>TOTAL: <?= round($SummQC[0]["QC_SumDROP"] / $SummQC[0]["QC_SumACT"] * 100, 2) ?>% </li>
                            </br>

                            <h6><strong>
                                    <font color="grey">REMARK
                                </strong></font>
                            </h6>
                            </br>
                            <li><?= $SummQC[0]["QC_QC_Remark"] ?> </li>
                            </br>



                        </body>
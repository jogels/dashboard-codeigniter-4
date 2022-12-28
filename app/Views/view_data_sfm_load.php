<?php
require 'functionconnsql.php';
//var_dump($vsfm);
//$vsfm="Muh Yusuf";


$strqry = "SELECT QUANT_SPV1,QUANT_SPV2,COUNT(QUANT_SPV1) AS QUANT_NUM FROM tb_QUANT WHERE TRIM(QUANT_SFM) LIKE '$vsfm' GROUP BY QUANT_SPV1,QUANT_SPV2";
$bantu01 = mysqli_query($conn, $strqry);
$bantu1 = [];
$nn = 0;
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu1[] = $row;
    $nn++;
}
$aruniq = [];
$jumuniq = 0;
foreach ($bantu1 as $row) {
    if (!in_array($row['QUANT_SPV1'], $aruniq)) {
        $aruniq[] = $row['QUANT_SPV1'];
        $jumuniq++;
    }
}
//print_r($aruniq);
$arr_spv2 = [];
foreach ($aruniq as $row1) {
    $jum = 0;
    $bantu00 = [];
    foreach ($bantu1 as $row2) {
        if ($row1 == $row2['QUANT_SPV1']) {
            $jum++;
            $bantu00['QUANT_SPV1'] = $row2['QUANT_SPV1'];
            $bantu00['QUANT_SPV2'] = $row2['QUANT_SPV2'];
            $bantu00['GAB'] = $row2['QUANT_SPV1'] . ';' . $row2['QUANT_SPV2'];
        }
    }
    $bantu00['QUANT_SPV2_COUNT'] = $jum;
    $arr_spv2[] = $bantu00;
}
//print_r($arr_spv2); 



//*************proses SPV2;
$strqry = "SELECT QUANT_SPV1,QUANT_SPV2,QUANT_STATUS_final,COUNT(QUANT_SPV1) AS QUANT_NUM FROM tb_QUANT WHERE TRIM(QUANT_SFM) LIKE '$vsfm' GROUP BY QUANT_SPV1,QUANT_SPV2,QUANT_IDPROJ,QUANT_STATUS_final";
$bantu01 = mysqli_query($conn, $strqry);
$bantu1 = [];
$bantu001 = [];
$nn = 0;
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu1 = [''];
    $bantu1['QUANT_SPV1'] = $row['QUANT_SPV1'];
    $bantu1['QUANT_SPV2'] = $row['QUANT_SPV2'];
    $bantu1['QUANT_STATUS_final'] = $row['QUANT_STATUS_final'];
    $bantu1['QUANT_NUM'] = $row['QUANT_NUM'];
    $bantu1['GAB'] = $row['QUANT_SPV1'] . ';' . $row['QUANT_SPV2'];
    $bantu001[] = $bantu1;
    $nn++;
}
//print_r($bantu001); 
$aruniq = [];
$jumuniq = 0;
foreach ($bantu001 as $row) {
    if (!in_array($row['GAB'], $aruniq)) {
        $aruniq[] = $row['GAB'];
        $jumuniq++;
    }
}
//print_r($aruniq); 
$dataongoing2 = [];
$datasetup2 = [];
$datahold2 = [];
foreach ($aruniq as $row1) {
    $jumongo = 0;
    $jumhold = 0;
    $jumsetup = 0;
    $bantu0ongo2 = [];
    $bantu0setup2 = [];
    $bantu0hold2 = [];
    foreach ($bantu001 as $row2) {
        if ($row1 == $row2['GAB']) {
            $bantu0ongo2['GAB'] = $row2['GAB'];
            $bantu0hold2['GAB'] = $row2['GAB'];
            $bantu0setup2['GAB'] = $row2['GAB'];
            if (trim($row2['QUANT_STATUS_final']) == 'on going') {
                $jumongo++;
            }
            if (trim($row2['QUANT_STATUS_final']) == 'Set up') {
                $jumsetup++;
            }
            if (trim($row2['QUANT_STATUS_final']) == 'Hold') {
                $jumhold++;
            }
        }
    }
    $bantu0ongo2['QUANT_ONGO'] = $jumongo;
    $bantu0setup2['QUANT_SETUP'] = $jumsetup;
    $bantu0hold2['QUANT_HOLD'] = $jumhold;
    $dataongoing2[] = $bantu0ongo2;
    $datasetup2[] = $bantu0setup2;
    $datahold2[] = $bantu0hold2;
}
//die('');



$strqry = "SELECT *,COUNT(QUANT_SFM) AS QUANT_NUM FROM tb_QUANT WHERE TRIM(QUANT_SFM) LIKE '$vsfm' GROUP BY QUANT_IDPROJ,QUANT_SPV1,QUANT_SPV2";
$bantu01 = mysqli_query($conn, $strqry);
$arraybantu01 = [];
$nn = 0;
while ($row = mysqli_fetch_assoc($bantu01)) {
    $arraybantu01[] = $row;
    $nn++;
}
$arraybantu00 = [];
$bantu = [];
foreach ($arraybantu01 as $row) {
    $arraybantu00['QUANT_IDPROJ'] = $row['QUANT_IDPROJ'];
    $arraybantu00['QUANT_SFM'] = $row['QUANT_SFM'];
    $arraybantu00['QUANT_SPV1'] = $row['QUANT_SPV1'];
    $arraybantu00['QUANT_SPV2'] = $row['QUANT_SPV2'];
    $arraybantu00['QUANT_SPV3'] = $row['QUANT_SPV3'];
    $arraybantu00['QUANT_SPV4'] = $row['QUANT_SPV4'];
    $arraybantu00['QUANT_PROJNAME'] = $row['QUANT_PROJNAME'];
    $arraybantu00['QUANT_TYPESTUDY'] = $row['QUANT_TYPESTUDY'];
    $arraybantu00['QUANT_STATUS_final'] = $row['QUANT_STATUS_final'];
    $arraybantu00['QUANT_NUM'] = $row['QUANT_NUM'];
    //$arraybantu00['GAB']=$row['QUANT_SPV1'].';'.$row['QUANT_SPV2'].';'.$row['QUANT_SPV3'].';'.$row['QUANT_SPV4'];
    $arraybantu00['GAB'] = $row['QUANT_SPV1'] . ';' . $row['QUANT_SPV2'];
    $nn++;
    $bantu[] = $arraybantu00;
}
$aruniq = [];
$jumuniq = 0;
foreach ($bantu as $row) {
    if (!in_array($row['GAB'], $aruniq)) {
        $aruniq[] = $row['GAB'];
        $jumuniq++;
    }
}
//print_r($aruniq);
$arr_spv2load = [];
$newarray = array_column($arr_spv2, 'GAB');
$newarraysetup = array_column($datasetup2, 'GAB');
$newarrayongo = array_column($dataongoing2, 'GAB');
$newarrayhold = array_column($datahold2, 'GAB');
foreach ($aruniq as $row1) {
    $jum = 0;
    $bantu00 = [];
    foreach ($bantu as $row2) {
        if ($row1 == $row2['GAB']) {
            $id = array_search($row1, $newarray, true);
            $idsetup = array_search($row1, $newarraysetup, true);
            $idongo = array_search($row1, $newarrayongo, true);
            $idhold = array_search($row1, $newarrayhold, true);
            //$jum=$jum+$row2['QUANT_NUM'];
            $jum++;
            $bantu00['cek'] = $id;
            $bantu00['cek1'] = $idsetup;
            $bantu00['cek2'] = $idongo;
            $bantu00['cek3'] = $idhold;
            $bantu00['QUANT_IDPROJ'] = $row2['QUANT_IDPROJ'];
            $bantu00['QUANT_SFM'] = $row2['QUANT_SFM'];
            $bantu00['QUANT_SPV1'] = $row2['QUANT_SPV1'];
            $bantu00['QUANT_SPV2'] = $row2['QUANT_SPV2'];
            //$bantu00['QUANT_SPV2']=$arr_spv2[$id]['QUANT_SPV2_COUNT'];
            $bantu00['QUANT_SPV3'] = $row2['QUANT_SPV3'];
            $bantu00['QUANT_SPV4'] = $row2['QUANT_SPV4'];
            $bantu00['QUANT_NUM'] = $row2['QUANT_NUM'];
            $bantu00['QUANT_PROJNAME'] = $row2['QUANT_PROJNAME'];
            if ($idsetup >= 0) {
                $bantu00['QUANT_SETUP'] = $datasetup2[$idsetup]['QUANT_SETUP'];
            } else {
                $bantu00['QUANT_SETUP'] = 0;
            }
            if ($idongo >= 0) {
                $bantu00['QUANT_ONGO'] = $dataongoing2[$idongo]['QUANT_ONGO'];
            } else {
                $bantu00['QUANT_ONGO'] = 0;
            }
            if ($idhold >= 0) {
                $bantu00['QUANT_HOLD'] = $datahold2[$idsetup]['QUANT_HOLD'];
            } else {
                $bantu00['QUANT_HOLD'] = 0;
            }
            //$jum=$datasetup[$idsetup]['QUANT_SETUP']+$dataongoing[$idongo]['QUANT_ONGO']+$datahold[$idsetup]['QUANT_HOLD'];
            $bantu00['GAB'] = $row2['GAB'];
        }
    }
    $bantu00['PROJ_COUNT'] = $jum;
    $arr_spv2load[] = $bantu00;
}

//print_r($arr_spv2load);

$columns = array_column($arr_spv2load, "QUANT_SPV1");
array_multisort($columns, SORT_ASC, $arr_spv2load);



/////*******************AFM;
$strqry = "SELECT QUANT_SPV1,QUANT_SPV2,QUANT_STATUS_final,COUNT(QUANT_SPV1) AS QUANT_NUM FROM tb_QUANT WHERE TRIM(QUANT_SFM) LIKE '$vsfm' GROUP BY QUANT_SPV1,QUANT_IDPROJ,QUANT_STATUS_final";
$bantu01 = mysqli_query($conn, $strqry);
$bantu1 = [];
$nn = 0;
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu1[] = $row;
    $nn++;
}
$aruniq = [];
$jumuniq = 0;
foreach ($bantu1 as $row) {
    if (!in_array($row['QUANT_SPV1'], $aruniq)) {
        $aruniq[] = $row['QUANT_SPV1'];
        $jumuniq++;
    }
}
$dataongoing = [];
$datasetup = [];
$datahold = [];
foreach ($aruniq as $row1) {
    $jumongo = 0;
    $jumhold = 0;
    $jumsetup = 0;
    $bantu0ongo = [];
    $bantu0setup = [];
    $bantu0hold = [];
    foreach ($bantu1 as $row2) {
        if ($row1 == $row2['QUANT_SPV1']) {
            $bantu0ongo['QUANT_SPV1'] = $row2['QUANT_SPV1'];
            $bantu0hold['QUANT_SPV1'] = $row2['QUANT_SPV1'];
            $bantu0setup['QUANT_SPV1'] = $row2['QUANT_SPV1'];
            if (trim($row2['QUANT_STATUS_final']) == 'on going') {
                $jumongo++;
            }
            if (trim($row2['QUANT_STATUS_final']) == 'Hold') {
                $jumhold++;
            }
            if (trim($row2['QUANT_STATUS_final']) == 'Set up') {
                $jumsetup++;
            }
        }
    }
    $bantu0ongo['QUANT_ONGO'] = $jumongo;
    $bantu0setup['QUANT_SETUP'] = $jumsetup;
    $bantu0hold['QUANT_HOLD'] = $jumhold;
    $dataongoing[] = $bantu0ongo;
    $datasetup[] = $bantu0setup;
    $datahold[] = $bantu0hold;
}
//print_r($dataongoing);
//print_r($datasetup);
//print_r($datahold);




//$strqry="SELECT *,COUNT(QUANT_SFM) AS QUANT_NUM FROM tb_QUANT WHERE TRIM(QUANT_SFM) LIKE '$vsfm' GROUP BY QUANT_IDPROJ,QUANT_SPV1,QUANT_SPV2,QUANT_SPV3,QUANT_SPV4";
$strqry = "SELECT *,COUNT(QUANT_SFM) AS QUANT_NUM FROM tb_QUANT WHERE TRIM(QUANT_SFM) LIKE '$vsfm' GROUP BY QUANT_IDPROJ,QUANT_SPV1";
$bantu01 = mysqli_query($conn, $strqry);
$arraybantu01 = [];
$nn = 0;
while ($row = mysqli_fetch_assoc($bantu01)) {
    $arraybantu01[] = $row;
    $nn++;
}
$arraybantu00 = [];
$bantu = [];
foreach ($arraybantu01 as $row) {
    $arraybantu00['QUANT_IDPROJ'] = $row['QUANT_IDPROJ'];
    $arraybantu00['QUANT_SFM'] = $row['QUANT_SFM'];
    $arraybantu00['QUANT_SPV1'] = $row['QUANT_SPV1'];
    $arraybantu00['QUANT_SPV2'] = $row['QUANT_SPV2'];
    $arraybantu00['QUANT_SPV3'] = $row['QUANT_SPV3'];
    $arraybantu00['QUANT_SPV4'] = $row['QUANT_SPV4'];
    $arraybantu00['QUANT_PROJNAME'] = $row['QUANT_PROJNAME'];
    $arraybantu00['QUANT_TYPESTUDY'] = $row['QUANT_TYPESTUDY'];
    $arraybantu00['QUANT_STATUS_final'] = $row['QUANT_STATUS_final'];
    $arraybantu00['QUANT_NUM'] = $row['QUANT_NUM'];
    //$arraybantu00['GAB']=$row['QUANT_SPV1'].';'.$row['QUANT_SPV2'].';'.$row['QUANT_SPV3'].';'.$row['QUANT_SPV4'];
    $arraybantu00['GAB'] = $row['QUANT_SPV1'];
    $nn++;
    $bantu[] = $arraybantu00;
}
$aruniq = [];
$jumuniq = 0;
foreach ($bantu as $row) {
    if (!in_array($row['GAB'], $aruniq)) {
        $aruniq[] = $row['GAB'];
        $jumuniq++;
    }
}
//print_r($aruniq);
$arr_sfmload = [];
$newarray = array_column($arr_spv2, 'QUANT_SPV1');
$newarraysetup = array_column($datasetup, 'QUANT_SPV1');
$newarrayongo = array_column($dataongoing, 'QUANT_SPV1');
$newarrayhold = array_column($datahold, 'QUANT_SPV1');
foreach ($aruniq as $row1) {
    $jum = 0;
    $tes = [];
    foreach ($bantu as $row2) {
        if ($row1 == $row2['GAB']) {
            $id = array_search($row1, $newarray, true);
            $idsetup = array_search($row1, $newarraysetup, true);
            $idongo = array_search($row1, $newarrayongo, true);
            $idhold = array_search($row1, $newarrayhold, true);
            //$jum=$jum+$row2['QUANT_NUM'];
            $jum++;
            $tes['cek'] = $id;
            $tes['cek1'] = $idsetup;
            $tes['cek2'] = $idongo;
            $tes['cek3'] = $idhold;
            $tes['QUANT_IDPROJ'] = $row2['QUANT_IDPROJ'];
            $tes['QUANT_SFM'] = $row2['QUANT_SFM'];
            $tes['QUANT_SPV1'] = $row2['QUANT_SPV1'];
            $tes['QUANT_SPV2'] = $arr_spv2[$id]['QUANT_SPV2_COUNT'];
            $tes['QUANT_SPV3'] = $row2['QUANT_SPV3'];
            $tes['QUANT_SPV4'] = $row2['QUANT_SPV4'];
            $tes['QUANT_NUM'] = $row2['QUANT_NUM'];
            $tes['QUANT_PROJNAME'] = $row2['QUANT_PROJNAME'];
            if ($idsetup >= 0) {
                $tes['QUANT_SETUP'] = $datasetup[$idsetup]['QUANT_SETUP'];
            } else {
                $tes['QUANT_SETUP'] = 0;
            }
            if ($idongo >= 0) {
                $tes['QUANT_ONGO'] = $dataongoing[$idongo]['QUANT_ONGO'];
            } else {
                $tes['QUANT_ONGO'] = 0;
            }
            if ($idhold >= 0) {
                $tes['QUANT_HOLD'] = $datahold[$idsetup]['QUANT_HOLD'];
            } else {
                $tes['QUANT_HOLD'] = 0;
            }
            //$jum=$datasetup[$idsetup]['QUANT_SETUP']+$dataongoing[$idongo]['QUANT_ONGO']+$datahold[$idsetup]['QUANT_HOLD'];
            $tes['GAB'] = $row2['GAB'];
        }
    }
    $tes['PROJ_COUNT'] = $jum;
    $arr_sfmload[] = $tes;
}
//print_r($arr_sfmload);
$totproj = 0;
foreach ($arr_sfmload as $row) {
    $totproj = $totproj + $row['PROJ_COUNT'];
}
//var_dump($totproj);


////%%%%%%%%%%%%%%%%%%%%%%%%

/*
$strqry="SELECT PROJ_SFM,PROJ_SPV1,PROJ_SPV2,PROJ_SPV3,PROJ_Symphoni_num,PROJ_Project_name,PROJ_Field_start,PROJ_Field_End FROM tb_Project_ownership WHERE TRIM(PROJ_SFM) LIKE '$vsfm' GROUP BY PROJ_SFM,PROJ_SPV1,PROJ_Symphoni_num";
$bantu01=mysqli_query($conn,$strqry); 
$arraybantu00=[];
$nn=0;
while ($row = mysqli_fetch_assoc($bantu01)) {
       $arraybantu00[]=$row;
       $nn++;
}

//print_r($arraybantu00);
$aruniq=[];
$jumuniq=0;
foreach($arraybantu00 as $row){
    if(!in_array($row['PROJ_SPV1'],$aruniq)){
        $aruniq[]=$row['PROJ_SPV1'];
        $jumuniq++;
    }
}
//print_r($aruniq);
$arr_sfmload=[];
foreach($aruniq as $row1){
    $jum=0;
    $tes=[];
    $tes['PROJ_SFM']="";
    $tes['PROJ_SPV1']="";
    foreach($arraybantu00 as $row2){
        if($row1==$row2['PROJ_SPV1']&&$row2['PROJ_Field_start']!='0000-00-00'){
            $jum++;
            $tes['PROJ_SFM']=$row2['PROJ_SFM'];
            $tes['PROJ_SPV1']=$row2['PROJ_SPV1'];
        }
    }
    $tes['PROJ_COUNT']=$jum;
    $arr_sfmload[]=$tes;
}
//print_r($arr_sfmload);

//die("");

*/

//$ArINTV=mysqli_fetch_assoc($artes);
?>

<?php require "header.php" ?>;

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>SUMMARY OF FW : <?= strtoupper($vsfm) ?> <br>
                <strong>
                    <font color="darkblue">TOTAL PROJECT: <?= $totproj ?></font>
                </strong>

            </h1><br>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body col-md-6">
                    <table border="1" cellpadding="3" cellspacing="0" width=100%>
                        <thead>

                            <tr height=20 style='height:15.0pt' ; bgcolor="darkblue">
                                <th rowspan=2 class=xl120 style='width:5px'>
                                    <font color="white">No</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">SPV1</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">#SUM SPV2</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:20px'>
                                    <font color="white">#TOTAL Project</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">#SETUP</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">#ON GOING</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">#HOLD</font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <?php foreach ($arr_sfmload as $row) {
                                $i = $i + 1 ?>
                                <tr style="font-size:11.5px">
                                    <td><?= $i; ?></td>
                                    <td><?= $row['QUANT_SPV1']; ?></td>
                                    <td><a href="view_db_sfm_load_byproj?SFM=<?= $row['QUANT_SFM'] . ';' . $row['GAB']; ?>"><?= $row['QUANT_SPV2']; ?></a></td>
                                    <td><a href="view_db_sfm_load_byproj?SFM=<?= $row['QUANT_SFM'] . ';' . $row['GAB']; ?>"><?= $row['PROJ_COUNT']; ?></a></td>
                                    <td><?= $row['QUANT_SETUP']; ?></td>
                                    <td><?= $row['QUANT_ONGO']; ?></td>
                                    <td><?= $row['QUANT_HOLD']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                    <br>
                    <br>


                    <table border="1" cellpadding="3" cellspacing="0" width=100% style='border-collapse:collapse; table-layout:absolute ; font-size:11px'>
                        <thead>

                            <tr height=20 style='height:15.0pt' ; bgcolor="darkblue">
                                <th rowspan=2 class=xl120 style='width:5px'>
                                    <font color="white">No</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">SPV1</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">SPV2</font>
                                </th>
                                <!--<th rowspan=2 class=xl122 style='width:80px'><font color="white">#SUM SPV3</font></th>-->
                                <th rowspan=2 class=xl122 style='width:20px'>
                                    <font color="white">#TOTAL Project</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">#SETUP</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">#ON GOING</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">#HOLD</font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <?php foreach ($arr_spv2load as $row) {
                                $i = $i + 1 ?>
                                <tr style="font-size:11.5px">
                                    <td><?= $i; ?></td>
                                    <td><?= $row['QUANT_SPV1']; ?></td>
                                    <td><?= $row['QUANT_SPV2']; ?></td>
                                    <!--<td><a href="view_db_sfm_load_byproj?SFM=<?= $row['QUANT_SFM'] . ';' . $row['GAB']; ?>"><?= $row['QUANT_SPV3']; ?></a></td>-->
                                    <td><a href="view_db_sfm_load_byproj?SFM=<?= $row['QUANT_SFM'] . ';' . $row['GAB']; ?>"><?= $row['PROJ_COUNT']; ?></a></td>
                                    <td><?= $row['QUANT_SETUP']; ?></td>
                                    <td><?= $row['QUANT_ONGO']; ?></td>
                                    <td><?= $row['QUANT_HOLD']; ?></td>
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
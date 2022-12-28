<?php
require 'functionconnsql.php';
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


$strquery = "SELECT VEN_ID,VEN_PROV,VEN_NAME,VEN_AREA,VEN_PIC,VEN_TELPPIC  FROM tb_vendor GROUP BY VEN_ID";
$bantu01 = mysqli_query($conn, $strquery);
$master_vendor = [];
$arr_idvendor = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $master_vendor[] = $row;
}
// print_r($arr_idvendor);
// die();


$strquery = "SELECT RTD_Last_Name,RTD_Company_Name,RTD_User_ID,RTD_IDVENDOR,RTD_Phone_home  FROM tb_RTD GROUP BY RTD_User_ID";
$bantu01 = mysqli_query($conn, $strquery);
$master_rtd = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $master_rtd[] = $row;
}

// $strquery = "SELECT NWB_12digit,NWB_ID,NWB_INT,sum(NWB_Num) as sum_ach FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1 AND NWB_STATUS LIKE 'Complete' GROUP BY NWB_12digit,NWB_INT";
$strquery = "SELECT NWB_INT,sum(NWB_Num) as sum_ach FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1 AND NWB_STATUS LIKE 'Complete' GROUP BY NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
$master_ach = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $master_ach[] = $row;
}
// $strquery = "SELECT NWB_12digit,NWB_ID,NWB_INT,sum(NWB_Num) as sum_cancel FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1 AND  NWB_STATUS LIKE 'Cancelled' GROUP BY NWB_12digit,NWB_INT";
$strquery = "SELECT NWB_INT,sum(NWB_Num) as sum_cancel FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1 AND  NWB_STATUS LIKE 'Cancelled' GROUP BY NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
$master_cancel = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $master_cancel[] = $row;
}
$strquery = "SELECT NWB_12digit,NWB_INT FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1 GROUP BY NWB_12digit,NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
$master_jumproj = [];
$bantu0=[];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu=[];
    $bantu['NWB_12digit'] = $row['NWB_12digit'];
    $bantu['NWB_INT'] = $row['NWB_INT'];
    $bantu['idgab'] = $bantu['NWB_12digit'].'#'.$bantu['NWB_INT'];
    $bantu0[]=$bantu;
}
// print_r($bantu0);
// die();

$columns = array_column($bantu0, "NWB_12digit");
array_multisort($columns, SORT_DESC, $bantu0);
$columns = array_column($bantu0, "NWB_INT");
array_multisort($columns, SORT_DESC, $bantu0);
$ar_uniq=[];
$ar_uniq_proj=[];
$hitung=0;
$bantu2=[];
$ar_jum_proj_perint=[];
foreach ($bantu0 as $row) {
        if (!in_array($row['NWB_INT'], $ar_uniq_proj)) {
            $ar_uniq_proj[]=$row['NWB_INT'];
            $bantu2['NWB_INT']=$row['NWB_INT'];
            $bantu2['jumproj']=0;
            $ar_jum_proj_perint[]=$bantu2;
            $hitung=1;
        }
        if (in_array($row['NWB_INT'], $ar_uniq_proj)) {
            $id = array_search($row['NWB_INT'], $ar_uniq_proj, true); 
            $ar_jum_proj_perint[$id]['jumproj']=$hitung;
            $hitung++;
        }
}
// print_r($bantu0);
// die();
// print_r($master_cancel);


// $strquery = "SELECT PROJ_Project_name,NWB_12digit,NWB_INT FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1  GROUP BY NWB_12digit,NWB_INT";
$strquery = "SELECT PROJ_Project_name,NWB_12digit,NWB_INT FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1  GROUP BY NWB_INT"; 
$bantu01 = mysqli_query($conn, $strquery);
$bantuall = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantuall[] = $row;
}
$master_all = [];
$uniq_ach = array_column($master_ach, 'NWB_INT');
$uniq_cancel = array_column($master_cancel, 'NWB_INT');
$uniq_proj = array_column($ar_jum_proj_perint, 'NWB_INT');
$arr_idvendor = array_column($master_vendor, 'VEN_ID');
$arr_idrtd = array_column($master_rtd, 'RTD_User_ID');
foreach ($bantuall as $row) {
    // if($row['NWB_12digit']!=''){
        $bantu=[];
        $bantu['NWB_12digit']=$row['NWB_12digit'];
        $bantu['NWB_INT']=$row['NWB_INT'];
        $bantu['PROJ_Project_name']=$row['PROJ_Project_name'];
        $idrtd = array_search($row['NWB_INT'], $arr_idrtd, true); 
        if(!($idrtd=='')){
            $bantu['RTD_IDVENDOR']=$master_rtd[$idrtd]['RTD_IDVENDOR'];
            $bantu['RTD_Last_Name']=$master_rtd[$idrtd]['RTD_Last_Name'];
            $bantu['RTD_Phone_home']=$master_rtd[$idrtd]['RTD_Phone_home'];
            $bantu['RTD_Company_Name']=$master_rtd[$idrtd]['RTD_Company_Name'];
            $idvendor = array_search($bantu['RTD_IDVENDOR'], $master_vendor, true); 
            if(!($idvendor=='')){
                $bantu['VEN_NAME']=$master_vendor[$idvendor]['VEN_NAME'];
                $bantu['VEN_PIC']=$master_vendor[$idvendor]['VEN_PIC'];
            }else{
                $bantu['VEN_NAME']='';
                $bantu['VEN_PIC']='';
            }
            
        }else{
            $bantu['RTD_IDVENDOR']='';
            $bantu['RTD_Last_Name']='';
            $bantu['RTD_Phone_home']='';
            $bantu['RTD_Company_Name']='';
            $bantu['VEN_NAME']='';
            $bantu['VEN_PIC']='';
        }
        $idach = array_search($row['NWB_INT'], $uniq_ach, true); 
        $idcancel = array_search($row['NWB_INT'], $uniq_cancel, true); 
        $idjumproj = array_search($row['NWB_INT'], $uniq_proj, true); 
        $bantu['idgab']=$bantu['RTD_IDVENDOR'].'#'.$bantu['NWB_INT'];
        if(!($idach=='')) {$bantu['sum_ach']=$master_ach[$idach]['sum_ach'];}else{$bantu['sum_ach']=0;}
        if(!($idcancel=='')) {$bantu['sum_cancel']=$master_cancel[$idcancel]['sum_cancel'];}else{$bantu['sum_cancel']=0;}
        if(!($idjumproj=='')) {$bantu['jumproj']=$ar_jum_proj_perint[$idjumproj]['jumproj'];}else{$bantu['jumproj']=0;}
        // $bantu['jumporj']='';
        $master_all[]=$bantu;
    // }
}
// print_r($master_all);

// //TES TULIS DATA
// $hapus="DELETE FROM CekTb_sementara";
// $conn->query($hapus);
// $id=0;
// foreach ($master_all as $row) {
//     $sqlstr = "INSERT INTO CekTb_sementara (NWB_12digit, NWB_INT, RTD_IDVENDOR,RTD_Last_Name,RTD_Phone_home,RTD_Company_Name,VEN_NAME,VEN_PIC) VALUES ('";
//     $sqlstr=$sqlstr.$row['NWB_12digit'] ."','";
//     $sqlstr=$sqlstr.$row['NWB_INT'] ."','";
//     $sqlstr=$sqlstr.$row['RTD_IDVENDOR']."','";
//     $sqlstr=$sqlstr.$row['RTD_Last_Name']."','";
//     $sqlstr=$sqlstr.$row['RTD_Phone_home']."','";
//     $sqlstr=$sqlstr.$row['RTD_Company_Name']."','";
//     $sqlstr=$sqlstr.$row['VEN_NAME']."','";
//     $sqlstr=$sqlstr.$row['VEN_PIC'] ."')";
//     //print_r($sqlstr);
//     $conn->query($sqlstr);
// }

$columns = array_column($master_all, "idgab");
array_multisort($columns, SORT_DESC, $master_all);





// die();



//$ArINTV=mysqli_fetch_assoc($artes);
?>

<?php require "header.php" ?>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>RESUME RTD <br>
                <strong>
                    <font color="darkblue"><?= 'LOAD INTERVIEWER (INTERNAL & VENDOR)' ?></font>
                </strong></br>
                </h4><br><br>
                <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal><i class=" fa fa-plus"><a href="<?php echo site_url('Welcome/insert_user') ?>">
                        <font color="white"></i>Add Data RTD</font>
                    </a></button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal><i class=" fa fa-plus"><a href="<?php echo site_url('Welcome/importform') ?>"></i>
                        <font color="white">Import Excel</font>
                    </a></button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal><i class=" fa fa-plus"></i><a href="<?php echo base_url('Welcome/view_export') ?>">
                        <font color="white">Export Excel</font>
                    </a></button> -->
            </h1><br>
        </div>
        
        
        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body col-md-8">
                    <!-- <div id="div_refresh"> -->
                    <div class="card-box table-responsive" width=40>
                    <a href="<?=site_url('/db_rtd_int_internal')?>" class="btn btn-primary">
                        <i class=""></i> Internal
                    </a>
                    <a href="<?=site_url('/db_rtd_int_vendor')?>" class="btn btn-primary">
                        <i class=""></i> Vendor
                    </a>
                    <a href="<?=site_url('/db_rtd_int')?>" class="btn btn-primary">
                        <i class=""></i> All
                    </a>
                    <table border="1" cellpadding="3" cellspacing="0" width=100% style='border-collapse:collapse; table-layout:absolute ; font-size:11px'>
                        <thead>

                            <tr height=20 style='height:15.0pt' ; bgcolor="darkblue">
                                <th rowspan=2 style='width:5px'>
                                    <font color="white">No</font>
                                </th>
                                <th rowspan=2 style='width:500px'>
                                    <font color="white">ID VENDOR</font>
                                </th>
                                <th rowspan=2 style='width:500px'>
                                    <font color="white">VENDOR</font>
                                </th>
                                <th rowspan=2 style='width:100px'>
                                    <font color="white">INTVW CODE</font>
                                </th>
                                <th rowspan=2 style='width:200px'>
                                    <font color="white">INTVW NAME</font>
                                </th>
                                <th rowspan=2 style='width:70px'>
                                    <font color="white">PHONE NUMBER</font>
                                </th>
                                <th rowspan=2 style='width:15px'>
                                    <font color="white">#PROJ</font>
                                </th>
                                <th width:"10px">
                                    <font color="white">%DROP </font>
                                </th>
                                <th rowspan=2 style='width:10px'>
                                    <font color="white">Total Ach</font>
                                </th>
                            </tr>
                        </thead>


 <tbody>
                            				    <?php $i=1;?> 
                            				    <?php foreach($master_all as $row){ 
                                				   $i=$i+1 ?> 
                    					            <tr style="font-size:11.5px">
                                						<td><?=$i;?></td>
                                						<td><a><?=$row['RTD_IDVENDOR'];?></a></td>
                                						<td><a><?=$row['RTD_Company_Name'];?></a></td>
                                						<td><?=$row['NWB_INT'];?></a></td>
                                						<td><?=$row['RTD_Last_Name'];?></a></td>
                                						<td><?=$row['RTD_Phone_home'];?></a></td>
                                						<td><a href="/db_rtd_int_proj?NWB_10digit=<?=$row['NWB_INT'];?>"><?=$row['jumproj'];?></a></td>
                    						            <?php if(($row['sum_cancel']+$row['sum_ach'])>0) {?>
                                						    <td><?=round($row['sum_cancel']/($row['sum_cancel']+$row['sum_ach'])*100,0);?>%</a></td>
                    						            <?php }?>
                                						<td><?=($row['sum_ach']);?></a></td>
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
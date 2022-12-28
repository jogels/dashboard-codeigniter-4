<?php
require 'functionconnsql.php';
$Index_DB=$_GET["NWB_10digit"];

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


$strquery = "SELECT RTD_Last_Name,RTD_Company_Name,RTD_User_ID,RTD_IDVENDOR,RTD_Phone_home  FROM tb_RTD GROUP BY RTD_User_ID";
$bantu01 = mysqli_query($conn, $strquery);
$master_rtd = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $master_rtd[] = $row;
}


// $strquery="SELECT NWB_INT,NWB_12digit,NWB_10digit,RTD_Last_Name,NWB_IDPROJ FROM tb_NWB LEFT JOIN tb_RTD ON tb_NWB.NWB_INT = tb_RTD.RTD_User_ID WHERE NWB_INT LIKE '$Index_DB' GROUP BY NWB_INT,NWB_12digit" ;
$strquery="SELECT NWB_INT,NWB_12digit,NWB_10digit,NWB_IDPROJ FROM tb_NWB LEFT JOIN tb_Project_ownership ON NWB_ID = PROJ_KODENWB  WHERE PROJ_StatusFieldFinal=1 AND NWB_INT LIKE '$Index_DB' GROUP BY NWB_12digit" ;
$bantu01=mysqli_query($conn,$strquery); 
$SummINT=[];
while ($row = mysqli_fetch_assoc($bantu01)) {
       $SummINT[]=$row;
}
//print_r($SummINT);
// $lst_int=[];
// foreach($SummINT as $nilai){
//     if(!in_array($nilai['NWB_12digit'],$lst_int,true)){
//         $lst_int[]=$nilai['NWB_12digit']; 
//     }
// }
//print_r($lst_int);

//die();
$tb_int=[];
$jum=0;
//$newarray=array_column($SummINT,'RTD_Supervisor_Vendor');
$arr_idrtd = array_column($master_rtd, 'RTD_User_ID');

// foreach($lst_int as $nint){
    foreach($SummINT as $row){
        $id=array_search($row['NWB_INT'],$arr_idrtd,true);
        if(!($id=='')) {
            $arbantu0=[];
            $arbantu0['NWB_10digit']=$row['NWB_10digit'];
            $arbantu0['NWB_12digit']=$row['NWB_12digit'];
            $arbantu0['RTD_Last_Name']=$master_rtd[$id]['RTD_Last_Name'];
            $arbantu0['RTD_User_ID']=$master_rtd[$id]['RTD_User_ID'];
            $arbantu0['NWB_IDPROJ']=$row['NWB_IDPROJ'];
            //$arbantu0['RTD_Phone_home']=$row['RTD_Phone_home'];
            $jum++;
            $arbantu0['COUNT_INT']=$jum;
            $jum=0;
            $tb_int[]=$arbantu0;
        }
    }
// }
//print_r($tb_int); 





?>


<?php require 'header.php';?>



<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>LIST PROJECT INTERVIEWER<br>
                <strong><font color="darkblue"><?=$tb_int[0]['RTD_User_ID'].' - '.$tb_int[0]['RTD_Last_Name']?></font></strong></br> 
            </h1><br>
        </div>
        
        
        
        
          <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body col-md-8">
                    	<table border="1" cellpadding="3" cellspacing="0" width=100% style='border-collapse:collapse;table-layout:fixed; font-size:11px'>
                        				<thead>
                        				    
                        				 <tr height=20 style='height:15.0pt'; bgcolor="darkblue">
                            				  <th rowspan=2 class=xl120 style='height:10px;  width:30px'><font color="white">No</font></th>
                            				  <th rowspan=2 class=xl122 style='width:30px'><font color="white">SYMPHONY NUM</font></th>
                            				  <th rowspan=2 class=xl122 style='width:100px'><font color="white">PRJ NAME</font></th>
                        				 </tr>
                        				 </thead>
                            				 <tbody>
                            				    <?php $i=0;?> 
                            				    <?php foreach($tb_int as $row){ 
                                				   $i=$i+1 ?> 
                    					            <tr style="font-size:11.5px">
                                						<td><?=$i;?></td>
                                    						<td><a href="view_db_profile?NWB_INT=<?=$row['NWB_10digit'];?>"><?=$row['NWB_12digit'];?></a></td>
                                    						<td><a href="view_db_profile?NWB_INT=<?=$row['NWB_10digit'];?>"><?=$row['NWB_IDPROJ'];?></a></td>
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
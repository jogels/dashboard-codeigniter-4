<?php


require 'functionconnsql.php';

$Index_DB = $row->PROJ_KODENWB;

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

/*
$strquery = "SELECT *,AVG(PROJ_Target) as Sum_Target, MIN(PROJ_Field_start) as minPROJ_Field_start,MAX(PROJ_Field_End) as maxPROJ_Field_End FROM tb_Project_ownership WHERE PROJ_KODENWB like '$Index_DB' AND PROJ_StatusFieldFinal=1";
$bantu01 = mysqli_query($conn, $strquery);
$SummPROJ = [];
$row = [];
$bantu = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummPROJ[] = $row;
}
*/


?>
<?php include "header.php"; ?>


<!-- MAIN CONTENT -->

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit Data of <?= $row->	PROJ_name_parent;?></h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body col-md-6">
                    <form action="<?= site_url('update/' . $row->PROJ_KODENWB) ?>" method="post" autocomplete="off">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group">
                            <label>NWB CODE</label>
                            <input type="text" name="PROJ_KODENWB" value="<?=$row->PROJ_KODENWB?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Symphony Number</label>
                            <input type="text" name="PROJ_Symphoni_num" value="<?=$row->PROJ_Symphoni_num?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>METHODOLOGY</label>
                            <input type="text" name="PROJ_typeofstudy" value="<?=$row->PROJ_typeofstudy?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>PIC PM</label>
                            <input type="text" name="PROJ_PM" value="<?=$row->PROJ_PM?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>PIC SFM</label>
                            <input type="text" name="PROJ_SFM" value="<?=$row->PROJ_SFM?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>PIC FIELD</label>
                            <input type="text" name="PROJ_SPV1" value="<?=$row->PROJ_SPV1?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>PIC QC DIGITAL</label>
                            <input type="text" name="PROJ_QC1" value="<?=$row->PROJ_QC1?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>PIC QC CONVENTIONAL</label>
                            <input type="text" name="PROJ_QC2" value="<?=$row->PROJ_QC2?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>PIC DP</label>
                            <input type="text" name="PROJ_DP_PIC" value="<?=$row->PROJ_DP_PIC?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>FW START </label>
                            <input type="date" name="PROJ_Field_start" value="<?=$row->PROJ_Field_start?>" class="form-control" placeholder="format wajib dd-mm-yyyy">
                        </div>
                        <div class="form-group">
                            <label>FW END (<font color="red"><strong>FBN</strong></font>)</label>
                            <input type="date" name="PROJ_Field_End" value="<?=$row->PROJ_Field_End?>" class=" form-control" placeholder="format wajib dd-mm-yyyy">
                        </div>
                        <div class="form-group">
                            <label>FW END (<strong><font color="dark green">**Adjusted</font></strong>) edited</label>
                            <input type="date" name="PROJ_Field_End_Adj" value="<?=$row->PROJ_Field_End_Adj?>" class=" form-control" placeholder="format wajib dd-mm-yyyy">
                        </div>
                        <div class="form-group">
                            <label>Target Project</label></br>
                            <input type="number" name="PROJ_Target" value="<?=$row->PROJ_Target?>" class=" form-control" placeholder="target project"> 
                        </div>
                        <!-- <div class="form-group">
                            <label>Target INTV</label>
                            <input type="text" name="target INTV" value="" class=" form-control" placeholder="target intv" required autofocus>
                        </div>-->
                        <div class="form-group">
                            <label>Remark/Notification</label></br>
                            <input type="text" name="PROJ_Remark" value="<?=$row->PROJ_Remark?>" class=" form-control" placeholder="..."> 
                        </div>
                        <div class="form-group">
                            <label>Using QC Process (0=Not use, 1=Use QC)</label>
                            <input type="number" name="	PROJ_STATQC" value="<?=$row->PROJ_STATQC?>" class=" form-control" min="0" max="1" placeholder="Tuliskan 1 atau 0 (1: masih jalan, 0:closed)" autofocus>
                        </div> 
                        <div class="form-group">
                            <label>DP Scripting (<font color="dark green"><strong>Start Date</strong></font>)</label>
                            <input type="date" name="PROJ_DP_Script_Start" value="<?=$row->PROJ_DP_Script_Start?>" class=" form-control" placeholder="format wajib dd-mm-yyyy">
                        </div> 
                        <div class="form-group">
                            <label>DP Scripting (<font color="dark green"><strong>End Date</strong></font>)</label>
                            <input type="date" name="PROJ_DP_Script_End" value="<?=$row->PROJ_DP_Script_End?>" class=" form-control" placeholder="format wajib dd-mm-yyyy">
                        </div> 
                        <div class="form-group">
                            <label>DP Tabulation (<font color="dark green"><strong>Start Date</strong></font>)</label>
                            <input type="date" name="PROJ_DP_start" value="<?=$row->PROJ_DP_start?>" class=" form-control" placeholder="format wajib dd-mm-yyyy">
                        </div> 
                        <div class="form-group">
                            <label>DP Tabulation (<font color="dark green"><strong>End Date</strong></font>)</label>
                            <input type="date" name="PROJ_DP_End" value="<?=$row->PROJ_DP_End?>" class=" form-control" placeholder="format wajib dd-mm-yyyy">
                        </div> 
                        <div class="form-group">
                            <label>Status Closed or Not on DP (0=Closed, 1=On going)</label>
                            <input type="number" name="	PROJ_Status_DP" value="<?=$row->PROJ_Status_DP?>" class=" form-control" min="0" max="1" placeholder="Tuliskan 1 atau 0 (1: masih jalan, 0:closed)" autofocus>
                            <?php

                            if($row->PROJ_Status_DP==0){
                                date_default_timezone_set("Asia/Bangkok");
                                $now = date('Y-m-d H:i:s');
                                $data = array(
                                    'TimeCloseDP' => $now
                                );
                                $conn = mysqli_connect("103.147.154.57","webopsid_ipsosdb","zzLvD.[(&z4G","webopsid_webops_db");
                                mysqli_query($conn,"UPDATE tb_Project_ownership set TimeCloseDP='" . $now."' WHERE PROJ_KODENWB='".$row->PROJ_KODENWB."'");
                                // echo $row->PROJ_KODENWB;
                                // echo $row->TimeCloseDP;
                                // $row['TimeCloseDP'] = date("Y-m-d h:i:s");
                                // $this->insert_data_utility($data);
                            }
                            if($row->PROJ_Status_DP==1){
                                date_default_timezone_set("Asia/Bangkok");
                                $now = date('Y-m-d H:i:s');
                                $data = array(
                                    'TimeCloseDP' => $now
                                );
                                $conn = mysqli_connect("103.147.154.57","webopsid_ipsosdb","zzLvD.[(&z4G","webopsid_webops_db");
                                mysqli_query($conn,"UPDATE tb_Project_ownership set TimeCloseDP='' WHERE PROJ_KODENWB='".$row->PROJ_KODENWB."'");
                                // echo $row->PROJ_KODENWB;
                                // echo $row->TimeCloseDP;
                                // $row['TimeCloseDP'] = date("Y-m-d h:i:s");
                                // $this->insert_data_utility($data);
                            }
                            ?>
                        </div> 
                        <div>
                            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i>Save</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>

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
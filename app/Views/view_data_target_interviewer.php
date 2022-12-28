<?php
require 'functionconnsql.php';
$Index_DB = $_GET["NWB_ID"];
//var_dump($Index_DB);


$strquery = "SELECT *, SUM(NWB_Num) as SUMACH,MIN(NWB_StartDate) as NWB_StartDate,MAX(NWB_StartDate) as NWB_EndDate  FROM tb_NWB WHERE NWB_STATUS LIKE 'Complete' AND NWB_ID LIKE '$Index_DB' GROUP BY NWB_INT";
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


//$strquery = "SELECT tb_RTD.*,tb_vendor.* FROM tb_RTD left join tb_vendor on VEN_ID=RTD_IDVENDOR where tb_RTD.RTD_User_ID like '$Index_DB'";
$strquery = "SELECT tb_RTD.*,tb_vendor.* FROM tb_RTD left join tb_vendor on VEN_ID=RTD_IDVENDOR";
$bantu01 = mysqli_query($conn, $strquery);
$arrrtd = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $arrrtd[] = $row;
}
//print_r($arrrtd); 
//die();


////==========final 
$strquery = "SELECT * FROM tb_intv WHERE int_nwb LIKE '$Index_DB' ";
$bantu01 = mysqli_query($conn, $strquery);
$arrintv = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $arrintv[] = $row;
}
//print_r($arrintv); 
//die();

$tb_gabint=[];
$newnwb = array_column($quotanwb, 'NWB_INT');
$newrtd = array_column($arrrtd, 'RTD_User_ID');
//$newvendor = array_column($arrvendor, 'VEN_ID');
foreach ($arrintv as $row) {

    $id1 = array_search($row['int_code'], $newnwb, true);
    $id2 = array_search($row['int_code'], $newrtd, true);
    $bantu = [];
    $bantu['vendorid'] = $arrrtd[$id2]['VEN_ID'];
    $bantu['prov'] = $arrrtd[$id2]['RTD_City'];
    $bantu['vendorname'] = $arrrtd[$id2]['VEN_NAME'];
    $bantu['projname'] = $quotanwb[$id1]['NWB_IDPROJ'];
    $bantu['ach'] = $quotanwb[$id1]['SUMACH'];
    $bantu['telp'] = $arrrtd[$id2]['RTD_Phone_home'];
    $bantu['nama_int'] = $arrrtd[$id2]['RTD_Last_Name'];
    $bantu['target'] = $row['int_target'];
    $bantu['codeint'] = $row['int_code'];
    $tb_gabint[]=$bantu;
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
<?php include "header.php"; ?>


<!-- MAIN CONTENT -->

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit Target Per INTVWR (<?=$tb_gabint[0]['projname']?>)</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>

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
                                                <div class="card-body col-md-6">
                                                    <form action="/update_intv" method="post" autocomplete="off">
                                                        <?= csrf_field() ?>
                                                        <input type="hidden" name="_method" value="PUT">
                                                         <div class="form-group">
                                                            <label><?= $i; ?>. Target (<?= $row['codeint'].' : Name='.$row['nama_int'].' - RTD AREA='.$row['prov']; ?>)</label></br>
                                                            <input type="text" name="int_target" value="<?=$row['target']?>" class=" form-control" placeholder="target" required>
                                                        </div>
                                                        <div>
                                                            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i>Save</button>
                                                            <button type="reset" class="btn btn-secondary">Reset</button>
                                                        </div>
                                                    </form>
                                
                                                </div>
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
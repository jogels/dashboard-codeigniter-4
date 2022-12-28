<?php
require 'functionconnsql.php';
//var_dump($vsfm);
//$vsfm="Muh Yusuf";

$strqry = "SELECT * FROM tb_QUANT GROUP BY QUANT_IDPROJ ORDER BY QUANT_SFM,QUANT_SPV1,QUANT_SPV2";
$bantu01 = mysqli_query($conn, $strqry);
$arraybantu00 = [];
$nn = 0;
while ($row = mysqli_fetch_assoc($bantu01)) {
    $arraybantu00[] = $row;
    $nn++;
}

//print_r($arraybantu00);
$aruniq = [];
$jumuniq = 0;
foreach ($arraybantu00 as $row) {
    if (!in_array($row['QUANT_IDPROJ'], $aruniq)) {
        $aruniq[] = $row['QUANT_IDPROJ'];
        $jumuniq++;
    }
}
//print_r($aruniq);
$arr_sfmload = [];
foreach ($aruniq as $row1) {
    $jum = 0;
    $tes = [];
    foreach ($arraybantu00 as $row2) {
        if ($row1 == $row2['QUANT_IDPROJ']) {
            $jum++;
            $tes['QUANT_IDPROJ'] = $row2['QUANT_IDPROJ'];
            $tes['QUANT_SFM'] = $row2['QUANT_SFM'];
            $tes['QUANT_SPV1'] = $row2['QUANT_SPV1'];
            $tes['QUANT_SPV2'] = $row2['QUANT_SPV2'];
            $tes['QUANT_SPV3'] = $row2['QUANT_SPV3'];
            $tes['QUANT_SPV4'] = $row2['QUANT_SPV4'];
            $tes['QUANT_PROJNAME'] = $row2['QUANT_PROJNAME'];
        }
    }
    $tes['PROJ_COUNT'] = $jum;
    $arr_sfmload[] = $tes;
}
//print_r($arr_sfmload);

//die("");



//$ArINTV=mysqli_fetch_assoc($artes);
?>

<?php require "header.php" ?>;

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>SUMMARY OF FW QUANT 1 & 2 <br>
                <strong>
                    <font color="darkblue"><?= 'LOAD' ?></font>
                </strong>

            </h1><br>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body col-md-6">

                     <table border="1" cellpadding="3" cellspacing="0" width=100% style='border-collapse:collapse; table-layout:absolute ; font-size:11px'>
                        <thead>

                            <tr height=20 style='height:15.0pt' ; bgcolor="darkblue">
                                <th rowspan=2 class=xl120 style='width:5px'>
                                    <font color="white">No</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:10px'>
                                    <font color="white">SYMPHONY NUM</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:130px'>
                                    <font color="white">PROJ NAME</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:130px'>
                                    <font color="white">SFM</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:130px'>
                                    <font color="white">SPV1</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:130px'>
                                    <font color="white">SPV2</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:130px'>
                                    <font color="white">SPV3</font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <?php foreach ($arr_sfmload as $row) {
                                $i = $i + 1 ?>
                                <tr style="font-size:11.5px">
                                    <td><?= $i; ?></td>
                                    <td><?= $row['QUANT_IDPROJ']; ?></td>
                                    <td><?= $row['QUANT_PROJNAME']; ?></td>
                                    <td><?= $row['QUANT_SFM']; ?></td>
                                    <td><?= $row['QUANT_SPV1']; ?></td>
                                    <td><?= $row['QUANT_SPV2']; ?></td>
                                    <td><?= $row['QUANT_SPV3']; ?></td>

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
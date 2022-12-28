<?php
require 'functionconnsql.php';
//var_dump($vsfm);
//$vsfm="Muh Yusuf";

$strqry = "SELECT * FROM tb_DP GROUP BY DP_10digit,DP_PIC";
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
    if (!in_array($row['DP_PIC'], $aruniq)) {
        $aruniq[] = $row['DP_PIC'];
        $jumuniq++;
    }
}
//print_r($aruniq);
$arr_dpload = [];
foreach ($aruniq as $row1) {
    $jum = 0;
    $bantu = [];
    $bantu['DP_PIC'] = "";
    $bantu['DP_PIC'] = "";
    $bantu['DP_NamaProj_parent'] = "";
    foreach ($arraybantu00 as $row2) {
        if ($row1 == $row2['DP_PIC']) {
            $jum++;
            $bantu['DP_PIC'] = $row2['DP_PIC'];
            //$bantu['DP_NamaProj_parent']=$row2['DP_NamaProj_parent'];
        }
    }
    $bantu['COUNT_PROJ'] = $jum;
    $arr_dpload[] = $bantu;
}
//print_r($arr_dpload);

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
            <h1><br>
                <strong>
                    <font color="darkblue"><?= 'LOAD DP' ?></font>
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
                                <th rowspan=2 class=xl122 style='width:80px'>
                                    <font color="white">PIC</font>
                                </th>
                                <th rowspan=2 class=xl122 style='width:20px'>
                                    <font color="white">#Project</font>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            <?php foreach ($arr_dpload as $row) {
                                $i = $i + 1 ?>
                                <tr style="font-size:11.5px">
                                    <td><?= $i; ?></td>
                                    <td><?= $row['DP_PIC']; ?></td>
                                    <td><a href="view_db_dpload_byproj?DP_SL=<?= $row['DP_PIC']; ?>"><?= $row['COUNT_PROJ']; ?></a></td>
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
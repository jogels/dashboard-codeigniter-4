<?php 
require 'functionconnsql.php';

require 'header_main.php';

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


$strquery = "SELECT * FROM tb_utility GROUP BY email";
$bantu01 = mysqli_query($conn, $strquery);
$nhit = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $nhit[] = $row;
}
$ncount=count($nhit);
//var_dump($ncount);
//print_r($nhit);

$strquery = "SELECT * FROM tb_utility GROUP BY email,tgllogin ";
$bantu01 = mysqli_query($conn, $strquery);
$SummUTIL = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummUTIL[] = $row;
}
//print_r($SummUTIL);

$ttb_utility=[];
$bantu=[];
foreach ($SummUTIL as $row1) {
    $bantu['email']=$row1['email'];
    $bantu['tgllogin']=$row1['tgllogin'];
    $ddate = substr($row1['tgllogin'],0,10);
    //$ddate = date("Y-m-d");
    $duedt = explode("-", $ddate);
    $date = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
    $week = (int)date('W', $date);
    $week=$week+1;
    if(strlen($week)==1) {$week='0'.$week;}
    $bantu['week']=$week;
    $ttb_utility[]=$bantu;
}
//print_r($ttb_utility);


$aruniq = [];
$jumuniq = 0;
foreach ($ttb_utility as $row) {
    if (!in_array($row['week'], $aruniq)) {
        $nil=strlen($row['week']);
        if($nil==1) {$aruniq[] = '0'.$row['week'];} else {$aruniq[] = $row['week'];}
        //$aruniq[] = $row['week'];
        $jumuniq++;
    }
}
//print_r($aruniq);

//die();
$ArrayUtility=[];
$bantu=[];
foreach ($aruniq as $row1) {
    $jum=0;
    $Cekaruniq = [];
    $frek=0;
    foreach ($ttb_utility as $row2) {
        $frek++;
        if($row1==$row2['week']){
            if (!in_array($row2['email'], $Cekaruniq)) {
                $Cekaruniq[] = $row2['email'];
                $jum++;
            }
        }
    }
    $bantu['week']=$row1;
    $bantu['email']=$frek;
    $bantu['count']=$frek;
    $bantu['pct']=round($jum/$ncount*100,0);
    $ArrayUtility[]=$bantu;
}
//print_r($ArrayUtility);

$columns = array_column($ArrayUtility, "week");
array_multisort($columns, SORT_ASC, $ArrayUtility);

$ArrWeek = array_column($ArrayUtility, 'week');
$cMax = max($ArrWeek);
var_dump($cMax);
$ArrPCT = array_column($ArrayUtility, 'pct');

$tb_vewutility=[];
$bantu=[];
//print_r($nhit);
foreach ($nhit as $row1) {
    $jum=0;
    $Cekaruniq = [];
    $frek=0;
    foreach ($ttb_utility as $row2) {
        if($cMax==$row2['week'] && $row1['email']==$row2['email']){
            $jum++;
            //$bantu['pct']=round($jum/$ncount*100,0);
        }
    }
    if($jum>0){
        $bantu=[];
        $bantu['week']=$cMax;
        $bantu['email']=$row1['email'];
        $bantu['count']=$jum;
        $tb_vewutility[]=$bantu;
    }
}

//print_r($ttb_utility);
//print_r($tb_vewutility);
//die();
//print_r($ArrPCT);
//print_r($ArrayUtility);

$columns = array_column($tb_vewutility, "count");
array_multisort($columns, SORT_DESC, $tb_vewutility);


?>

<script type="text/javascript">
	//converting php array to js array
	var arrayweek = <?php echo json_encode($ArrWeek); ?>;
	var arraypct = <?php echo json_encode($ArrPCT); ?>;
	console.log(array);
</script>

 <!-- Vendor CSS Files -->
  <link href="/template/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/template/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/template/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/template/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="/template/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="/template/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/template/assets/vendor/simple-datatables/style.css" rel="stylesheet">
  
<div id="div_refresh">
    <!--<title>Web Ops Indonesia </title>-->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>DASHBOARD</h1>
            </div>
            <?php $session = session() ?>
            <h4>CHART OF UTILITY (<?php echo $session->get('username') ?>)</h4>
           

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
                       
                        <a href="<?=site_url('/home_admin')?>" class="btn btn-primary">
                    <i class=""></i> Active Project
                </a>
                <a href="<?=site_url('/home_admin_close')?>" class="btn btn-primary">
                    <i class=""></i> Close Project
                </a>
                <a href="<?=site_url('/home_admin_utility')?>" class="btn btn-primary">
                    <i class=""></i> Utility
                </a>
                <br><br>
                
                 <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Utility Chart</h5>

                            <!-- Line Chart -->
                            <canvas id="lineChart" style="max-height: 400px;"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector('#lineChart'), {
                                        type: 'line',
                                        data: {
                                            
                                            // labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                            labels: arrayweek,
                                            datasets: [{
                                                label: 'Line Chart',
                                                // data: [65, 59, 80, 81, 56, 55, 40],
                                                data: arraypct,
                                                fill: false,
                                                borderColor: 'rgb(75, 192, 192)',
                                                tension: 0.1
                                            }]
                                        },
                                        options: {
                                            scales: {
                                                x:{
                                                    
                                                    title:{
                                                        display: true,
                                                        text: 'weekly'
                                                    }
                                                },
                                                y: {
                                                    beginAtZero: true,
                                                    title: {
                                                        display: true,
                                                        text: 'in percent (%)'
                                                    }
                                                }
                                            }
                                        }
                                    });
                                });
                            </script>
                            </div>
                            </div>
                            </div>
                            <!-- End Line Chart -->
                            
                <div class="container">
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <form action="forms/dataArea.php" method="post" role="form" class="php-email-form">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label for="week">Choose Week</label>
                                    <select type="text" name="no" class="form-control" id="no" required>
                                        <option value="1">week <?php echo $cMax?></option>
                                        <!--<option value="2">week 2</option>-->
                                        <!--<option value="3">week 3</option>-->
                                        <!--<option value="4">week 4</option>-->
                                        <!--<option value="5">week 5</option>-->
                                        <!--<option value="6">week 6</option>-->
                                    </select>
                                </div>
                              
                        </form>
                        <table border="1" cellpadding="3" cellspacing="0" width=100% style='border-collapse:collapse; table-layout:absolute ; font-size:11px'>
                            <thead>
                                <tr height=20 style="font-size:15px" ; bgcolor="dodgerblue">
                                    <th rowspan=2 class=xl120 width=40 style='width:5px'>
                                        <font color="white">No</font>
                                    </th>
                                    <th rowspan=2 class=xl122 width=120 style='width:120px'>
                                        <font color="white">Email</font> 
                                    </th>
                                    <th rowspan=2 class=xl124 width=200 style='width:200px'>
                                        <font color="white">Frequency</font>
                                    </th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <tbody>
                                    <?php $ii = 1; ?>
                                    <?php foreach ($tb_vewutility as $row) { ?>
                                        <tr style="font-size:15px">
                                            <td><?= $ii++; ?></td>
                                            <td><?= $row['email']; ?></td>
                                            <td><?= $row['count']; ?></td>
                                <?php }?>       
                            </tbody>
                            </table>

                    </div>
                </div>
                
                
                
                <!--footer-->
                
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
 <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.min.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

<!-- JS Libraies -->

<!-- Template JS File -->
<script src="<?= base_url() ?>/template/assets/js/scripts.js"></script>
<script src="<?= base_url() ?>/template/assets/js/custom.js"></script>

<!-- Vendor JS Files -->
  <script src="/template/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="/template/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/template/assets/vendor/chart.js/chart.min.js"></script>
  <script src="/template/assets/vendor/echarts/echarts.min.js"></script>
  <script src="/template/assets/vendor/quill/quill.min.js"></script>
  <script src="/template/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="/template/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="/template/assets/vendor/php-email-form/validate.js"></script>
</body>

</html>
<?php
require 'functionconnsql.php';

$strquery = "SELECT *  FROM tb_vendor GROUP BY VEN_ID";
$bantu01 = mysqli_query($conn, $strquery);
$SUMMVENDOR = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SUMMVENDOR[] = $row;
}
//print_r($SUMMVENDOR);

$strquery = "SELECT NWB_INT  FROM tb_NWB GROUP BY NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
$bantu02 = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu02[] = $row;
}
$arr_intvw = array_column($bantu02, 'NWB_INT');
$strquery = "SELECT NWB_INT,NWB_StartDate  FROM tb_NWB GROUP BY NWB_StartDate";
$bantu01 = mysqli_query($conn, $strquery);
$bantu02 = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $bantu02[] = $row;
}
$arr_date = array_column($bantu02, 'NWB_StartDate');
$c_intv = COUNT($arr_intvw);
$min_date = str_replace('-', '/', MIN($arr_date));
$max_date = str_replace('-', '/', MAX($arr_date));


//BUAT LIS VENDOR VS UM INTV
$strquery = "SELECT * FROM tb_NWB LEFT JOIN tb_RTD ON tb_NWB.NWB_INT = tb_RTD.RTD_User_ID WHERE RTD_Company_Name!='' AND NWB_STATUS LIKE 'Complete' GROUP BY RTD_Company_Name,NWB_INT";
$bantu01 = mysqli_query($conn, $strquery);
if (!$bantu01) {
    echo mysqli_error($bantu01);
}
$SummRTD = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummRTD[] = $row;
}
//print_r($SummRTD);

$lst_vendor = [];
foreach ($SummRTD as $nilai) {
    if (!in_array($nilai['RTD_Company_Name'], $lst_vendor, true)) {
        $lst_vendor[] = $nilai['RTD_Company_Name'];
    }
}
//print_r($lst_vendor);

$tb_vendorintv = [];
$jum = 0;
//$newarray=array_column($SummRTD,'RTD_Supervisor_Vendor');
foreach ($lst_vendor as $nspv) {
    foreach ($SummRTD as $row) {
        //$id=array_search($nspv,$newarray,true);
        if ($nspv == $row['RTD_Company_Name']) {
            $arbantu0 = [];
            //$arbantu0['RTD_SPV']=$row['RTD_Supervisor_Vendor'];
            $arbantu0['RTD_IDVENDOR'] = $row['RTD_IDVENDOR'];
            $arbantu0['RTD_Company_Name'] = $row['RTD_Company_Name'];
            $arbantu0['RTD_City'] = $row['RTD_City'];
            $arbantu0['RTD_Last_Name'] = $row['RTD_Last_Name'];
            $arbantu0['RTD_Phone_home'] = $row['RTD_Phone_home'];
            $jum++;
        }
    }
    $arbantu0['COUNT_INTV'] = $jum;
    $jum = 0;
    $tb_vendorintv[] = $arbantu0;
}
//print_r($tb_vendorintv);
//die('');

//BUAT LIS VENDOR VS JUM PROJ
$strquery = "SELECT * FROM tb_NWB LEFT JOIN tb_RTD ON tb_NWB.NWB_INT = tb_RTD.RTD_User_ID WHERE NWB_STATUS LIKE 'Complete' AND RTD_Company_Name!='' GROUP BY RTD_IDVENDOR,NWB_10digit";
$bantu01 = mysqli_query($conn, $strquery);
if (!$bantu01) {
    echo mysqli_error($bantu01);
}
$SummRTD = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummRTD[] = $row;
}
//print_r($SummRTD);

$lst_vendor = [];
foreach ($SummRTD as $nilai) {
    if (!in_array($nilai['RTD_IDVENDOR'], $lst_vendor, true)) {
        $lst_vendor[] = $nilai['RTD_IDVENDOR'];
    }
}
//print_r($lst_vendor);

$db_vendor = [];
$jum = 0;
$newarray = array_column($tb_vendorintv, 'RTD_IDVENDOR');
$arr_vendorid = array_column($SUMMVENDOR, 'VEN_ID');
foreach ($lst_vendor as $nspv) {
    $id = array_search($nspv, $newarray, true);
    foreach ($SummRTD as $row) {
        if ($nspv == $row['RTD_IDVENDOR']) {
            $idv = array_search($nspv, $arr_vendorid, true);
            $arbantu0 = [];
            $arbantu0[] = $id;
            //$arbantu0['RTD_SPV']=$row['RTD_Supervisor_Vendor'];
            $arbantu0['RTD_IDVENDOR'] = $row['RTD_IDVENDOR'];
            $arbantu0['VEN_PIC'] = $SUMMVENDOR[$idv]['VEN_PIC'];
            $arbantu0['VEN_AREA'] = $SUMMVENDOR[$idv]['VEN_AREA'];
            //$arbantu0['RTD_Company_Name']=$row['RTD_Company_Name'];
            $arbantu0['VEN_NAME'] = $SUMMVENDOR[$idv]['VEN_NAME'];
            $arbantu0['VEN_PROV'] = $SUMMVENDOR[$idv]['VEN_PROV'];
            $arbantu0['VEN_TELPPIC'] = $SUMMVENDOR[$idv]['VEN_TELPPIC'];
            //$arbantu0['RTD_City']=$row['RTD_City'];
            $jum++;
        }
    }
    $arbantu0['COUNT_PROJ'] = $jum;
    $arbantu0['COUNT_INTV'] = $tb_vendorintv[$id]['COUNT_INTV'];
    $jum = 0;
    $db_vendor[] = $arbantu0;
}
//print_r($db_vendor);
$columns = array_column($db_vendor, "COUNT_INTV");
array_multisort($columns, SORT_DESC, $db_vendor);
$columns = array_column($db_vendor, "COUNT_PROJ");
array_multisort($columns, SORT_DESC, $db_vendor);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>OPS &mdash; IPSOS</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url('template/assets/css/skin_bootstrap'); ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/components.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4></h4>
            </div>
            <div class="data-tables datatable-dark">
                <table border="1" cellpadding="3" cellspacing="0" width=100% id="mauexport">
                    <thead>

                        <tr height=20 style='height:15.0pt' ; bgcolor="darkblue">
                            <th rowspan=2 class=xl120 style='width:5px'>
                                <font color="white">No</font>
                            </th>
                            <th rowspan=2 class=xl122 style='width:10px'>
                                <font color="white">ID VENDOR</font>
                            </th>
                            <th rowspan=2 class=xl122 style='width:80px'>
                                <font color="white">VENDOR NAME</font>
                            </th>
                            <th rowspan=2 class=xl122 style='width:80px'>
                                <font color="white">PIC VENDOR</font>
                            </th>
                            <th rowspan=2 class=xl122 style='width:30px'>
                                <font color="white">NO TELP</font>
                            </th>
                            <th rowspan=2 class=xl122 style='width:20px'>
                                <font color="white">AREA</font>
                            </th>
                            <th rowspan=2 class=xl122 style='width:20px'>
                                <font color="white">CITY</font>
                            </th>
                            <th rowspan=2 class=xl122 style='width:10px'>
                                <font color="white">#PROJ</font>
                            </th>
                            <th rowspan=2 class=xl122 style='width:10px'>
                                <font color="white">#INTV</font>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        <?php foreach ($db_vendor as $row) {
                            $i = $i + 1 ?>
                            <tr style="font-size:11.5px">
                                <td><?= $i; ?></td>
                                <td><a><?php echo $row['RTD_IDVENDOR']; ?></a></td>
                                <td><a><?php echo $row['VEN_NAME']; ?></a></td>
                                <td><?php echo $row['VEN_PIC']; ?></a></td>
                                <td><?php echo $row['VEN_TELPPIC']; ?></a></td>
                                <td><?php echo $row['VEN_AREA']; ?></a></td>
                                <td><?php echo $row['VEN_PROV']; ?></a></td>
                                <td><a href="/db_rtd_vendor_proj?NWB_10digit=<?php echo $row['RTD_IDVENDOR'] . ';' . $row['COUNT_PROJ']; ?>"><?php echo $row['COUNT_PROJ']; ?></a></td>
                                <td><a href="/db_rtd_vendor_int?NWB_10digit=<?php echo $row['RTD_IDVENDOR'] . ';' . $row['COUNT_INTV']; ?>"><?php echo $row['COUNT_INTV']; ?></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    </section>
    </div>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#mauexport').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>



</body>

</html>
<?php
require 'functionconnsql.php';
$Index_DB = $_GET["NWB_INT"];

$strquery = "SELECT * FROM tb_QC WHERE QC_NWBID LIKE '$Index_DB' GROUP BY QC_NWBID";
$bantu01 = mysqli_query($conn, $strquery);
$SummQC = [];
$row = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $SummQC[] = $row;
}
$namaqcdigital = "N/A";
$namaqcconv = "N/A";
if (isset($SummQC[0]['QC_QC_Digtal'])) {
    $namaqcdigital = $SummQC[0]['QC_QC_Digtal'];
}
if (isset($SummQC[0]['QC_QC_Conventional'])) $namaqcconv = $SummQC[0]['QC_QC_Conventional'];

$strquery = "SELECT *,SUM(PROJ_Target) as SUMACH FROM tb_Project_ownership WHERE PROJ_KODENWB LIKE '$Index_DB' GROUP BY PROJ_KODENWB ";
$bantu01 = mysqli_query($conn, $strquery);
$Summprofile = [];
while ($row = mysqli_fetch_assoc($bantu01)) {
    $Summprofile[] = $row;
};

?>
<?php require 'header.php' ?>


<!-- MAIN CONTENT -->

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>RESUME PROJECT <br>
                <strong>
                    <font color="darkblue"><?php if (!is_null($Summprofile[0]['PROJ_name_parent'])) {
                                                echo strtoupper($Summprofile[0]['PROJ_name_parent']);
                                            } ?>
                    </font>
                </strong>
                <strong>
                    <font color="darkblue"><?php if (is_null($Summprofile[0]['PROJ_name_parent'])) {
                                                echo "NA";
                                            } ?></font>
                </strong>
            </h1><br>
        </div>


        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <h4></h4>
                </div>
                <div class="card-body col-md-6">

                    <h6><strong>
                            <font color="grey">Full Nama Project
                        </strong></font>
                    </h6>
                    <?= $Summprofile[0]["PROF_ID10DGT"] ?> - <?= $Summprofile[0]["PROJ_name_parent"] ?>
                    <BR>
                    <BR>
                    <h6><strong>
                            <font color="grey">TIME LINE FW
                        </strong></font>
                    </h6>
                    <li>Start Field Work: <?= $Summprofile[0]["PROJ_Field_start"] ?> </li>
                    <li>End Field Work: <?= $Summprofile[0]["PROJ_Field_End"] ?> </li>
                    </br>

                    <h6>
                        <font color="grey"><strong>Metode</strong></font>
                    </h6>
                    <?= 'Method: ' ?><?= $Summprofile[0]["PROJ_typeofstudy"] ?>
                    <br><br>
                    <h6>
                        <font color="grey"><strong>PROFILE </strong></font>
                    </h6>
                    <table border=0 width=60% align=”left”>
                        <tr>
                            <td>
                                <li>SFM </li>
                            </td>
                            <td>: <?= strtoupper($Summprofile[0]['PROJ_SFM']) ?> </td>
                        </tr>
                        <tr>
                            <td>
                                <li>SUPERVISOR </li>
                            </td>
                            <td> : <?= strtoupper($Summprofile[0]['PROJ_SPV1']) ?> </td>
                        </tr>
                        <tr>
                            <td>
                                <li>QC System</li>
                            </td>
                            <td>: <?= $namaqcdigital ?> </td>
                        </tr>
                        <tr>
                            <td>
                                <li>QC Non System</li>
                            </td>
                            <td> : <?= $namaqcconv ?></td>
                        </tr>

                        <tr>
                            <td>
                                <li>PIC DP </li>
                            </td>

                            <?php if (!is_null($Summprofile[0]['PROJ_DP_PIC'])) { ?>
                                <td>: <?= strtoupper($Summprofile[0]['PROJ_DP_PIC']) ?></td><?php } ?>
                            <?php 'Wiwit'; ?></td>
                        </tr>
                        <tr>
                            <td>
                                <li>PIC CODER</li>
                            </td>
                            <td>: <?= 'Wiwit'; ?></td>
                        </tr>


                    </table>
                    <br>
                    <h6>
                        <font color="grey"><strong>SAMPLE SIZE</strong></font>
                    </h6>
                    <li>Total: <?= $Summprofile[0]["SUMACH"] ?> </li>
                </div>
            </div>
        </div>
    </section>
</div>
<footer class="main-footer">
    <div class="footer-left">
        
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
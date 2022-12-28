<?php
require 'functionconnsql.php';
require 'header.php';?>


            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">OPS-IPSOS INDONESIA</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">OPS</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        </li>
                        <li class="active"><a class="nav-link" href="/"><i class="fas fa-fire"></i> <span>Home</span></a></li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Monitor</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="bootstrap-alert.html">RTD</a></li>
                                <li><a class="nav-link" href="bootstrap-badge.html">QUANTITATIVE</a></li>
                                <li><a class="nav-link" href="bootstrap-breadcrumb.html">QUALITATIVE</a></li>
                                <li><a class="nav-link" href="bootstrap-buttons.html">QC</a></li>
                                <li><a class="nav-link" href="bootstrap-card.html">DP</a></li>

                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i> <span>Feedback</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="components-article.html">RTD</a></li>
                                <li><a class="nav-link beep beep-sidebar" href="components-avatar.html">QUANTY</a></li>
                                <li><a class="nav-link" href="components-chat-box.html">QUALITATIVE</a></li>
                                <li><a class="nav-link beep beep-sidebar" href="components-empty-state.html">DP</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Target & General Issue</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="forms-advanced-form.html">No Error</a></li>
                                <li><a class="nav-link" href="forms-editor.html">On Spec</a></li>
                                <li><a class="nav-link" href="forms-validation.html">On Time</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-file"></i> <span>Library</span></a>
                            <ul class="dropdown-menu">
                                <li><a href="gmaps-advanced-route.html">ISO</a></li>
                                <li><a href="gmaps-draggable-marker.html">Tools</a></li>
                                <li><a href="gmaps-geocoding.html">Books</a></li>
                                <li><a href="gmaps-geolocation.html">Training</a></li>
                                <li><a href="gmaps-marker.html">Other</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-plug"></i> <span>Problem & Solving</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="modules-calendar.html">Field Work</a></li>
                                <li><a class="nav-link" href="modules-chartjs.html">QC</a></li>
                                <li><a class="nav-link" href="modules-datatables.html">RTD</a></li>
                                <li><a class="nav-link" href="modules-flag.html">DP</a></li>
                            </ul>
                        </li>
                        <li><a class="nav-link" href="/"><i class="far fa-user"></i> <span>Q&A Internal</span></a></li>


                        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                                <i class="fas fa-rocket"></i> Documentation
                            </a>
                        </div>
                </aside>
            </div>



            <!-- MAIN CONTENT -->

            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <div class="section-header-back">
                            <a href="<?= site_url('Home/index') ?>" class="btn"><i class="fas fa-arrow-left"></i></a>
                        </div>
                        <h1>RESUME PROJECT - </h1><br>
                        <text>--tb_project_ownership (PROJ_name_parent)--</text>
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
                                <text>--tb_project_ownership (PROJ_name_parent)--</text>
                                <BR>
                                <BR>
                                <h6><strong>
                                        <font color="grey">TIME LINE FW
                                    </strong></font>
                                </h6>
                                <li>Start Field Work: --tb_project_ownership (PROJ_Field_Start)-- </li>
                                <li>End Field Work: --tb_project_ownership (PROJ_Field_End)-- </li>
                                </br>

                                <h6>
                                    <font color="grey"><strong>Metode</strong></font>
                                </h6>
                                <text>Method : --tb_project_ownership (PROJ_typeofstudy)--</text>
                                <br><br>
                                <h6>
                                    <font color="grey"><strong>PROFILE </strong></font>
                                </h6>
                                <table border=0 width=60% align=”left”>
                                    <tr>
                                        <td>
                                            <li>SFM </li>
                                        </td>
                                        <td>: --tb_project_ownership(PROJ_SFM)-- </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <li>SUPERVISER</li>
                                        </td>
                                        <td>: --tb_project_ownership(PROJ_SPV1)-- </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <li>QC System:</li>
                                        </td>
                                        <td>: --tb_qc(QC_QC_Digtal)-- </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <li>QC Non System:</li>
                                        </td>
                                        <td>--tb_project_ownership(QC_QC_Conventional--</td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <li>PIC DP </li>
                                        </td>

                                        <td>: jika tidak ada namanya "wiwit" , jika ada menggunakan --tb_project_ownership(PROJ_DP_PIC)--</td>
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
                                <li>Total: --SUMACH-- </li>

                            </div>
                        </div>
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
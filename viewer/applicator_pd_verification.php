<?php
include 'plugins/header.php';
include 'plugins/preloader.php';
include 'plugins/navbar/viewer_navbar.php';
?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="row mb-2 ml-1 mr-1">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Applicator PD Verification</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/emp_mgt/">Zaihai System</a></li>
                            <li class="breadcrumb-item active">Applicator PD Verification</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                <input type="hidden" id="vc_full_name_hidden">
                <div class="row mb-2">
                    <div class="col-sm-12">
                    <input type="text" class="form-control" id="vc_emp_no_search" placeholder="Scan Employee No."
                        oncopy="return false" onpaste="return false" autocomplete="off" maxlength="255">
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <input type="text" class="form-control" id="vc_applicator_no_search" placeholder="Scan Applicator No."
                        oncopy="return false" onpaste="return false" autocomplete="off" maxlength="255" disabled>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <div class="row mb-2">
                    <div class="col-sm-12">
                    <span class="text-bold" id="vc_search_result"></span>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->
<?php
include 'plugins/footer.php';
include '../modals/applicator_checksheet_verify.php';
include 'plugins/js/applicator_pd_verification_script.php';
?>
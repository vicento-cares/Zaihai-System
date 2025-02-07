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
                        <h1 class="m-0"> Applicator Error Monitoring</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/emp_mgt/">Zaihai System</a></li>
                            <li class="breadcrumb-item active">Applicator Error Monitoring</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-gray-dark card-outline">
                                <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-cart-plus"></i> Applicator Error Monitoring Table</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-sm-2">
                                            <label>Car Maker</label>
                                            <select id="aem_car_maker_search" class="form-control" onchange="get_recent_applicator_err_mon()">
                                                <option selected value="">All</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Car Model</label>
                                            <select id="aem_car_model_search" class="form-control" onchange="get_recent_applicator_err_mon()">
                                                <option selected value="">All</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Location</label>
                                            <input list="aem_location_search_list" class="form-control" id="aem_location_search">
                                            <datalist id="aem_location_search_list"></datalist>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Applicator No.</label>
                                            <input list="aem_applicator_no_search_list" class="form-control" id="aem_applicator_no_search">
                                            <datalist id="aem_applicator_no_search_list"></datalist>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Terminal Name</label>
                                            <input list="aem_terminal_name_search_list" class="form-control" id="aem_terminal_name_search">
                                            <datalist id="aem_terminal_name_search_list"></datalist>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3 offset-sm-6">
                                            <button type="button" class="btn btn-secondary btn-block" onclick="export_recent_applicator_err_mon('recentApplicatorErrMonTable')"><i class="fas fa-download"></i> Export</button>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-success btn-block" onclick="get_recent_applicator_err_mon()"><i class="fas fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-2">
                                        <span id="count_view"></span>
                                        </div>
                                    </div>
                                    <div class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                                        <table id="recentApplicatorErrMonTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                                            <thead style="text-align: center;">
                                                <tr>
                                                <th>#</th>
                                                <th>Error Code</th>
                                                <th>Error Name</th>
                                                <th>Serial No.</th>
                                                <th>Zaihai Car Maker</th>
                                                <th>Zaihai Car Model</th>
                                                <th>Scanned Applicator No.</th>
                                                <th>Scanned Terminal Name</th>
                                                <th>Scanned TRD No.</th>
                                                <th>Scanned By No.</th>
                                                <th>Interface</th>
                                                <th>Date Recorded</th>
                                                <th>It Error Details</th>
                                                </tr>
                                            </thead>
                                            <tbody id="recentApplicatorErrMonData" style="text-align: center;">
                                                <tr>
                                                <td colspan="13" style="text-align:center;">
                                                    <div class="spinner-border text-dark" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                    </div>
                                                </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
<?php
include 'plugins/footer.php';
include 'plugins/js/applicator_err_mon_script.php';
?>
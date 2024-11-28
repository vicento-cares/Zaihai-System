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
                        <h1 class="m-0"> Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/emp_mgt/">Zaihai System</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
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
                                <h3 class="card-title"></h3>
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
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <label>Year</label>
                                            <select id="applicator_adj_cnt_year_search" class="form-control">
                                                <option selected value="">Select Year</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Month</label>
                                            <select id="applicator_adj_cnt_month_search" class="form-control">
                                                <option selected value="">Select Month</option>
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-3">
                                            <label>Car Maker</label>
                                            <select id="applicator_adj_cnt_car_maker_search" class="form-control">
                                                <option selected value="">Select Car Maker</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Car Model</label>
                                            <select id="applicator_adj_cnt_car_model_search" class="form-control">
                                                <option selected value="">Select Car Model</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Applicator No.</label>
                                            <select id="applicator_adj_cnt_applicator_no_search" class="form-control">
                                                <option selected value="">Select Applicator No.</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label>Adjustment Content</label>
                                            <select id="applicator_adj_cnt_adjustment_content_search" class="form-control">
                                                <option selected value="">Select Adjustment Content</option>
                                                <option value="Repair">Repair</option>
                                                <option value="Adjust">Adjust</option>
                                                <option value="Clean">Clean</option>
                                                <option value="Replace">Replace</option>
                                                <option value="Beyond The Limit">Beyond The Limit</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-3 offset-sm-9">
                                            <button type="button" class="btn btn-success btn-block" onclick="get_applicator_adj_cnt_chart()"><i class="fas fa-search"></i> Generate</button>
                                        </div>
                                    </div>
                                    <div class="row" id="applicator_adj_cnt_chart"></div>
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
include 'plugins/js/dashboard_script.php';
?>
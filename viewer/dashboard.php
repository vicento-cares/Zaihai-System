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
                                <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Current Applicator Status Count as of <?=date("F j, Y")?></h3>
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
                                    <div class="row">
                                        <div class="col-lg-8 col-sm-12">
                                                <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="small-box bg-lightblue">
                                                        <div class="inner mb-3">
                                                            <h2 id="total_applicator_current"></h2>
                                                            <h4><b>Total</b></h4>
                                                            <h4>Applicators</h4>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-gear-b"></i>
                                                        </div>
                                                        <div class="small-box-footer"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="small-box bg-success">
                                                        <div class="inner mb-3">
                                                            <h2 id="total_rtu"></h2>
                                                            <h4><b>Total Ready To Use</b></h4>
                                                            <h4>Applicators</h4>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-checkmark-circled"></i>
                                                        </div>
                                                        <div class="small-box-footer"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="small-box bg-teal">
                                                        <div class="inner mb-3">
                                                            <h2 id="total_in"></h2>
                                                            <h4><b>Total In</b></h4>
                                                            <h4>Applicators</h4>
                                                        </div>
                                                        <div class="icon">
                                                        <i class="ion ion-log-in"></i>
                                                        </div>
                                                        <div class="small-box-footer"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="small-box bg-warning">
                                                        <div class="inner mb-3">
                                                            <h2 id="total_out"></h2>
                                                            <h4><b>Total Out</b></h4>
                                                            <h4>Applicators</h4>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-log-out"></i>
                                                        </div>
                                                        <div class="small-box-footer"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="small-box bg-danger">
                                                        <div class="inner mb-3">
                                                            <h2 id="total_pending_zaihai"></h2>
                                                            <h4><b>Total Pending (Zaihai)</b></h4>
                                                            <h4>Applicators</h4>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-loop"></i>
                                                        </div>
                                                        <div class="small-box-footer"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="small-box" style="background-color:#FF5D79;">
                                                        <div class="inner mb-3">
                                                            <h2 id="total_pending_bm"></h2>
                                                            <h4><b>Total Pending (BM)</b></h4>
                                                            <h4>Applicators</h4>
                                                        </div>
                                                        <div class="icon">
                                                            <i class="ion ion-loop"></i>
                                                        </div>
                                                        <div class="small-box-footer"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12" id="current_applicator_list_status_count_chart2"></div>
                                    </div>
                                    <div class="row" id="current_applicator_list_status_count_chart"></div>
                                    <div class="row mb-2">
                                        <h5>Total Applicator Out by TRD Cart Positions</h5>
                                    </div>
                                    <div class="row mb-4" id="current_applicator_out_charts"></div>
                                    <div class="row">
                                        <div class="col-8" id="current_trd_carts_reuse_count_chart"></div>
                                        <div class="col-4" id="current_active_trd_count_chart"></div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-gray-dark card-outline">
                                <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Current Registered Applicators & Terminals Count as of <?=date("F j, Y")?></h3>
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
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="small-box bg-secondary">
                                                <div class="inner mb-3">
                                                    <h2 id="total_applicator_terminal"></h2>
                                                    <h4><b>Total</b></h4>
                                                    <h4>Applicator Terminal</h4>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-gear-a"></i>
                                                </div>
                                                <div class="small-box-footer"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="small-box bg-lightblue">
                                                <div class="inner mb-3">
                                                    <h2 id="total_applicator"></h2>
                                                    <h4><b>Total</b></h4>
                                                    <h4>Applicators</h4>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-gear-b"></i>
                                                </div>
                                                <div class="small-box-footer"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="small-box bg-teal">
                                                <div class="inner mb-3">
                                                    <h2 id="total_terminal"></h2>
                                                    <h4><b>Total</b></h4>
                                                    <h4>Terminals</h4>
                                                </div>
                                                <div class="icon">
                                                    <i class="ion ion-record"></i>
                                                </div>
                                                <div class="small-box-footer"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8" id="current_applicators_terminals_count_chart"></div>
                                        <div class="col-4" id="current_applicators_terminals_count_chart2"></div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-gray-dark card-outline collapsed-card">
                                <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-cog mr-2"></i>Monthly Applicator Adjustment Content Chart</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form id="month_a_adj_cnt_form">
                                        <div class="row mb-2">
                                            <div class="col-sm-3">
                                                <label>Year</label>
                                                <select id="month_a_adj_cnt_year_search" class="form-control" required>
                                                    <option selected value="">Select Year</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Month</label>
                                                <select id="month_a_adj_cnt_month_search" class="form-control" required>
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
                                                <select id="month_a_adj_cnt_car_maker_search" class="form-control" required>
                                                    <option selected value="">Select Car Maker</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Car Model</label>
                                                <select id="month_a_adj_cnt_car_model_search" class="form-control" required>
                                                    <option selected value="">Select Car Model</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Applicator No.</label>
                                                <select id="month_a_adj_cnt_applicator_no_search" class="form-control" required>
                                                    <option selected value="">Select Applicator No.</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Adjustment Content</label>
                                                <select id="month_a_adj_cnt_adjustment_content_search" class="form-control" required>
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
                                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-sync"></i> Generate</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row" id="month_a_adj_cnt_chart"></div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-gray-dark card-outline collapsed-card">
                                <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-cog mr-2"></i>Monthly Applicator Adjustment Content Chart 2</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form id="month_a_adj_cnt2_form">
                                        <div class="row mb-4">
                                            <div class="col-sm-3">
                                                <label>Year</label>
                                                <select id="month_a_adj_cnt2_year_search" class="form-control" required>
                                                    <option selected value="">Select Year</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Month</label>
                                                <select id="month_a_adj_cnt2_month_search" class="form-control" required>
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
                                            <div class="col-sm-3 offset-sm-3">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-sync"></i> Generate</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row" id="month_a_adj_cnt2_chart"></div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-gray-dark card-outline collapsed-card">
                                <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-cog mr-2"></i>Monthly Applicator Adjustment Content Chart 3</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form id="month_a_adj_cnt3_form">
                                        <div class="row mb-2">
                                            <div class="col-sm-3">
                                                <label>Year</label>
                                                <select id="month_a_adj_cnt3_year_search" class="form-control" required>
                                                    <option selected value="">Select Year</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Month</label>
                                                <select id="month_a_adj_cnt3_month_search" class="form-control" required>
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
                                            <div class="col-sm-3">
                                                <label>Car Maker</label>
                                                <select id="month_a_adj_cnt3_car_maker_search" class="form-control">
                                                    <option selected value="">Select Car Maker</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Car Model</label>
                                                <select id="month_a_adj_cnt3_car_model_search" class="form-control">
                                                    <option selected value="">Select Car Model</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-sm-3 offset-sm-9">
                                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-sync"></i> Generate</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row" id="month_a_adj_cnt3_chart"></div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-gray-dark card-outline collapsed-card">
                                <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-dot-circle mr-2"></i>Monthly Terminal Usage Chart</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form id="month_term_usage_form">
                                        <div class="row mb-2">
                                            <div class="col-sm-3">
                                                <label>Year</label>
                                                <select id="month_term_usage_year_search" class="form-control" required>
                                                    <option selected value="">Select Year</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Month</label>
                                                <select id="month_term_usage_month_search" class="form-control" required>
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
                                        <div class="row mb-4">
                                            <div class="col-sm-3">
                                                <label>Car Maker</label>
                                                <select id="month_term_usage_car_maker_search" class="form-control">
                                                    <option selected value="">Select Car Maker</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Car Model</label>
                                                <select id="month_term_usage_car_model_search" class="form-control">
                                                    <option selected value="">Select Car Model</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Terminal Name</label>
                                                <select id="month_term_usage_terminal_name_search" class="form-control" required>
                                                    <option selected value="">Select Terminal Name</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-sync"></i> Generate</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-8" id="month_term_usage_chart"></div>
                                        <div class="col-4" id="month_term_usage_chart2"></div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-gray-dark card-outline collapsed-card">
                                <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-list mr-2"></i>Monthly Applicator Out, In and Inspected Chart</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form id="month_aioi_form">
                                        <div class="row mb-2">
                                            <div class="col-sm-3">
                                                <label>Year</label>
                                                <select id="month_aioi_year_search" class="form-control" required>
                                                    <option selected value="">Select Year</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Month</label>
                                                <select id="month_aioi_month_search" class="form-control" required>
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
                                        <div class="row mb-4">
                                            <div class="col-sm-3">
                                                <label>Car Maker</label>
                                                <select id="month_aioi_car_maker_search" class="form-control">
                                                    <option selected value="">Select Car Maker</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Car Model</label>
                                                <select id="month_aioi_car_model_search" class="form-control">
                                                    <option selected value="">Select Car Model</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Status</label>
                                                <select id="month_aioi_status_search" class="form-control" required>
                                                    <option selected value="">Select Status</option>
                                                    <option value="Out">Out</option>
                                                    <option value="In">In</option>
                                                    <option value="Inspected">Inspected</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-sync"></i> Generate</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-8" id="month_aioi_chart"></div>
                                        <div class="col-4" id="month_aioi_chart2"></div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-gray-dark card-outline collapsed-card">
                                <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-list mr-2"></i>Monthly Combined Applicator Out, In and Inspected Chart</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form id="month_caioi_form">
                                        <div class="row mb-2">
                                            <div class="col-sm-3">
                                                <label>Year</label>
                                                <select id="month_caioi_year_search" class="form-control" required>
                                                    <option selected value="">Select Year</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Month</label>
                                                <select id="month_caioi_month_search" class="form-control" required>
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
                                        <div class="row mb-4">
                                            <div class="col-sm-3">
                                                <label>Car Maker</label>
                                                <select id="month_caioi_car_maker_search" class="form-control" required>
                                                    <option selected value="">Select Car Maker</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Car Model</label>
                                                <select id="month_caioi_car_model_search" class="form-control" required>
                                                    <option selected value="">Select Car Model</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Shift</label>
                                                <select id="month_caioi_shift_search" class="form-control" required>
                                                    <option selected value="ALL">ALL</option>
                                                    <option value="DS">DS</option>
                                                    <option value="NS">NS</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-sync"></i> Generate</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-8" id="month_caioi_chart"></div>
                                        <div class="col-4" id="month_caioi_chart2"></div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card card-gray-dark card-outline collapsed-card">
                                <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-clock mr-2"></i>Monthly Average and Max Delay Chart</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form id="month_amd_form">
                                        <div class="row mb-2">
                                            <div class="col-sm-3">
                                                <label>Year</label>
                                                <select id="month_amd_year_search" class="form-control" required>
                                                    <option selected value="">Select Year</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Month</label>
                                                <select id="month_amd_month_search" class="form-control" required>
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
                                            <div class="col-sm-3">
                                                <label>Between</label>
                                                <select id="month_amd_between_search" class="form-control" required>
                                                    <option selected value="">Select Between Dates</option>
                                                    <option value="1">Applicator Out - Applicator In</option>
                                                    <option value="2">Applicator In - Inspected</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-sync"></i> Generate</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row" id="month_amd_chart"></div>
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
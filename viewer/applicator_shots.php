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
                        <h1 class="m-0"> Applicator Shots</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/zaihai/">Zaihai System</a></li>
                            <li class="breadcrumb-item active">Applicator Shots</li>
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
                                <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Current Applicator Count based on Shot Count Status as of <?=date("F j, Y")?></h3>
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
                                        <h5>Current Overall Applicator Count Based On Applicator Shot Count Limit (Wire Crimper or Wire Anvil Only)</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <table class="table table-bordered table-black-white">
                                                <thead>
                                                    <tr>
                                                        <th>Shot Count Limit Status</th>
                                                        <th class="d-none">Normal</th>
                                                        <th>Priority</th>
                                                        <th>Prod Priority</th>
                                                        <th class="d-none">Total Applicators</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Not Exceeded 50k Shots</td>
                                                        <td class="d-none" id="total_appshot_good_normal_qa">0</td>
                                                        <td id="total_appshot_good_prio_qa">0</td>
                                                        <td id="total_appshot_good_prod_prio_qa">0</td>
                                                        <td class="d-none" id="total_appshot_good_qa">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Not Exceeded 100k Shots</td>
                                                        <td class="d-none" id="total_appshot_good_normal_ee">0</td>
                                                        <td id="total_appshot_good_prio_ee">0</td>
                                                        <td id="total_appshot_good_prod_prio_ee">0</td>
                                                        <td class="d-none" id="total_appshot_good_ee">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Exceeded 50k Shots</td>
                                                        <td class="d-none" id="total_appshot_exceeded_normal_qa">0</td>
                                                        <td id="total_appshot_exceeded_prio_qa">0</td>
                                                        <td id="total_appshot_exceeded_prod_prio_qa">0</td>
                                                        <td class="d-none" id="total_appshot_exceeded_qa">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Exceeded 100k Shots</td>
                                                        <td class="d-none" id="total_appshot_exceeded_normal_ee">0</td>
                                                        <td id="total_appshot_exceeded_prio_ee">0</td>
                                                        <td id="total_appshot_exceeded_prod_prio_ee">0</td>
                                                        <td class="d-none" id="total_appshot_exceeded_ee">0</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-lg-6 col-sm-12">
                                            <table class="table table-bordered table-black-white">
                                                <thead>
                                                    <tr>
                                                        <th>Applicator Parts</th>
                                                        <th>Not Exceeded 50k Shots</th>
                                                        <th>Exceeded 50k Shots</th>
                                                        <th>Not Exceeded 100k Shots</th>
                                                        <th>Exceeded 100k Shots</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Wire Crimper</td>
                                                        <td id="total_shotcnt_u_qa_good">0</td>
                                                        <td id="total_shotcnt_u_qa_exceeded">0</td>
                                                        <td id="total_shotcnt_u_ee_good">0</td>
                                                        <td id="total_shotcnt_u_ee_exceeded">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Wire Anvil</td>
                                                        <td id="total_shotcnt_d_qa_good">0</td>
                                                        <td id="total_shotcnt_d_qa_exceeded">0</td>
                                                        <td id="total_shotcnt_d_ee_good">0</td>
                                                        <td id="total_shotcnt_d_ee_exceeded">0</td>
                                                    </tr>
                                                    <tr class="d-none">
                                                        <td>Insulation Crimper</td>
                                                        <td id="total_shotcnt_i_u_qa_good">0</td>
                                                        <td id="total_shotcnt_i_u_qa_exceeded">0</td>
                                                        <td id="total_shotcnt_i_u_ee_good">0</td>
                                                        <td id="total_shotcnt_i_u_ee_exceeded">0</td>
                                                    </tr>
                                                    <tr class="d-none">
                                                        <td>Insulation Anvil</td>
                                                        <td id="total_shotcnt_i_d_qa_good">0</td>
                                                        <td id="total_shotcnt_i_d_qa_exceeded">0</td>
                                                        <td id="total_shotcnt_i_d_ee_good">0</td>
                                                        <td id="total_shotcnt_i_d_ee_exceeded">0</td>
                                                    </tr>
                                                    <tr class="d-none">
                                                        <td>Slide Cutter</td>
                                                        <td id="total_shotcnt_c_qa_good">0</td>
                                                        <td id="total_shotcnt_c_qa_exceeded">0</td>
                                                        <td id="total_shotcnt_c_ee_good">0</td>
                                                        <td id="total_shotcnt_c_ee_exceeded">0</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12" id="shotcnt_good_vs_exceeded_qa_chart"></div>
                                        <div class="col-lg-6 col-sm-12" id="shotcnt_good_vs_exceeded_ee_chart"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12" id="shotcnt_exceeded_prio_qa_chart"></div>
                                        <div class="col-lg-6 col-sm-12" id="shotcnt_exceeded_prio_ee_chart"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12" id="shotcnt_exceeded_appstat_qa_chart"></div>
                                        <div class="col-lg-6 col-sm-12" id="shotcnt_exceeded_appstat_ee_chart"></div>
                                    </div>
                                    <div class="row mb-2">
                                        <h5>Current Applicator Count Based On Actual Applicator Shot Counts Accumulated</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12" id="shotcnt_u_ranges_chart"></div>
                                        <div class="col-lg-6 col-sm-12" id="shotcnt_d_ranges_chart"></div>
                                    </div>
                                    <div class="row d-none">
                                        <div class="col-lg-6 col-sm-12" id="shotcnt_i_u_ranges_chart"></div>
                                        <div class="col-lg-6 col-sm-12" id="shotcnt_i_d_ranges_chart"></div>
                                    </div>
                                    <div class="row d-none">
                                        <div class="col-lg-6 col-sm-12" id="shotcnt_c_ranges_chart"></div>
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
                                <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Current Hourly Applicator Count based on Exceeded Shot Count as of <?=date("F j, Y")?> (Wire Crimper or Wire Anvil Only)</h3>
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
                                    <div class="row" id="current_hourly_exceeded_chart"></div>
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
                                <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Current Week Applicator Count based on Exceeded Shot Count as of <?=date("F j, Y")?> (Wire Crimper or Wire Anvil Only)</h3>
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
                                    <div class="row" id="current_week_exceeded_chart"></div>
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
                                <h3 class="card-title"><i class="fas fa-chart-bar mr-2"></i>Current Month Applicator Count based on Exceeded Shot Count as of <?=date("F j, Y")?> (Wire Crimper or Wire Anvil Only)</h3>
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
                                    <div class="row" id="current_month_exceeded_chart"></div>
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
                                <h3 class="card-title"><i class="fas fa-list"></i> Applicator Shots Table</h3>
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
                                            <select id="as_car_maker_search" class="form-control" onchange="get_recent_applicator_shots()">
                                                <option selected value="">All</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Car Model</label>
                                            <select id="as_car_model_search" class="form-control" onchange="get_recent_applicator_shots()">
                                                <option selected value="">All</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Status</label>
                                            <select id="as_status_search" class="form-control" onchange="get_recent_applicator_shots()">
                                                <option selected value="">All</option>
                                                <option value="Ready To Use">Ready To Use</option>
                                                <option value="Out">Out</option>
                                                <option value="Pending">Pending</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Shot Limit Status</label>
                                            <select id="as_shot_limit_status_search" class="form-control" onchange="get_recent_applicator_shots()">
                                                <option selected value="">All</option>
                                                <option value="Good">All Good</option>
                                                <option value="Good-QA">All QA Good</option>
                                                <option value="Good-EE">All EE Good</option>
                                                <option value="Exceeded">All Exceeded</option>
                                                <option value="Exceeded-QA">All QA 50k Exceeded</option>
                                                <option value="Exceeded-EE">All EE 100k Exceeded</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Applicator No.</label>
                                            <input list="as_applicator_no_search_list" class="form-control" id="as_applicator_no_search">
                                            <datalist id="as_applicator_no_search_list"></datalist>
                                        </div>
                                        <div class="col-sm-2">
                                            <label>Location</label>
                                            <input list="as_location_search_list" class="form-control" id="as_location_search">
                                            <datalist id="as_location_search_list"></datalist>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-2 offset-sm-8">
                                            <button type="button" class="btn btn-secondary btn-block" onclick="export_recent_applicator_shots('recentApplicatorShotsTable')"><i class="fas fa-download"></i> Export</button>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-success btn-block" onclick="get_recent_applicator_shots()"><i class="fas fa-search"></i> Search</button>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="form-group mb-0 px-2">
                                        <label><b>Applicator Shots Table Legend</b></label>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-6 col-lg-3 p-1 border"><center>All Good</center></div>
                                        <div class="col-sm-6 col-lg-3 p-1 border bg-gray"><center>Shot Limit Exceeded</center></div>
                                        <div class="col-sm-6 col-lg-3 p-1 border bg-danger"><center>100k Shots Exceeded (EE)</center></div>
                                        <div class="col-sm-6 col-lg-3 p-1 border bg-warning"><center>50k Shots Exceeded (QA)</center></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-2">
                                        <span id="count_view"></span>
                                        </div>
                                    </div>
                                    <div class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                                        <table id="recentApplicatorShotsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                                            <thead style="text-align: center;">
                                                <tr>
                                                <th>#</th>
                                                <th>Car Maker</th>
                                                <th>Car Model</th>
                                                <th>Applicator No.</th>
                                                <th>Location</th>
                                                <th>Status</th>
                                                <th>Elapsed Time</th>
                                                <th>Shot Count (Wire Crimper)</th>
                                                <th>Shot Limit EE (Wire Crimper)</th>
                                                <th>Shot Limit QA (Wire Crimper)</th>
                                                <th>Shot Limit Status EE (Wire Crimper)</th>
                                                <th>Shot Limit Status QA (Wire Crimper)</th>
                                                <th>Shot Count (Wire Anvil)</th>
                                                <th>Shot Limit EE (Wire Anvil)</th>
                                                <th>Shot Limit QA (Wire Anvil)</th>
                                                <th>Shot Limit Status EE (Wire Anvil)</th>
                                                <th>Shot Limit Status QA (Wire Anvil)</th>
                                                <th>Shot Count (Insulation Crimper)</th>
                                                <th>Shot Limit EE (Insulation Crimper)</th>
                                                <th>Shot Limit QA (Insulation Crimper)</th>
                                                <th>Shot Limit Status EE (Insulation Crimper)</th>
                                                <th>Shot Limit Status QA (Insulation Crimper)</th>
                                                <th>Shot Count (Insulation Anvil)</th>
                                                <th>Shot Limit EE (Insulation Anvil)</th>
                                                <th>Shot Limit QA (Insulation Anvil)</th>
                                                <th>Shot Limit Status EE (Insulation Anvil)</th>
                                                <th>Shot Limit Status QA (Insulation Anvil)</th>
                                                <th>Shot Count (Slide Cutter)</th>
                                                <th>Shot Limit EE (Slide Cutter)</th>
                                                <th>Shot Limit QA (Slide Cutter)</th>
                                                <th>Shot Limit Status EE (Slide Cutter)</th>
                                                <th>Shot Limit Status QA (Slide Cutter)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="recentApplicatorShotsData" style="text-align: center;">
                                                <tr>
                                                <td colspan="32" style="text-align:center;">
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
include 'plugins/js/applicator_shots_script.php';
?>
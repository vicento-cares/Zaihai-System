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
                        <h1 class="m-0"> Applicator History</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/emp_mgt/">Zaihai System</a></li>
                            <li class="breadcrumb-item active">Applicator History</li>
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
                                <h3 class="card-title"><i class="fas fa-history"></i> Applicator History Table</h3>
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
                                    <form id="applicator_history_form">
                                        <div class="row mb-2">
                                            <div class="col-sm-3">
                                                <label>Date Time In From</label>
                                                <input type="datetime-local" class="form-control" id="aioh_date_time_in_from_search" required>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Date Time In To</label>
                                                <input type="datetime-local" class="form-control" id="aioh_date_time_in_to_search" required>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Applicator No.</label>
                                                <input list="aioh_applicator_no_search_list" class="form-control" id="aioh_applicator_no_search">
                                                <datalist id="aioh_applicator_no_search_list"></datalist>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Terminal Name</label>
                                                <input type="text" class="form-control" id="aioh_terminal_name_search" autocomplete="off" maxlength="255">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-3">
                                                <label>Car Maker</label>
                                                <select id="aioh_car_maker_search" class="form-control">
                                                    <option selected value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Car Model</label>
                                                <select id="aioh_car_model_search" class="form-control">
                                                    <option selected value="">All</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <label>TRD No. Location</label>
                                                <input type="text" class="form-control" id="aioh_trd_no_search" autocomplete="off" maxlength="255">
                                            </div>
                                            <div class="col-sm-3">
                                                <label>Zaihai Stock Address Location</label>
                                                <input type="text" class="form-control" id="aioh_zaihai_stock_address_search" autocomplete="off" maxlength="255">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-3 offset-sm-6">
                                                <button type="button" class="btn btn-secondary btn-block" onclick="export_applicator_history('applicatorHistoryTable')"><i class="fas fa-download"></i> Export</button>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-search"></i> Search</button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row mb-2">
                                        <div class="col-sm-2">
                                        <span id="count_view"></span>
                                        </div>
                                    </div>
                                    <div class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                                        <table id="applicatorHistoryTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                                            <thead style="text-align: center;">
                                                <tr>
                                                <th>#</th>
                                                <th>Serial No.</th>
                                                <th>Car Maker</th>
                                                <th>Car Model</th>
                                                <th>Applicator No.</th>
                                                <th>Terminal Name</th>
                                                <th>TRD No.</th>
                                                <th>Operator Out</th>
                                                <th>Date Time Out</th>
                                                <th>Zaihai Stock Address</th>
                                                <th>Line Address</th>
                                                <th>Operator In</th>
                                                <th>Date Time In</th>
                                                <th>Inspected By</th>
                                                <th>Confirmation Date</th>
                                                <th>Adjustment Content</th>
                                                <th>Adjustment Content Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody id="applicatorHistoryData" style="text-align: center;"></tbody>
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
include '../modals/applicator_checksheet_view.php';
include 'plugins/js/applicator_history_script.php';
?>
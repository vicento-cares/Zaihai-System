<?php include 'plugins/navbar.php'; ?>
<?php include 'plugins/sidebar/shop_bar.php'; ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Applicator Maintenance History</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="applicator_shots_qa.php">Applicator Maintenance History</a>
            </li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-gray-dark card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-history"></i> Applicator Maintenance History Table</h3>
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
              <form id="applicator_shots_mch_form">
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>Maintenance Date From</label>
                    <input type="date" class="form-control" id="asmch_maintenance_date_from_search" required>
                  </div>
                  <div class="col-sm-3">
                    <label>Maintenance Date To</label>
                    <input type="date" class="form-control" id="asmch_maintenance_date_to_search" required>
                  </div>
                  <div class="col-sm-3">
                    <label>Car Maker</label>
                    <select id="asmch_car_maker_search" class="form-control">
                      <option selected value="">All</option>
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <label>Car Model</label>
                    <select id="asmch_car_model_search" class="form-control">
                      <option selected value="">All</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <label>Applicator No.</label>
                    <input list="asmch_applicator_no_search_list" class="form-control" id="asmch_applicator_no_search">
                    <datalist id="asmch_applicator_no_search_list"></datalist>
                  </div>
                  <div class="col-sm-3">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-secondary btn-block"
                      onclick="export_applicator_shots_mch('recentApplicatorShotsMchTable')"><i
                        class="fas fa-download"></i> Export</button>
                  </div>
                  <div class="col-sm-3">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-success btn-block"><i class="fas fa-search"></i>
                      Search</button>
                  </div>
                </div>
              </form>
              <div class="row mb-2">
                <div class="col-sm-2">
                  <span id="count_view"></span>
                </div>
              </div>
              <div class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                <table id="recentApplicatorShotsMchTable"
                  class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>#</th>
                      <th>Car Maker</th>
                      <th>Car Model</th>
                      <th>Applicator No.</th>
                      <th>Detected By</th>
                      <th>Scan Date Detected</th>
                      <th>Maintenance By</th>
                      <th>Maintenance Date</th>
                    </tr>
                  </thead>
                  <tbody id="recentApplicatorShotsMchData" style="text-align: center;"></tbody>
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
  </section>
</div>

<?php include 'plugins/footer.php'; ?>
<?php include 'plugins/js/applicator_shots_mch_script.php'; ?>
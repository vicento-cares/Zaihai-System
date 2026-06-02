<?php include 'plugins/navbar.php'; ?>
<?php include 'plugins/sidebar/qa_bar.php'; ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Applicator Appearance Inspection History</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="applicator_shots_qa.php">Applicator Appearance Inspection History</a>
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
              <h3 class="card-title"><i class="fas fa-history"></i> Applicator Appearance Inspection History Table</h3>
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
              <form id="applicator_shots_qah_form">
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>Inspection Date From</label>
                    <input type="date" class="form-control" id="asqah_inspection_date_from_search" required>
                  </div>
                  <div class="col-sm-3">
                    <label>Inspection Date To</label>
                    <input type="date" class="form-control" id="asqah_inspection_date_to_search" required>
                  </div>
                  <div class="col-sm-3">
                    <label>Car Maker</label>
                    <select id="asqah_car_maker_search" class="form-control">
                      <option selected value="">All</option>
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <label>Car Model</label>
                    <select id="asqah_car_model_search" class="form-control">
                      <option selected value="">All</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <label>Applicator No.</label>
                    <input list="asqah_applicator_no_search_list" class="form-control" id="asqah_applicator_no_search">
                    <datalist id="asqah_applicator_no_search_list"></datalist>
                  </div>
                  <div class="col-sm-3">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-secondary btn-block"
                      onclick="export_applicator_shots_qah('recentApplicatorShotsQahTable')"><i
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
                <table id="recentApplicatorShotsQahTable"
                  class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>#</th>
                      <th>Car Maker</th>
                      <th>Car Model</th>
                      <th>Applicator No.</th>
                      <th>Inspected By</th>
                      <th>Inspection Date</th>
                    </tr>
                  </thead>
                  <tbody id="recentApplicatorShotsQahData" style="text-align: center;"></tbody>
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
<?php include 'plugins/js/applicator_shots_qah_script.php'; ?>
<?php include 'plugins/navbar.php';?>
<?php include 'plugins/sidebar/bm_bar.php';?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Applicator In</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="applicator_in.php">Applicator In</a></li>
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
              <h3 class="card-title"><i class="fas fa-cart-plus"></i> Applicator Out Table</h3>
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
                <input type="hidden" id="ao_car_maker_search" value="<?= htmlspecialchars($_SESSION['car_maker']); ?>">
                <input type="hidden" id="ao_car_model_search" value="<?= htmlspecialchars($_SESSION['car_model']); ?>">
                <div class="col-sm-3">
                    <label>Location</label>
                    <input list="ao_location_search_list" class="form-control" id="ao_location_search">
                    <datalist id="ao_location_search_list"></datalist>
                </div>
                <div class="col-sm-4">
                  <label>Applicator No.</label>
                  <input list="ao_applicator_no_search_list" class="form-control" id="ao_applicator_no_search">
                  <datalist id="ao_applicator_no_search_list"></datalist>
                </div>
                <div class="col-sm-5">
                  <label>Terminal Name</label>
                  <input list="ao_terminal_name_search_list" class="form-control" id="ao_terminal_name_search">
                  <datalist id="ao_terminal_name_search_list"></datalist>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-2 offset-sm-7">
                  <button type="button" class="btn btn-secondary btn-block" onclick="export_recent_applicator_out('recentApplicatorOutTable')"><i class="fas fa-download"></i> Export</button>
                </div>
                <div class="col-sm-3">
                  <button type="button" class="btn btn-success btn-block" onclick="get_recent_applicator_out()"><i class="fas fa-search"></i> Search</button>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-2">
                  <span id="count_view"></span>
                </div>
              </div>
              <div class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                <table id="recentApplicatorOutTable" class="table table-sm table-head-fixed text-nowrap table-hover">
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
                    </tr>
                  </thead>
                  <tbody id="recentApplicatorOutData" style="text-align: center;">
                    <tr>
                      <td colspan="9" style="text-align:center;">
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
  </section>
</div>

<?php include 'plugins/footer.php';?>
<?php include 'plugins/js/applicator_in_script.php';?>
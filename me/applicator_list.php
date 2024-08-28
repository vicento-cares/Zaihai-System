<?php include 'plugins/navbar.php';?>
<?php include 'plugins/sidebar/me_bar.php';?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Applicator List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="applicator_list.php">Applicator List</a></li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row mb-4">
        <div class="col-sm-3">
          <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#new_applicator_list"><i class="fas fa-plus-circle"></i> Add Applicator List</button>
        </div>
        <div class="col-sm-3">
          <button type="button" class="btn btn-warning btn-block btn-file">
            <form id="file_form" enctype="multipart/form-data">
              <span class="mx-0 my-0"><i class="fas fa-upload"></i> Import Applicator List (Add Only)</span><input type="file" id="file" name="file" onchange="upload_csv()" accept=".csv">
            </form>
          </button>
        </div>
        <div class="col-sm-3">
          <a class="btn btn-dark btn-block" href="../template/applicator_list_template.csv"><i class="fas fa-download"></i> Download Template</a>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-gray-dark card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-list"></i> Applicator List Table</h3>
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
                  <select id="al_car_maker_search" class="form-control" onchange="get_applicator_list()">
                    <option selected value="">All</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label>Car Model</label>
                  <select id="al_car_model_search" class="form-control" onchange="get_applicator_list()">
                    <option selected value="">All</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  <label>Status</label>
                  <select id="al_status_search" class="form-control" onchange="get_applicator_list()">
                    <option selected value="">All</option>
                    <option value="Ready To Use">Ready To Use</option>
                    <option value="Out">Out</option>
                    <option value="Pending">Pending</option>
                  </select>
                </div>
                <div class="col-sm-3">
                  <label>Applicator No.</label>
                  <input list="al_applicator_no_search_list" class="form-control" id="al_applicator_no_search">
                  <datalist id="al_applicator_no_search_list"></datalist>
                </div>
                <div class="col-sm-3">
                  <label>Location</label>
                  <input list="al_location_search_list" class="form-control" id="al_location_search">
                  <datalist id="al_location_search_list"></datalist>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 offset-sm-6">
                  <button type="button" class="btn btn-secondary btn-block" onclick="export_applicator_list('applicatorListTable')"><i class="fas fa-download"></i> Export</button>
                </div>
                <div class="col-sm-3">
                  <button type="button" class="btn btn-primary btn-block" onclick="get_applicator_list()"><i class="fas fa-search"></i> Search</button>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-2">
                  <span id="count_view"></span>
                </div>
              </div>
              <div class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                <table id="applicatorListTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>#</th>
                      <th>Car Maker</th>
                      <th>Car Model</th>
                      <th>Applicator No.</th>
                      <th>Location</th>
                      <th>Status</th>
                      <th>Last Update</th>
                    </tr>
                  </thead>
                  <tbody id="applicatorListData" style="text-align: center;">
                    <tr>
                      <td colspan="7" style="text-align:center;">
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
<?php include 'plugins/js/applicator_list_script.php';?>
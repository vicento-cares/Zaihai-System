<?php include 'plugins/navbar.php';?>
<?php include 'plugins/sidebar/me_bar.php';?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Applicator</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="applicator.php">Applicator</a></li>
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
          <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#new_applicator"><i class="fas fa-plus-circle"></i> Add Applicator</button>
        </div>
        <div class="col-sm-3">
          <button type="button" class="btn btn-warning btn-block btn-file">
            <form id="file_form" enctype="multipart/form-data">
              <span class="mx-0 my-0"><i class="fas fa-upload"></i> Import Applicator (Add Only)</span><input type="file" id="file" name="file" onchange="upload_csv(1)" accept=".csv">
            </form>
          </button>
        </div>
        <div class="col-sm-3">
          <button type="button" class="btn btn-warning btn-block btn-file">
            <form id="file_form2" enctype="multipart/form-data">
              <span class="mx-0 my-0"><i class="fas fa-upload"></i> Import Applicator (Update Only)</span><input type="file" id="file2" name="file" onchange="upload_csv(2)" accept=".csv">
            </form>
          </button>
        </div>
        <div class="col-sm-3">
          <a class="btn btn-dark btn-block" href="../template/applicator_template.csv"><i class="fas fa-download"></i> Download Template</a>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-gray-dark card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-cog"></i> Applicator Table</h3>
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
                <div class="col-sm-3">
                  <label>Car Maker</label>
                  <select id="a_car_maker_search" class="form-control" onchange="get_applicators()">
                    <option selected value="">All</option>
                  </select>
                </div>
                <div class="col-sm-3">
                  <label>Car Model</label>
                  <select id="a_car_model_search" class="form-control" onchange="get_applicators()">
                    <option selected value="">All</option>
                  </select>
                </div>
                <div class="col-sm-3">
                  <label>Applicator No.</label>
                  <input list="a_applicator_no_search_list" class="form-control" id="a_applicator_no_search" maxlength="100" autocomplete="off">
                  <datalist id="a_applicator_no_search_list"></datalist>
                </div>
                <div class="col-sm-3">
                  <label>Zaihai Stock Address</label>
                  <input type="text" id="a_zaihai_stock_address_search" class="form-control" maxlength="100" autocomplete="off">
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 offset-sm-3">
                  <button type="button" class="btn btn-secondary btn-block" onclick="export_applicators_shown('applicatorsTable')"><i class="fas fa-download"></i> Export Shown</button>
                </div>
                <div class="col-sm-3">
                  <button type="button" class="btn btn-secondary btn-block" onclick="export_applicators()"><i class="fas fa-download"></i> Export On Template</button>
                </div>
                <div class="col-sm-3">
                  <button type="button" class="btn btn-primary btn-block" onclick="get_applicators()"><i class="fas fa-search"></i> Search</button>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-2">
                  <span id="count_view"></span>
                </div>
              </div>
              <div class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                <table id="applicatorsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>#</th>
                      <th>Car Maker</th>
                      <th>Car Model</th>
                      <th>Applicator No.</th>
                      <th>Zaihai Stock Address</th>
                      <th>Date Updated</th>
                    </tr>
                  </thead>
                  <tbody id="applicatorsData" style="text-align: center;">
                    <tr>
                      <td colspan="6" style="text-align:center;">
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
<?php include 'plugins/js/applicator_script.php';?>
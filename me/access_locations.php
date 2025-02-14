<?php include 'plugins/navbar.php';?>
<?php include 'plugins/sidebar/me_bar.php';?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Access Locations</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="access_locations.php">Access Locations</a></li>
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
        <div class="col-sm-2">
          <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#new_access_location"><i class="fas fa-plus-circle"></i> Add Location</button>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-gray-dark card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-shield-alt"></i> Access Locations Table</h3>
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
                  <select id="al_car_maker_search" class="form-control" onchange="load_access_locations(1)">
                    <option selected value="">All</option>
                  </select>
                </div>
                <div class="col-sm-3">
                  <label>Car Model</label>
                  <select id="al_car_model_search" class="form-control" onchange="load_access_locations(1)">
                    <option selected value="">All</option>
                  </select>
                </div>
                <div class="col-sm-3">
                  <label>IP</label>
                  <input type="text" class="form-control" id="al_ip_search" placeholder="Search" autocomplete="off" maxlength="255">
                </div>
                <div class="col-sm-3">
                  <label>&nbsp;</label>
                  <button type="button" class="btn bg-gray-dark btn-block" onclick="load_access_locations(1)"><i class="fas fa-search"></i> Search</button>
                </div>
              </div>
              <div id="list_of_access_locations_res" class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                <table id="list_of_access_locations_table" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>#</th>
                      <th>Car Maker</th>
                      <th>Car Model</th>
                      <th>IP</th>
                      <th>Date Updated</th>
                    </tr>
                  </thead>
                  <tbody id="list_of_access_locations" style="text-align: center;">
                    <tr>
                      <td colspan="5" style="text-align:center;">
                        <div class="spinner-border text-dark" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="d-flex justify-content-sm-end">
                <div class="dataTables_info" id="list_of_access_locations_info" role="status" aria-live="polite"></div>
              </div>
              <div class="d-flex justify-content-sm-center">
                <button type="button" class="btn bg-gray-dark" id="btnNextPage" style="display:none;" onclick="get_next_page()">Load more</button>
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
<?php include 'plugins/js/access_locations_script.php';?>
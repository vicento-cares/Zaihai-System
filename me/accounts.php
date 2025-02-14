<?php include 'plugins/navbar.php';?>
<?php include 'plugins/sidebar/me_bar.php';?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Accounts</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="accounts.php">Accounts</a></li>
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
          <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#new_account"><i class="fas fa-plus-circle"></i> Add Account</button>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="card card-gray-dark card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-user-cog"></i> Accounts Table</h3>
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
                  <label>Employee No.</label>
                  <input type="text" id="acct_emp_no_search" class="form-control" maxlength="255" autocomplete="off">
                </div>
                <div class="col-sm-6">
                  <label>Full Name</label>
                  <input type="text" id="acct_full_name_search" class="form-control" maxlength="255" autocomplete="off">
                </div>
                <div class="col-sm-3">
                  <label>Role</label>
                  <select id="acct_role_search" class="form-control" onchange="get_accounts()">
                    <option selected value="">Select Account Type</option>
                    <option value="Shop">Shop</option>
                    <option value="Inspector">Inspector</option>
                    <option value="BM">BM</option>
                    <option value="ME">ME</option>
                  </select>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 offset-sm-6">
                  <button type="button" class="btn btn-secondary btn-block" onclick="export_accounts('accountsTable')"><i class="fas fa-download"></i> Export</button>
                </div>
                <div class="col-sm-3">
                  <button type="button" class="btn btn-primary btn-block" onclick="get_accounts()"><i class="fas fa-search"></i> Search</button>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-2">
                  <span id="count_view"></span>
                </div>
              </div>
              <div class="table-responsive" style="max-height: 500px; overflow: auto; display:inline-block;">
                <table id="accountsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>#</th>
                      <th>Employee No.</th>
                      <th>Full Name</th>
                      <th>Role</th>
                      <th>Date Updated</th>
                    </tr>
                  </thead>
                  <tbody id="accountsData" style="text-align: center;">
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
<?php include 'plugins/js/accounts_script.php';?>
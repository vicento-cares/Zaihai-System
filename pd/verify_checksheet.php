<?php include 'plugins/navbar.php'; ?>
<?php include 'plugins/sidebar/pd_bar.php'; ?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Verify Checksheet</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="applicator_checksheet.php">Verify Checksheet</a></li>
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
          <input type="text" class="form-control" id="vc_applicator_no_search" placeholder="Scan Applicator No."
            oncopy="return false" onpaste="return false" autocomplete="off" maxlength="255">
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row mb-2">
        <div class="col-sm-12">
          <span class="text-bold" id="vc_search_result"></span>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </section>
</div>

<?php include 'plugins/footer.php'; ?>
<?php include 'plugins/js/verify_checksheet_script.php'; ?>
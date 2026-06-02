<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="applicator_shots_qa.php" class="brand-link">
    <img src="../dist/img/logo.ico" alt="Logo" class="brand-image elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Zaihai | QA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../dist/img/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="applicator_shots_qa.php" class="d-block"><?= isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Please Re-Login Account!'; ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <?php if ($_SERVER['REQUEST_URI'] == "/zaihai/qa/applicator_shots_qa.php") { ?>
          <a href="applicator_shots_qa.php" class="nav-link active">
          <?php } else { ?>
          <a href="applicator_shots_qa.php" class="nav-link">
          <?php } ?>
            <i class="nav-icon fas fa-search"></i>
            <p>
              Applicator Appearance Inspection Logging
            </p>
          </a>
        </li>
        <li class="nav-item">
          <?php if ($_SERVER['REQUEST_URI'] == "/zaihai/qa/applicator_shots_qah.php") { ?>
          <a href="applicator_shots_qah.php" class="nav-link active">
          <?php } else { ?>
          <a href="applicator_shots_qah.php" class="nav-link">
          <?php } ?>
            <i class="nav-icon fas fa-history"></i>
            <p>
              Applicator Appearance Inspection History
            </p>
          </a>
        </li>
        <?php include 'logout.php'; ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
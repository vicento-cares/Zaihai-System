<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="applicator_list.php" class="brand-link">
    <img src="../dist/img/logo.ico" alt="Logo" class="brand-image elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Zaihai | Shop</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../dist/img/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="applicator_list.php" class="d-block"><?= isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Please Re-Login Account!'; ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <?php if ($_SERVER['REQUEST_URI'] == "/zaihai/shop/applicator_list.php") { ?>
          <a href="applicator_list.php" class="nav-link active">
          <?php } else { ?>
          <a href="applicator_list.php" class="nav-link">
          <?php } ?>
            <i class="nav-icon fas fa-list"></i>
            <p>
              Applicator List
            </p>
          </a>
        </li>
        <li class="nav-item">
          <?php if ($_SERVER['REQUEST_URI'] == "/zaihai/shop/applicator_out.php") { ?>
          <a href="applicator_out.php" class="nav-link active">
          <?php } else { ?>
          <a href="applicator_out.php" class="nav-link">
          <?php } ?>
            <i class="nav-icon fas fa-cart-plus"></i>
            <p>
              Applicator Out
            </p>
          </a>
        </li>
        <li class="nav-item">
          <?php if ($_SERVER['REQUEST_URI'] == "/zaihai/shop/applicator_in.php") { ?>
          <a href="applicator_in.php" class="nav-link active">
          <?php } else { ?>
          <a href="applicator_in.php" class="nav-link">
          <?php } ?>
            <i class="nav-icon fas fa-th-large"></i>
            <p>
              Applicator In
            </p>
          </a>
        </li>
        <li class="nav-item">
          <?php if ($_SERVER['REQUEST_URI'] == "/zaihai/shop/applicator_checksheet.php") { ?>
          <a href="applicator_checksheet.php" class="nav-link active">
          <?php } else { ?>
          <a href="applicator_checksheet.php" class="nav-link">
          <?php } ?>
            <i class="nav-icon fas fa-tasks"></i>
            <p>
              Applicator Checksheet
            </p>
          </a>
        </li>
        <!-- <li class="nav-item">
          <?php if ($_SERVER['REQUEST_URI'] == "/zaihai/shop/shop_confirm.php") { ?>
          <a href="shop_confirm.php" class="nav-link active">
          <?php } else { ?>
          <a href="shop_confirm.php" class="nav-link">
          <?php } ?>
            <i class="nav-icon fas fa-tasks"></i>
            <p>
              Confirm BM Checksheet
            </p>
          </a>
        </li> -->
        <li class="nav-item">
          <?php if ($_SERVER['REQUEST_URI'] == "/zaihai/shop/applicator_history.php") { ?>
          <a href="applicator_history.php" class="nav-link active">
          <?php } else { ?>
          <a href="applicator_history.php" class="nav-link">
          <?php } ?>
            <i class="nav-icon fas fa-history"></i>
            <p>
              Applicator History
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
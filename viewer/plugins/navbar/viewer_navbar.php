        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-dark bg-gray-dark text-light border-bottom-0">
            <a href="" class="navbar-brand ml-2">
                <img src="../dist/img/logo.ico" alt="Logo" class="brand-image elevation-3 bg-light p-1"
                    style="opacity: .8">
                <span class="brand-text font-weight-light text-light">Zaihai System</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/zaihai/" class="nav-link"><i class="fas fa-home"></i> Homepage</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle active"><i class="fas fa-bars"></i> Menu</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <?php if ($_SERVER['REQUEST_URI'] == "/zaihai/viewer/applicator_out.php") { ?>
                            <li><a href="applicator_out.php" class="dropdown-item active">Applicator Out</a></li>
                            <?php } else { ?>
                            <li><a href="applicator_out.php" class="dropdown-item">Applicator Out</a></li>
                            <?php } ?>

                            <?php if ($_SERVER['REQUEST_URI'] == "/zaihai/viewer/applicator_in.php") { ?>
                            <li><a href="applicator_in.php" class="dropdown-item active">Applicator In</a></li>
                            <?php } else { ?>
                            <li><a href="applicator_in.php" class="dropdown-item">Applicator In</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="/zaihai/wi/" class="nav-link active"><i class="fas fa-file"></i> Work Instruction</a>
                    </li>
                    <li class="nav-item">
                        <a href="/zaihai/login/" target="_blank" class="nav-link active"><i class="fas fa-sign-in-alt"></i> Login</a>
                    </li>
                </ul>
            </div>

            <!-- Right navbar links -->
            <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
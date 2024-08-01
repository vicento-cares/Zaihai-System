<?php require '../process/login.php';

if (isset($_SESSION['emp_no'])) {
  if ($_SESSION['role'] == 'Shop') {
    header('location:/zaihai/shop/applicator_list.php');
  } else if ($_SESSION['role'] == 'Inspector') {
    header('location:/zaihai/inspector/applicator_checksheet.php');
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Zaihai System</title>

  <link rel="icon" href="../dist/img/logo.ico" type="image/x-icon" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="../dist/css/font.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <img src="../dist/img/logo.webp" style="height:100px;">
      <h2>Zaihai System</h2>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg"><b>Scan QR Code</b></p>

        <form action="" method="POST" id="login_form">
          <div class="input-group mb-3">
            <select class="form-control" id="role" name="role" required>
              <option disabled selected value="">Select Account Type</option>
              <option value="Shop">Shop</option>
              <option value="Inspector">Inspector</option>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-tasks"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="emp_no" name="emp_no" placeholder="ID Number" oncopy="return false" onpaste="return false" autofocus autocomplete="off" maxlength="50" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>   
          <!-- /.col -->
          <div class="input-group mb-3">
            <button type="submit" class="btn btn-primary btn-block" name="login_btn" value="login">Sign In</button>
          </div>
          <!-- /.col -->
        </form>
      </div>
    </div>
  </div>
</body>

<!-- jQuery -->
<script src="../plugins/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>

<script>
  // DOMContentLoaded function
  document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("emp_no").focus();
  });

  // var delay = (function(){
  //   var timer = 0;
  //   return function(callback, ms){
  //     clearTimeout (timer);
  //     timer = setTimeout(callback, ms);
  //   };
  // })();

  // $("#emp_no").on("input", function() {
  //   delay(function(){
  //     if ($("#emp_no").val().length < 51) {
  //       $("#emp_no").val("");
  //     }
  //   }, 100);
  // });
</script>

</body>
</html>

 <footer class="main-footer">
    <strong>Copyright &copy; 2024. Developed by: Vince Dale Alcantara</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Beta Version</b> 1.0.2
    </div>
  </footer>
<?php
//MODALS
include '../modals/logout_modal.php';
include '../modals/applicator_out.php';
include '../modals/applicator_in.php';
include '../modals/applicator_checksheet.php';
include '../modals/applicator_checksheet_shop_confirm.php';
include '../modals/applicator_checksheet_view.php';
?>
<!-- jQuery -->
<script src="../plugins/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- SweetAlert2 -->
<script type="text/javascript" src="../plugins/sweetalert2/dist/sweetalert2.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>

<!-- Idletime Script -->
<!-- <script src="../dist/js/idletime.js"></script> -->

</body>
</html>
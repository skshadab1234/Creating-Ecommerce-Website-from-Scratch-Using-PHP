
<input type="hidden" id="date" value="<?= $date ?>">
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <!-- Anything you want -->
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?= date("Y") ?> <a href="<?= ADMIN_FRONT_SITE ?>"><?= SITE_NAME ?></a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->


<!-- jQuery -->
<script src="https://adminlte.io/themes/v3/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://adminlte.io/themes/v3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://adminlte.io/themes/v3/dist/js/adminlte.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Custom Script  -->
<script src= "<?= ADMIN_FRONT_SITE.'admin_assets/js/script.js' ?>"></script>
</body>
</html>

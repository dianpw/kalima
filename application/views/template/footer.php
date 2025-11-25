            </div>
            <!-- /.container -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="container">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.0
                </div>
                <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#">Sistem Ujian Online</a>.</strong> All rights reserved.
            </div>
            <!-- /.container -->
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3.1.1 -->
    <script src="<?php echo base_url('assets/plugins/jQuery/jquery-3.1.1.min.js'); ?>"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
    
    <script>
        $(document).ready(function() {
            // Tambahkan efek smooth loading
            $('.box').hide().fadeIn(1000);
        });
    </script>
</body>
</html>
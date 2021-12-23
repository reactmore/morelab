<!DOCTYPE html>
<html lang="<?php echo selected_lang()->short_form ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo get_general_settings()->application_name ?> - <?php echo $title ?></title>
    <link rel="shortcut icon" href="<?php echo get_favicon(get_general_settings()); ?>">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/css/adminlte.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- File Manager css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/file-manager/file-manager-1.0.css">
    <!-- Upload -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/file-uploader/css/jquery.dm-uploader.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/file-uploader/css/styles-1.0.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/css/custom.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/bootstrap-4-tag-input/tagsinput.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script>
        csrfName = '<?php echo csrf_token() ?>';
        csrfCookie = '<?php echo config('cookie')->prefix . config('security')->cookieName ?>';
        baseUrl = "<?php echo base_url(); ?>";
        userId = "<?php echo session()->get('vr_sess_user_id'); ?>";
        select_image = "<?php echo trans("select_image"); ?>";
        sweetalert_ok = "<?php echo trans("ok"); ?>";
        sweetalert_cancel = "<?php echo trans("cancel"); ?>";
        var sys_lang_id = "<?php echo get_langguage_id(get_general_settings()->site_lang)->id; ?>";
    </script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/js/custom.js"></script>
</head>

<body class="hold-transition sidebar-mini <?php echo check_dark_mode_enabled() ? 'dark-mode' : '' ?> layout-fixed layout-footer-fixed layout-navbar-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo base_url(); ?>/public/assets/admin/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div> -->

        <?php echo $this->include('admin/includes/_header') ?>

        <?php echo $this->include('admin/includes/_sidebar') ?>

        <?php echo $this->renderSection('content') ?>

        <?php echo $this->include('admin/includes/_footer') ?>

    </div>
    <!-- ./wrapper -->


    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <?php echo view('admin/file-manager/_load_file_manager', ['load_images' => true, 'load_files' => true, 'load_videos' => false, 'load_audios' => false]); ?>
    <!-- File Manager -->
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/file-manager/file-manager-1.0.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/file-uploader/js/jquery.dm-uploader.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/file-uploader/js/ui.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/bootstrap-4-tag-input/tagsinput.js"></script>

    <!-- DataTables  & Plugins -->
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/jszip/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>/public/assets/admin/js/adminlte.js"></script>

    <script>
        <?php if (check_cron_time_minutes(1)) : ?>
            $.ajax({
                type: "POST",
                url: baseUrl + "/vr-run-internal-cron"
            });
        <?php endif; ?>

        function display_ct7() {
            var x = new Date()

            var ampm = x.getHours() >= 12 ? ' PM' : ' AM';
            hours = x.getHours() % 12;
            hours = hours ? hours : 12;
            hours = hours.toString().length == 1 ? 0 + hours.toString() : hours;

            var minutes = x.getMinutes().toString()
            minutes = minutes.length == 1 ? 0 + minutes : minutes;

            var seconds = x.getSeconds().toString()
            seconds = seconds.length == 1 ? 0 + seconds : seconds;

            var x1 = hours + ":" + minutes + ":" + seconds + " " + ampm;
            document.getElementById('ct7').innerHTML = x1;
            display_c7();
        }

        function display_c7() {
            var refresh = 1000; // Refresh rate in milli seconds
            mytime = setTimeout('display_ct7()', refresh)
        }
        display_c7()
    </script>

    <script>
        $(document).ready(function() {
            $('#cs_datatable').DataTable({
                language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'>",
                        next: "<i class='fas fa-angle-right'>"
                    }
                },

                "aLengthMenu": [
                    [15, 30, 60, 100],
                    [15, 30, 60, 100, "All"]
                ],
                drawCallback: function() {

                }
            });
            <?php if (session()->getFlashdata('success')) : ?>
                custom_alert('success', '<?php echo session()->getFlashdata('success'); ?>', false);
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                custom_alert('error', '<?php echo session()->getFlashdata('error'); ?>', false);
            <?php endif; ?>

        });
    </script>


</body>

</html>
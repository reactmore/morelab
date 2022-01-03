<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>/public/assets/admin/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/parsley/parsley.min.js"></script>
    <script>
        csrfName = '<?php echo csrf_token() ?>';
        csrfCookie = '<?php echo config('cookie')->prefix . config('security')->cookieName ?>';
        baseUrl = "<?php echo base_url(); ?>";
        userId = "<?php echo session()->get('vr_sess_user_id'); ?>";
    </script>
    <script src="<?php echo base_url(); ?>/public/assets/admin/js/custom.js"></script>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="<?php echo base_url(); ?>/public/assets/admin/index2.html" class="h1"><b><?php echo get_general_settings()->application_name ?></b></a>
            </div>
            <div class="card-body">
                <div class="text-center m-auto">
                    <img src="<?php echo base_url() ?>/public/assets/admin/img/mail_sent.svg" alt="mail sent image" height="64" />
                    <?php if (!empty($success)) : ?>
                        <h4 class="text-dark-50 text-center mt-4 fw-bold"><?php echo $title; ?></h4>
                        <p class="text-muted mb-4">
                            <?php echo $success; ?>
                        </p>
                    <?php elseif (!empty($error)) : ?>
                        <h4 class="text-dark-50 text-center mt-4 fw-bold"><?php echo $title; ?></h4>
                        <p class="text-muted mb-4">
                            <?php echo $error; ?>
                        </p>
                    <?php endif; ?>

                </div>

                <!-- form -->
                <form action="<?php echo lang_base_url(); ?>">
                    <div class="mb-0 d-grid text-center">
                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-home me-1"></i> <?php echo trans("btn_goto_home"); ?> </button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->


    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url(); ?>/public/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>/public/assets/admin/js/adminlte.min.js"></script>
</body>

</html>
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

                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                <?php echo $this->include('admin/includes/_messages') ?>
                <?php echo form_open("common/forgot_password_post", ['id' => 'form_safe', 'class' => '']); ?>
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control form-input" placeholder="Type <?php echo trans("email"); ?>" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block"><?php echo trans('forgot_password') ?></button>
                    </div>
                    <!-- /.col -->
                </div>
                <?php echo form_close(); ?>
                <p class="mt-3 mb-1">
                    <a href="<?php echo admin_url() ?>login"><?php echo trans('login') ?></a>
                </p>
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
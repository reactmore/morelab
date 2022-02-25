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

                <?php echo $this->include('admin/includes/_messages') ?>
                <form id="forms" action="<?php echo base_url(); ?>/common/admin_login_post" method="post">
                    <input type="hidden" id="crsf">
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="<?php echo trans('email') ?>" value="<?php echo old('email') ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>


                    <div class="input-group ">
                        <input type="password" name="password" class="form-control" placeholder="<?php echo trans('form_password') ?>" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <small><a href="<?php echo admin_url() ?>forgot-password"><?php echo trans('forgot_password') ?></a></small>

                    <div class="row mt-4">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember_me" id="remember" value="1">
                                <label for="remember">
                                    <?php echo trans("remember_me"); ?>
                                </label>
                            </div>
                        </div>

                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block"><?php echo trans("login"); ?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <?php if (!empty(get_general_settings()->facebook_app_id) || !empty(get_general_settings()->google_client_id)) : ?>
                    <div class="social-auth-links text-center mt-2 mb-3">
                        <p class="text-muted font-16"><?php echo trans("connect-with"); ?></p>
                        <?php if (!empty(get_general_settings()->facebook_app_id)) : ?>
                            <a href="<?php echo base_url('connect-with-facebook') ?>" class="btn btn-block btn-primary">
                                <i class="fab fa-facebook mr-2"></i> Facebook
                            </a>
                        <?php endif; ?>
                        <?php if (!empty(get_general_settings()->google_client_id)) : ?>
                            <a href="<?php echo base_url('connect-with-google') ?>" class="btn btn-block btn-danger">
                                <i class="fab fa-google-plus mr-2"></i> Google
                            </a>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
                <p class="mb-0 mt-3 text-muted">Don't have an account? <a href="<?php echo admin_url(); ?>register" class="text-muted ms-1"><b><?php echo trans("register"); ?></b></a></p>

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
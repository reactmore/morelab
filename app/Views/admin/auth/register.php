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
                <form id="form_safe" action="<?php echo base_url(); ?>/common/admin_register_post" method="post">
                    <input type="hidden" id="crsf">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="firstname" class="form-label"><?php echo trans('firstname') ?></label>
                                <input class="form-control" type="text" id="firstname" name="first_name" placeholder="<?php echo trans('firstname') ?>" value="<?php echo old('first_name') ?>" required>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="lastname" class="form-label"><?php echo trans('lastname') ?></label>
                                <input class="form-control" type="text" id="lastname" name="last_name" placeholder="<?php echo trans('lastname') ?>" value="<?php echo old('last_name') ?>" required>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="form-group">
                        <label for="username" class="form-label"><?php echo trans('form_username') ?></label>
                        <input class="form-control" type="text" id="username" name="username" placeholder="<?php echo trans('form_username') ?>" value="<?php echo old('username') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label"><?php echo trans('form_email') ?></label>
                        <input class="form-control" type="email" id="email" name="email" placeholder="<?php echo trans('form_email') ?>" value="<?php echo old('email') ?>" required>
                    </div>



                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="password" class="form-label"><?php echo  trans('form_password') ?></label>
                                <input class="form-control" type="password" id="password" name="password" placeholder="<?php echo trans('form_password') ?>" required>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="confirm_password"><?php echo trans("form_confirm_password"); ?></label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="<?php echo trans("form_confirm_password"); ?>" data-parsley-equalto="#password" required>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>





                    <?php if (recaptcha_status()) : ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="recaptcha-cnt">
                                    <?php generate_recaptcha(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="terms" id="checkbox-signup" value="1" required>
                                <label for="checkbox-signup">
                                    Agree to the <a href="#" class="text-primary">Terms of Use</a>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block"><?php echo trans("register"); ?></button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <?php if (!empty(get_general_settings()->facebook_app_id) || !empty(get_general_settings()->google_client_id)) : ?>
                    <div class="social-auth-links text-center mt-2 mb-3">
                        <p class="text-muted font-16"><?php echo trans("connect-with"); ?></p>

                        <?php if (!empty(get_general_settings()->google_client_id)) : ?>
                            <a href="<?php echo base_url('connect-with-google') ?>" class="btn btn-block btn-danger">
                                <i class="fab fa-google-plus mr-2"></i> Google
                            </a>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>
                <p class="mb-0 mt-3 text-muted">Already have an account ? <a href="<?php echo admin_url(); ?>login" class="font-weight-medium text-primary"> <?php echo trans('login') ?> </a> </p>

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
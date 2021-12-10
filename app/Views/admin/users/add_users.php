<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo trans('dashboard') ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>users"><?php echo trans('users') ?></a></li>
                            <li class="breadcrumb-item active"><?php echo $title ?></li>
                        <?php endif  ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <?php echo form_open_multipart('admin_controller/add_user_post', ['id' => 'form_add_user_post', 'class' => 'custom-validation needs-validation']); ?>
            <div class="row">
                <div class="col-lg-6 col-xl-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo trans("add_user"); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label><?php echo trans("username"); ?></label>
                                <input type="text" name="username" class="form-control auth-form-input" placeholder="<?php echo trans("username"); ?>" value="<?php echo old("username"); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label><?php echo trans("firstname"); ?></label>
                                <input type="text" name="firstname" class="form-control auth-form-input" placeholder="<?php echo trans("fullname"); ?>" value="<?php echo old("fullname"); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label><?php echo trans("lastname"); ?></label>
                                <input type="text" name="lastname" class="form-control auth-form-input" placeholder="<?php echo trans("fullname"); ?>" value="<?php echo old("fullname"); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label><?php echo trans("email"); ?></label>
                                <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("email"); ?>" value="<?php echo old("email"); ?>" parsley-type="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label><?php echo trans("form_password"); ?></label>
                                <input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("form_password"); ?>" value="<?php echo old("password"); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label><?php echo trans("role"); ?></label>
                                <select id="role" name="role" class="form-control select2" required>
                                    <option value=""><?php echo trans("select"); ?></option>
                                    <?php foreach ($roles as $role) : ?>
                                        <option value="<?php echo $role->role; ?>"><?php echo $role->role_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" id="single_submit" class="btn btn-primary float-right"><?php echo trans('add_user'); ?></button>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

            </div>
            <?php echo form_close(); ?>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<?php echo $this->endSection() ?>
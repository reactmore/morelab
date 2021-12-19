<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $title ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php if ($title === 'Dashboard') : ?>
                            <li class="breadcrumb-item active"><a href="<?php admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>roles-permissions"><?php echo trans('roles_permissions') ?></a></li>
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
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-uppercase"><?php echo trans("role_name"); ?> : <?php echo html_escape($role->role_name); ?></h5>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('admin/rolemanagement/edit_role_post', ['id' => 'form_edit_role_post', 'class' => 'mt-4 custom-validation needs-validation']); ?>

                            <input type="hidden" name="id" value="<?php echo html_escape($role->id); ?>">
                            <input type="hidden" name="role_name" value="<?php echo html_escape($role->role_name); ?>">


                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-1 col-sm-2 col-xs-2">
                                        <input type="checkbox" name="admin_panel" value="1" id="role_admin_panel" class="square-purple" <?php echo ($role->admin_panel == 1) ? 'checked' : ''; ?>>
                                    </div>
                                    <div class="col-md-11 col-sm-10 col-xs-10">
                                        <label for="role_admin_panel" class="control-label cursor-pointer"><?php echo trans('admin_panel'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-1 col-sm-2 col-xs-2">
                                        <input type="checkbox" name="users" value="1" id="role_users" class="square-purple" <?php echo ($role->users == 1) ? 'checked' : ''; ?>>
                                    </div>
                                    <div class="col-md-11 col-sm-10 col-xs-10">
                                        <label for="role_users" class="control-label cursor-pointer"><?php echo trans("users") ?></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-1 col-sm-2 col-xs-2">
                                        <input type="checkbox" name="settings" value="1" id="role_settings" class="square-purple" <?php echo ($role->settings == 1) ? 'checked' : ''; ?>>
                                    </div>
                                    <div class="col-md-11 col-sm-10 col-xs-10">
                                        <label for="role_settings" class="control-label cursor-pointer"><?php echo trans("settings") ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?> </button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<style>
    .form-group mb-3 .col-sm-2 {
        max-width: 40px;
        padding-right: 0 !important;
    }
</style>


<?php echo $this->endSection() ?>
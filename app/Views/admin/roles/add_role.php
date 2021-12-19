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
                            <h5 class="card-title text-uppercase"><?php echo trans("add"); ?> </h5>
                        </div>
                        <div class="card-body">
                            <?php echo form_open('admin/rolemanagement/add_role_post', ['id' => 'form_edit_role_post', 'class' => 'mt-4 custom-validation needs-validation']); ?>
                            <div class="form-group mb-3">
                                <label><?php echo trans("role"); ?></label>
                                <input type="text" name="role" class="form-control auth-form-input" placeholder="<?php echo trans("role"); ?>" value="<?php echo old("role"); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary float-right"><?php echo trans('save'); ?> </button>
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
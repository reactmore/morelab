<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
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
            <?php echo form_open_multipart('admin/usermanagement/add_user_post', ['id' => 'form_add_user_post', 'class' => 'custom-validation needs-validation']); ?>
            <?php echo $this->include('admin/includes/_messages') ?>
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="tab-form-add-user" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-basic-tab" data-toggle="pill" href="#custom-tabs-basic" role="tab" aria-controls="custom-tabs-basic" aria-selected="true">Basic Informations</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-role-tab" data-toggle="pill" href="#custom-tabs-role" role="tab" aria-controls="custom-tabs-role" aria-selected="false">Role</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">

                                <div class="tab-pane fade show active" id="custom-tabs-basic" role="tabpanel" aria-labelledby="custom-tabs-basic-tab">

                                    <div class="form-group mb-3">
                                        <label><?php echo trans("username"); ?></label>
                                        <input type="text" name="username" class="form-control auth-form-input" placeholder="<?php echo trans("username"); ?>" value="<?php echo old("username"); ?>" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("firstname"); ?></label>
                                                <input type="text" name="first_name" class="form-control auth-form-input" placeholder="<?php echo trans("firstname"); ?>" value="<?php echo old("first_name"); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("lastname"); ?></label>
                                                <input type="text" name="last_name" class="form-control auth-form-input" placeholder="<?php echo trans("lastname"); ?>" value="<?php echo old("last_name"); ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("mobile_no"); ?></label>
                                                <input type="text" name="mobile_no" class="form-control auth-form-input" placeholder="<?php echo trans("mobile_no"); ?>" value="<?php echo old("mobile_no"); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("email"); ?></label>
                                                <input type="email" name="email" class="form-control auth-form-input" placeholder="<?php echo trans("email"); ?>" value="<?php echo old("email"); ?>" parsley-type="email" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3 float-right">
                                        <a href="javascript: void(0);" class="btn btn-primary  btnNext"><?php echo 'Next'; ?></a>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="custom-tabs-role" role="tabpanel" aria-labelledby="custom-tabs-role-tab">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("form_password"); ?></label>
                                                <input type="password" name="password" class="form-control auth-form-input" placeholder="<?php echo trans("form_password"); ?>" value="<?php echo old("password"); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label><?php echo trans("role"); ?></label>
                                                <select id="role" name="role" class="form-control select2" required>
                                                    <option value=""><?php echo trans("select"); ?></option>
                                                    <?php foreach ($roles as $role) : ?>
                                                        <option value="<?php echo $role->role; ?>"><?php echo $role->role_name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3 float-right">
                                        <a href="javascript: void(0);" class="btn btn-primary  btnPrevious"><?php echo 'Previous'; ?></a>
                                        <button type="submit" id="single_submit" class="btn btn-primary"><?php echo trans('save_changes'); ?></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer clearfix">
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div> <!-- end col -->

        </div>
        <?php echo form_close(); ?>
        <!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<?php echo $this->endSection() ?>
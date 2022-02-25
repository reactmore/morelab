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
                            <li class="breadcrumb-item"><a href="<?php admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>settings/general"><?php echo trans('settings') ?></a></li>
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
                <div class="col-xl-4 col-lg-5">
                    <?php echo $this->include('admin/settings/_tabs') ?>
                </div>
                <!-- Right Sidebar -->
                <div class="col-xl-8 col-lg-7">


                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="app-search">

                                    <div class="mb-2 position-relative">
                                        <h5 class="mb-4 text-uppercase"><i class="fa fa-cog pr-2"></i><?php echo trans('google') ?></h5>

                                    </div>
                                </div>

                            </div>

                            <div class="mt-0">
                                <div class="row">
                                    <div class="col-12">
                                        <?php echo form_open('admin/generalsettings/social_login_google_post'); ?>
                                        <!-- include message block -->
                                        <?php if (!empty(session()->getFlashdata('msg_social_google'))) :
                                            echo view('admin/includes/_messages');
                                        endif; ?>

                                        <div class="form-group mb-3">
                                            <label for="google_client_id" class="form-label"><?php echo trans('client_id'); ?></label>
                                            <div class="input-group">
                                                <input type="password" id="google_client_id" name="google_client_id" class="form-control" placeholder="<?php echo trans('client_id'); ?>" value="<?php echo $settings->google_client_id; ?>">
                                                <div class="input-group-prepend" data-toggle="password" data-target="#google_client_id" data-icon="#icon-eye-2">
                                                    <span class="input-group-text"><i id="icon-eye-2" class="fa fa-eye"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="google_client_secret" class="form-label"><?php echo trans('client_secret'); ?></label>
                                            <div class="input-group">
                                                <input type="password" id="google_client_secret" name="google_client_secret" class="form-control" placeholder="<?php echo trans('client_secret'); ?>" value="<?php echo $settings->google_client_secret; ?>">
                                                <div class="input-group-prepend" data-toggle="password" data-target="#google_client_secret" data-icon="#icon-eye-3">
                                                    <span class="input-group-text"><i id="icon-eye-3" class="fa fa-eye"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" name="submit" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>

                                        <?php echo form_close(); ?>
                                    </div>
                                </div>



                            </div>


                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                    <!-- Github  -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="app-search">

                                    <div class="mb-2 position-relative">
                                        <h5 class="mb-4 text-uppercase"><i class="fa fa-cog pr-2"></i><?php echo 'Github' ?></h5>

                                    </div>
                                </div>

                            </div>

                            <div class="mt-0">
                                <div class="row">
                                    <div class="col-12">
                                        <?php echo form_open('admin/generalsettings/social_login_github_post'); ?>
                                        <!-- include message block -->
                                        <?php if (!empty(session()->getFlashdata('msg_social_github'))) :
                                            echo view('admin/includes/_messages');
                                        endif; ?>

                                        <div class="form-group mb-3">
                                            <label for="github_client_id" class="form-label"><?php echo trans('client_id'); ?></label>
                                            <div class="input-group">
                                                <input type="password" id="github_client_id" name="github_client_id" class="form-control" placeholder="<?php echo trans('client_id'); ?>" value="<?php echo $settings->github_client_id; ?>">
                                                <div class="input-group-prepend" data-toggle="password" data-target="#github_client_id" data-icon="#icon-eye-4">
                                                    <span class="input-group-text"><i id="icon-eye-4" class="fa fa-eye"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="github_client_secret" class="form-label"><?php echo trans('client_secret'); ?></label>
                                            <div class="input-group">
                                                <input type="password" id="github_client_secret" name="github_client_secret" class="form-control" placeholder="<?php echo trans('client_secret'); ?>" value="<?php echo $settings->github_client_secret; ?>">
                                                <div class="input-group-prepend" data-toggle="password" data-target="#github_client_secret" data-icon="#icon-eye-5">
                                                    <span class="input-group-text"><i id="icon-eye-5" class="fa fa-eye"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" name="submit" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>

                                        <?php echo form_close(); ?>
                                    </div>
                                </div>



                            </div>


                        </div> <!-- end card body -->
                    </div> <!-- end card -->

                </div>
                <!-- end Col -->
            </div><!-- End row -->
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
<!-- /.content-wrapper -->
<?php echo $this->endSection() ?>
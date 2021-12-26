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
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>settings/cache-system"><?php echo trans('settings') ?></a></li>
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
                                        <h5 class="mb-4 text-uppercase"><i class="fa fa-cog pr-2"></i><?php echo trans('cache_system') ?></h5>

                                    </div>
                                </div>

                            </div>

                            <div class="mt-0">
                                <div class="row">
                                    <div class="col-12">
                                        <?php echo form_open('admin/generalsettings/cache_system_post'); ?>
                                        <!-- include message block -->
                                        <?php echo view('admin/includes/_messages'); ?>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-5 col-xs-12">
                                                    <label><?php echo trans('cache_system'); ?></label>
                                                </div>
                                                <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                                    <input type="radio" name="cache_system" value="1" id="cache_system_1" class="square-purple" <?php echo ($settings->cache_system == 1) ? 'checked' : ''; ?>>
                                                    <label for="cache_system_1" class="option-label"><?php echo trans('enable'); ?></label>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                                    <input type="radio" name="cache_system" value="0" id="cache_system_2" class="square-purple" <?php echo ($settings->cache_system != 1) ? 'checked' : ''; ?>>
                                                    <label for="cache_system_2" class="option-label"><?php echo trans('disable'); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-5 col-xs-12">
                                                    <label><?php echo trans('refresh_cache_database_changes'); ?></label>
                                                </div>
                                                <div class="col-md-3 col-sm-4 col-xs-12 col-option">
                                                    <input type="radio" name="refresh_cache_database_changes" value="1" id="refresh_cache_database_changes_1" class="square-purple" <?php echo ($settings->refresh_cache_database_changes == 1) ? 'checked' : ''; ?>>
                                                    <label for="refresh_cache_database_changes_1" class="option-label"><?php echo trans('yes'); ?></label>
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-12 col-option">
                                                    <input type="radio" name="refresh_cache_database_changes" value="0" id="refresh_cache_database_changes_2" class="square-purple" <?php echo ($settings->refresh_cache_database_changes != 1) ? 'checked' : ''; ?>>
                                                    <label for="refresh_cache_database_changes_2" class="option-label"><?php echo trans('no'); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><?php echo trans('cache_refresh_time'); ?></label>&nbsp;
                                            <small>(<?php echo trans("cache_refresh_time_exp"); ?>)</small>
                                            <input type="number" class="form-control" name="cache_refresh_time" placeholder="<?php echo trans('cache_refresh_time'); ?>" value="<?php echo ($settings->cache_refresh_time / 60); ?>">
                                        </div>

                                        <button type="submit" name="action" value="save" class="btn btn-primary float-right ml-2"><?php echo trans('save_changes'); ?></button>
                                        <button type="submit" name="action" value="reset" class="btn btn-warning float-right "><?php echo trans('reset_cache'); ?></button>
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
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
                                        <h5 class="mb-4 text-uppercase"><i class="fa fa-cog pr-2"></i><?php echo trans('visual_settings') ?></h5>

                                    </div>
                                </div>

                            </div>

                            <div class="mt-0">
                                <?php echo form_open_multipart('admin/generalsettings/visual_settings_post'); ?>
                                <?php echo view('admin/includes/_messages'); ?>

                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo trans('logo'); ?></label>
                                    <div style="margin-bottom: 10px;">
                                        <img src="<?php echo get_logo($visual_settings); ?>" alt="logo" style="max-width: 250px; max-height: 250px;">
                                    </div>
                                    <div class="display-block">
                                        <a class='btn btn-success btn-sm btn-file-upload'>
                                            <?php echo trans('change'); ?>
                                            <input type="file" name="logo" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info1').html($(this).val().replace(/.*[\/\\]/, ''));">
                                        </a>
                                        (.png, .jpg, .jpeg, .gif, .svg)
                                    </div>
                                    <span class='label label-info' id="upload-file-info1"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo trans('logo_dark'); ?></label>
                                    <div style="margin-bottom: 10px;">
                                        <img src="<?php echo get_logo_dark($visual_settings); ?>" alt="logo" style="max-width: 250px; max-height: 250px;">
                                    </div>
                                    <div class="display-block">
                                        <a class='btn btn-success btn-sm btn-file-upload'>
                                            <?php echo trans('change'); ?>
                                            <input type="file" name="logo_dark" size="40" accept=".png, .jpg, .jpeg, .gif, .svg" onchange="$('#upload-file-info2').html($(this).val().replace(/.*[\/\\]/, ''));">
                                        </a>
                                        (.png, .jpg, .jpeg, .gif, .svg)
                                    </div>
                                    <span class='label label-info' id="upload-file-info2"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo trans('logo_email'); ?></label>
                                    <div style="margin-bottom: 10px;">
                                        <img src="<?php echo get_logo_email($visual_settings); ?>" alt="logo" style="max-width: 200px; max-height: 200px;">
                                    </div>
                                    <div class="display-block">
                                        <a class='btn btn-success btn-sm btn-file-upload'>
                                            <?php echo trans('change'); ?>
                                            <input type="file" name="logo_email" size="40" accept=".png, .jpg, .jpeg" onchange="$('#upload-file-info3').html($(this).val().replace(/.*[\/\\]/, ''));">
                                        </a>
                                        (.png, .jpg, .jpeg)
                                    </div>
                                    <span class='label label-info' id="upload-file-info3"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo trans('favicon'); ?> (16x16px)</label>
                                    <div style="margin-bottom: 10px;">
                                        <img src="<?php echo get_favicon($visual_settings); ?>" alt="favicon" style="max-width: 100px; max-height: 100px;">
                                    </div>
                                    <div class="display-block">
                                        <a class='btn btn-success btn-sm btn-file-upload'>
                                            <?php echo trans('change'); ?>
                                            <input type="file" name="favicon" size="40" accept=".png" onchange="$('#upload-file-info4').html($(this).val().replace(/.*[\/\\]/, ''));">
                                        </a>
                                        (.png)
                                    </div>
                                    <span class='label label-info' id="upload-file-info4"></span>
                                </div>

                                <div class="form-group mb-3">
                                    <button type="submit" name="submit" value="logo" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>
                                </div>
                                <?php echo form_close(); ?>
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
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
                                        <h5 class="mb-4 text-uppercase"><i class="fa fa-cog pr-2"></i><?php echo trans('general_settings') ?></h5>

                                    </div>
                                </div>

                            </div>

                            <div class="mt-3">
                                <?php echo form_open_multipart('administrator/settings_post'); ?>

                                <?php if (!empty(session()->getFlashdata("mes_settings"))) :
                                    echo $this->include('admin/includes/_messages');
                                endif; ?>

                                <div class="mb-3">
                                    <label class="form-label"><?php echo trans("language_settings"); ?></label>
                                    <select name="lang_id" class="form-control max-400" onchange="window.location.href = '<?php echo admin_url(); ?>'+'settings?lang='+this.value;">
                                        <?php foreach (get_langguage() as $language) : ?>
                                            <option value="<?php echo $language->id; ?>" <?php echo ($selected_lang == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><?php echo trans('app_name'); ?></label>
                                    <input type="text" class="form-control" name="application_name" placeholder="<?php echo trans('app_name'); ?>" value="<?php echo html_escape($settings->application_name); ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><?php echo trans('timezone'); ?></label>
                                    <select name="timezone" class="form-control max-600">
                                        <?php $timezones = timezone_identifiers_list();
                                        if (!empty($timezones)) :
                                            foreach ($timezones as $timezone) : ?>
                                                <option value="<?php echo $timezone; ?>" <?php echo ($timezone == $settings->timezone) ? 'selected' : ''; ?>><?php echo $timezone; ?></option>
                                        <?php endforeach;
                                        endif; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><?php echo trans('copyright'); ?></label>
                                    <input type="text" class="form-control" name="copyright" placeholder="<?php echo trans('copyright'); ?>" value="<?php echo html_escape($settings->copyright); ?>">
                                </div>

                                <h5 class="mb-3 text-uppercase bg-light p-2"><i class="fa fa-cog pr-2"></i> <?php echo trans('contact_settings') ?></h5>

                                <div class="mb-3 ">
                                    <label class="form-label">Contact <?php echo trans('name'); ?></label>
                                    <input type="text" class="form-control" name="contact_name" placeholder="<?php echo trans('name'); ?>" value="<?php echo html_escape($settings->contact_name); ?>">
                                </div>

                                <div class="mb-3 ">
                                    <label class="form-label"><?php echo trans('address'); ?></label>
                                    <input type="text" class="form-control" name="contact_address" placeholder="<?php echo trans('address'); ?>" value="<?php echo html_escape($settings->contact_address); ?>">
                                </div>

                                <div class="mb-3 ">
                                    <label class="form-label"><?php echo trans('email'); ?></label>
                                    <input type="text" class="form-control" name="contact_email" placeholder="<?php echo trans('email'); ?>" value="<?php echo html_escape($settings->contact_email); ?>">
                                </div>

                                <div class="mb-3 ">
                                    <label class="form-label"><?php echo trans('phone'); ?></label>
                                    <input type="text" class="form-control" name="contact_phone" placeholder="<?php echo trans('phone'); ?>" value="<?php echo html_escape($settings->contact_phone); ?>">
                                </div>

                                <div class="mb-3 ">
                                    <label class="form-label"><?php echo trans('contact_text'); ?></label>
                                    <textarea class="tinyMCE form-control" name="contact_text"><?php echo $settings->contact_text; ?></textarea>
                                </div>


                                <button type="submit" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>
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
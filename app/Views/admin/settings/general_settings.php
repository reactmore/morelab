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
                                        <h5 class="mb-4 text-uppercase"><i class="fa fa-cog pr-2"></i><?php echo trans('general_settings') ?></h5>

                                    </div>
                                </div>

                            </div>

                            <div class="mt-3">

                                <ul class="nav nav-tabs mb-3">
                                    <li class="nav-item">
                                        <a href="#settings" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                            <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                            <span class="d-none d-md-block"><?php echo trans('settings') ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#maintenance_mode" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                            <span class="d-none d-md-block"><?php echo trans('maintenance_mode') ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#google_recaptcha" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                            <span class="d-none d-md-block"><?php echo trans('google_recaptcha') ?></span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="settings">
                                        <?php echo form_open_multipart('admin/settings/settings-post'); ?>

                                        <?php if (!empty(session()->getFlashdata("mes_settings"))) :
                                            echo $this->include('admin/includes/_messages');
                                        endif; ?>

                                        <div class="mb-3">
                                            <label class="form-label"><?php echo trans("language_settings"); ?></label>
                                            <select name="lang_id" class="form-control max-400" onchange="window.location.href = '<?php echo admin_url(); ?>'+'settings/general?lang='+this.value;">
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

                                    <div class="tab-pane show" id="maintenance_mode">
                                        <?php echo form_open('admin/settings/maintenance-mode-post'); ?>
                                        <!-- include message block -->
                                        <?php if (!empty(session()->getFlashdata("mes_maintenance"))) :
                                            echo view('admin/includes/_messages');
                                        endif; ?>
                                        <div class="form-group mb-3">
                                            <label class="form-label"><?php echo trans('title'); ?></label>
                                            <input type="text" class="form-control" name="maintenance_mode_title" placeholder="<?php echo trans('title'); ?>" value="<?php echo get_general_settings()->maintenance_mode_title; ?>">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label"><?php echo trans('description'); ?></label>
                                            <textarea class="form-control text-area" name="maintenance_mode_description" placeholder="<?php echo trans('description'); ?>" style="min-height: 100px;"><?php echo html_escape(get_general_settings()->maintenance_mode_description); ?></textarea>
                                        </div>

                                        <div class="form-group mb-3">
                                            <div class="row">
                                                <div class="col-sm-4 col-xs-12">
                                                    <label><?php echo trans('status'); ?></label>
                                                </div>
                                                <div class="col-sm-4 col-xs-12 col-option">
                                                    <input type="radio" name="maintenance_mode_status" value="1" id="maintenance_mode_status_1" class="square-purple" <?php echo (get_general_settings()->maintenance_mode_status == 1) ? 'checked' : ''; ?>>
                                                    <label for="maintenance_mode_status_1" class="option-label"><?php echo trans('enable'); ?></label>
                                                </div>
                                                <div class="col-sm-4 col-xs-12 col-option">
                                                    <input type="radio" name="maintenance_mode_status" value="0" id="maintenance_mode_status_2" class="square-purple" <?php echo (get_general_settings()->maintenance_mode_status != 1) ? 'checked' : ''; ?>>
                                                    <label for="maintenance_mode_status_2" class="option-label"><?php echo trans('disable'); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>
                                        <?php echo form_close(); ?>
                                    </div>

                                    <div class="tab-pane" id="google_recaptcha">
                                        <?php echo form_open('admin/settings/recaptcha-settings-post'); ?>
                                        <?php if (!empty(session()->getFlashdata("mes_recaptcha"))) :
                                            echo view('admin/includes/_messages');
                                        endif; ?>
                                        <div class="form-group  mb-3">
                                            <label class="form-label"><?php echo trans('site_key'); ?></label>
                                            <input type="text" class="form-control" name="recaptcha_site_key" placeholder="<?php echo trans('site_key'); ?>" value="<?php echo get_general_settings()->recaptcha_site_key; ?>">
                                        </div>

                                        <div class="form-group  mb-3">
                                            <label class="form-label"><?php echo trans('secret_key'); ?></label>
                                            <input type="text" class="form-control" name="recaptcha_secret_key" placeholder="<?php echo trans('secret_key'); ?>" value="<?php echo get_general_settings()->recaptcha_secret_key; ?>">
                                        </div>

                                        <div class="form-group  mb-3">
                                            <label class="form-label"><?php echo trans('language'); ?></label>
                                            <input type="text" class="form-control" name="recaptcha_lang" placeholder="<?php echo trans('language'); ?>" value="<?php echo get_general_settings()->recaptcha_lang; ?>">
                                            <a href="https://developers.google.com/recaptcha/docs/language" target="_blank">https://developers.google.com/recaptcha/docs/language</a>
                                        </div>
                                        <button type="submit" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>
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
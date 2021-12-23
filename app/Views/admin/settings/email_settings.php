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
                                        <h5 class="mb-4 text-uppercase"><i class="fa fa-cog pr-2"></i><?php echo trans('email_settings') ?></h5>

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
                                        <a href="#email_verification" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                            <span class="d-none d-md-block"><?php echo trans('email_verification') ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#send_test_email" data-toggle="tab" aria-expanded="false" class="nav-link">
                                            <i class="mdi mdi-settings-outline d-md-none d-block"></i>
                                            <span class="d-none d-md-block"><?php echo trans('send_test_email') ?></span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane show active" id="settings">
                                        <?php echo form_open('admin/generalsettings/email_settings_post'); ?>
                                        <?php
                                        $message = session()->getFlashdata('message_type');
                                        if (!empty($message) && $message == "email") {
                                            echo $this->include('admin/includes/_messages');
                                        }
                                        ?>

                                        <div class="form-group mb-3">
                                            <label class="form-label"><?php echo trans('mail_protocol'); ?></label>
                                            <select name="mail_protocol" class="form-control" onchange="window.location.href = '<?php echo admin_url(); ?>settings/email?protocol='+this.value;">
                                                <option value="smtp" <?php echo $protocol == "smtp" ? "selected" : ""; ?>><?php echo trans('smtp'); ?></option>
                                                <option value="mail" <?php echo $protocol == "mail" ? "selected" : ""; ?>><?php echo trans('mail'); ?></option>
                                            </select>
                                        </div>

                                        <?php if ($protocol == "smtp") : ?>
                                            <div class="form-group mb-3">
                                                <label class="form-label"><?php echo trans('mail_library'); ?></label>
                                                <select name="mail_library" class="form-control">
                                                    <option value="swift" <?php echo $settings->mail_library == "swift" ? "selected" : ""; ?>>Swift Mailer</option>
                                                    <option value="php" <?php echo $settings->mail_library == "php" ? "selected" : ""; ?>>PHP Mailer</option>
                                                </select>
                                            </div>
                                        <?php else : ?>
                                            <input type="hidden" name="mail_library" value="php">
                                        <?php endif; ?>

                                        <?php if ($protocol == "smtp") : ?>
                                            <div class="form-group mb-3">
                                                <label class="form-label"><?php echo trans('encryption'); ?></label>
                                                <select name="mail_encryption" class="form-control">
                                                    <option value="tls" <?php echo $settings->mail_encryption == "tls" ? "selected" : ""; ?>>TLS</option>
                                                    <option value="ssl" <?php echo $settings->mail_encryption == "ssl" ? "selected" : ""; ?>>SSL</option>
                                                </select>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label"><?php echo trans('mail_host'); ?></label>
                                                <input type="text" class="form-control" name="mail_host" placeholder="<?php echo trans('mail_host'); ?>" value="<?php echo html_escape($settings->mail_host); ?>">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label"><?php echo trans('mail_port'); ?></label>
                                                <input type="text" class="form-control" name="mail_port" placeholder="<?php echo trans('mail_port'); ?>" value="<?php echo html_escape($settings->mail_port); ?>">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label"><?php echo trans('mail_username'); ?></label>
                                                <input type="text" class="form-control" name="mail_username" placeholder="<?php echo trans('mail_username'); ?>" value="<?php echo html_escape($settings->mail_username); ?>">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label"><?php echo trans('mail_password'); ?></label>
                                                <input type="password" class="form-control" name="mail_password" placeholder="<?php echo trans('mail_password'); ?>" value="<?php echo html_escape($settings->mail_password); ?>">
                                            </div>
                                        <?php else : ?>
                                            <input type="hidden" name="mail_encryption" value="<?php echo $settings->mail_encryption; ?>">
                                            <input type="hidden" name="mail_host" value="<?php echo $settings->mail_host; ?>">
                                            <input type="hidden" name="mail_port" value="<?php echo $settings->mail_port; ?>">
                                            <input type="hidden" name="mail_username" value="<?php echo $settings->mail_username; ?>">
                                            <input type="hidden" name="mail_password" value="<?php echo $settings->mail_password; ?>">
                                        <?php endif; ?>

                                        <div class="form-group mb-3">
                                            <label class="form-label"><?php echo trans('mail_title'); ?></label>
                                            <input type="text" class="form-control" name="mail_title" placeholder="<?php echo trans('mail_title'); ?>" value="<?php echo html_escape($settings->mail_title); ?>">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label"><?php echo trans('reply_to'); ?></label>
                                            <input type="email" class="form-control" name="mail_reply_to" placeholder="<?php echo trans('reply_to'); ?>" value="<?php echo html_escape($settings->mail_reply_to); ?>">
                                        </div>


                                        <button type="submit" name="submit" value="email" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>
                                        <?php echo form_close(); ?>
                                    </div>

                                    <div class="tab-pane" id="email_verification">
                                        <?php echo form_open('admin/generalsettings/email_verification_settings_post'); ?>
                                        <?php
                                        if (!empty($message) && $message == "verification") {
                                            echo $this->include('admin/includes/_messages');
                                        } ?>
                                        <div class="form-group mb-3">
                                            <div class="row">
                                                <div class="col-sm-12 col-xs-12">
                                                    <label><?php echo trans('email_verification'); ?></label>
                                                </div>
                                                <div class="col-sm-4 col-xs-12 col-option">
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" id="email_verification_1" name="email_verification" value="1" class="form-check-input" <?php echo ($settings->email_verification == '1') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="email_verification_1"><?php echo trans('enable'); ?></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4 col-xs-12 col-option">
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" id="email_verification_2" name="email_verification" value="0" class="form-check-input" <?php echo ($settings->email_verification == '0') ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="email_verification_2"><?php echo trans('disable'); ?></label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <button type="submit" name="submit" value="verification" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>
                                        <?php echo form_close(); ?>
                                    </div>

                                    <div class="tab-pane" id="send_test_email">

                                        <?php echo form_open('admin/generalsettings/send_test_email_post'); ?>
                                        <!-- include message block -->
                                        <?php
                                        if (!empty($message) && $message == "send_email") {
                                            echo $this->include('admin/includes/_messages');
                                        } ?>


                                        <div class="form-group mb-3">
                                            <label class="form-label"><?php echo trans('email'); ?></label>
                                            <input type="text" class="form-control" name="email" placeholder="<?php echo trans('placeholder_email'); ?>" required>
                                        </div>
                                        <button type="submit" name="submit" value="contact" class="btn btn-primary float-right"><?php echo trans('send_email'); ?></button>

                                        <?php echo form_close(); ?>

                                        <p class="card-title-desc mt-3">*<?php echo trans('send_test_email_exp'); ?></p>
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
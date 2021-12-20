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
                <div class="col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <?php echo trans('telegram_configurations') ?>
                        </div>
                        <div class="card-body">
                            <!-- form start -->
                            <?php echo form_open_multipart('admin/telegramsettings/configurations_post', ['id' => 'form_add_language_post', 'class' => 'custom-validation needs-validation']); ?>

                            <?php if (empty(session()->getFlashdata('mes_settings'))) :
                                echo view('admin/includes/_messages');
                            endif; ?>

                            <div class="form-group mb-3">
                                <label><?php echo trans("tg_bot_api_key"); ?></label>
                                <input type="text" class="form-control" name="bot_api_key" placeholder="<?php echo trans("tg_bot_api_key"); ?>" value="<?php echo $telegram->bot_api_key; ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label><?php echo trans("tg_bot_username"); ?></label>
                                <input type="text" class="form-control" name="bot_username" placeholder="<?php echo trans("tg_bot_username"); ?>" value="<?php echo $telegram->bot_username; ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label><?php echo trans("tg_bot_name"); ?></label>
                                <input type="text" class="form-control" name="bot_name" placeholder="<?php echo trans("tg_bot_name"); ?>" value="<?php echo $telegram->bot_name; ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label><?php echo trans("tg_webhook_url"); ?></label>
                                <input type="text" class="form-control" name="webhook_url" placeholder="<?php echo trans("tg_webhook_url"); ?>" value="<?php echo $telegram->webhook_url; ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label><?php echo trans("tg_bot_admin"); ?></label>
                                <input type="text" data-role="tagsinput" class="form-control" name="bot_admin" placeholder="<?php echo trans("tg_bot_admin"); ?>" value="<?php echo $telegram->bot_admin; ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label><?php echo trans("tg_channel_id"); ?></label>
                                <input type="text" class="form-control" name="channel_id" placeholder="<?php echo trans("tg_channel_id"); ?>" value="<?php echo $telegram->channel_id; ?>">
                            </div>

                            <div class="form-group mb-3">
                                <label><?php echo trans("tg_channel_username"); ?></label>
                                <input type="text" class="form-control" name="channel_username" placeholder="<?php echo trans("tg_channel_username"); ?>" value="<?php echo $telegram->channel_username; ?>" required>
                            </div>



                            <div class="form-group mb-3">
                                <div class="col-sm-4 col-xs-12">
                                    <label><?php echo trans('tg_auth'); ?></label>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12 col-option">
                                        <input type="radio" id="rb_type_1" name="bot_auth" value="1" class="square-purple" <?php echo ($telegram->bot_auth == 1) ? 'checked' : ''; ?>>
                                        <label for="rb_type_1" class="cursor-pointer"><?php echo trans("enable"); ?></label>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 col-option">
                                        <input type="radio" id="rb_type_2" name="bot_auth" value="0" class="square-purple" <?php echo ($telegram->bot_auth != 1) ? 'checked' : ''; ?>>
                                        <label for="rb_type_2" class="cursor-pointer"><?php echo trans("disable"); ?></label>
                                    </div>
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary float-right"><?php echo trans('save'); ?></button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <?php echo trans('telegram_bot') ?>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped" role="grid">
                                <thead>
                                    <tr role="row">
                                        <th width="30"><?php echo trans('tg_bot_name'); ?></th>
                                        <th width="40" class="text-center"><?php echo trans('status'); ?></th>
                                        <th width="30" class="text-center"><?php echo trans('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td><strong style="font-weight: 600;"><?php echo $telegram->bot_name; ?></strong></td>
                                        <td class="text-center">
                                            <?php if ($telegram->status == 1) : ?>
                                                <small class="btn btn-sm btn-success "><?php echo trans("enable"); ?></small>
                                            <?php else : ?>
                                                <small class="btn btn-sm btn-danger "><?php echo trans("disable"); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($telegram->status == 1) : ?>


                                                <center>
                                                    <button class="btn btn-sm btn-danger mr-2 text-center" onclick="telegram_bot_set('<?php echo $telegram->id; ?>','Are You Sure?', 'deletewebhook');">
                                                        <i class="fa fa-pause"></i>
                                                    </button>


                                                    <button class="btn btn-sm btn-danger text-center" onclick="telegram_bot_set('<?php echo $telegram->id; ?>','Are You Sure?', 'deletewebhook');">
                                                        <i class="fa fa-sync"></i>
                                                    </button>
                                                </center>


                                            <?php elseif ($telegram->status == 0) : ?>
                                                <button class="btn btn-sm btn-primary text-center" onclick="telegram_bot_set('<?php echo $telegram->id; ?>','Are You Sure?', 'setwebhook');">
                                                    <i class="fa fa-play"></i>
                                                </button>
                                            <?php endif; ?>

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">


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
<?php echo $this->endSection() ?>
<?php echo $this->extend('admin/includes/_layout_view') ?>

<?php echo $this->section('content') ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
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
                <?php echo $this->include('admin/includes/_messages') ?>
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <?php echo $this->include('admin/users/_filter') ?>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th width="20"><?php echo trans('id'); ?></th>
                                                    <th><?php echo trans('avatar'); ?></th>
                                                    <th><?php echo trans('fullname'); ?></th>
                                                    <th><?php echo trans('username'); ?></th>
                                                    <th><?php echo trans('email'); ?></th>
                                                    <th><?php echo trans('role'); ?></th>
                                                    <th><?php echo trans('status'); ?></th>
                                                    <th><?php echo trans('date'); ?></th>
                                                    <th class="max-width-120"><?php echo trans('options'); ?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($paginate['users'] as $user) : ?>
                                                    <tr>
                                                        <td><?php echo clean_number($user['id']); ?></td>
                                                        <td style="width: 75px;">
                                                            <a href="#" target="_blank">
                                                                <img src="<?php echo get_user_avatar($user['avatar']); ?>" alt="user" class="img-responsive" style="height: 50px;">
                                                            </a>
                                                        </td>
                                                        <td><?php echo $user['first_name'] . ' ' .  $user['last_name']; ?> </td>
                                                        <td><?php echo $user['username']; ?></td>
                                                        <td>
                                                            <?php echo $user['email'];
                                                            if ($user['email_status'] == 1) : ?>
                                                                <small class="text-success">(<?php echo trans("confirmed"); ?>)</small>
                                                            <?php else : ?>
                                                                <small class="text-danger">(<?php echo trans("unconfirmed"); ?>)</small>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo $user['role']; ?></td>
                                                        <td>
                                                            <?php if ($user['status'] == 1) : ?>
                                                                <span class="badge badge-success-lighten"><?php echo trans('active'); ?></span>
                                                            <?php else : ?>
                                                                <span class="badge badge-danger-lighten"><?php echo trans('banned'); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo formatted_date($user['created_at']); ?></td>
                                                        <td>


                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-animated">
                                                                    <?php if (user()->role == 'admin') : ?>
                                                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#change-role" onclick="$('#modal_user_id').val('<?php echo html_escape($user['id']); ?>');"><?php echo trans('change_user_role'); ?></a>

                                                                    <?php endif; ?>
                                                                    <?php if ($user['email_status'] != 1) : ?>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="confirm_user_email(<?php echo $user['id']; ?>);"><?php echo trans('confirm_user_email'); ?></a>
                                                                    <?php endif; ?>
                                                                    <?php if (user()->role == 'admin') : ?>
                                                                        <?php if ($user['status'] == "1") : ?>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="ban_user('<?php echo $user['id']; ?>','<?php echo trans('confirm_ban'); ?>', 'ban');"><?php echo trans('ban_user'); ?></a>
                                                                        <?php else : ?>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="ban_user('<?php echo $user['id']; ?>', '<?php echo trans('confirm_remove_ban'); ?>', 'remove_ban');"><?php echo trans('remove_ban'); ?></a>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>

                                                                    <?php if (user()->role == 'admin') : ?>
                                                                        <a class="dropdown-item" href="<?php echo admin_url() . 'edit-user/'; ?><?php echo html_escape($user['id']); ?>"><?php echo trans('edit'); ?></a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/administrator/delete_user_post','<?php echo $user['id']; ?>','<?php echo trans('confirm_user'); ?>')"><?php echo trans('delete'); ?></a>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <?php if (empty($paginate['users'])) : ?>
                                            <p class="text-center text-muted"><?= trans("no_records_found"); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 float-right">
                                    <?php echo $pager->Links('default', 'custom_pager') ?>
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div> <!-- end col -->

            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>



<!-- Modal -->
<div id="change-role" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="change-role-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="change-role-modalLabel"><?php echo trans('change_user_role'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open('administrator/change_user_role_post'); ?>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <input type="hidden" name="user_id" id="modal_user_id" value="">
                    <label><?php echo trans("role"); ?></label>
                    <select id="role" name="role" class="form-control select2" required>
                        <option value=""><?php echo trans("select"); ?></option>
                        <?php foreach (model('Roles_permissionsModel')->get_roles_permissions() as $role) : ?>
                            <option value="<?php echo $role['role']; ?>"><?php echo $role['role_name']; ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><?php echo trans('save'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<?php echo $this->endSection() ?>
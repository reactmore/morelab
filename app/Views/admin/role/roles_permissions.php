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
            <div class="row">
                <div class="col-lg-4 col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-uppercase"><?php echo trans("add_role"); ?></h5>
                        </div>
                        <div class="card-body">
                            <?php echo form_open_multipart('admin/role-management/add-role-post', ['class' => 'custom-validation needs-validation']); ?>
                            <?php if (!empty(session()->getFlashdata('mes_add_role'))) :
                                echo view('Common/_messages');
                            endif; ?>
                            <div class="form-group mb-3">
                                <label><?php echo trans("role_name"); ?></label>
                                <input type="text" class="form-control" name="role_name" placeholder="<?php echo trans("role_name"); ?>" value="<?php echo old('role_name'); ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary float-right"><?php echo trans('add'); ?></button>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-uppercase"><?php echo trans("role"); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="cs_datatable" class="table table-bordered table-striped" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th width="20" class="text-center"><?php echo trans('id'); ?></th>
                                            <th class="text-center"><?php echo trans('role'); ?></th>
                                            <th class="text-center"><?php echo trans('permissions'); ?></th>
                                            <th class="text-center"><?php echo trans('options'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($roles as $role) : ?>

                                            <tr class="text-center">
                                                <td><strong style="font-weight: 600;"><?php echo $role->id; ?></strong></td>
                                                <td><strong style="font-weight: 600;"><?php echo $role->role_name; ?></strong></td>
                                                <td><a href="<?php echo admin_url() ?>role-management/permission?role=<?php echo $role->role_name; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary"><?php echo trans('permissions') ?></a></td>

                                                <td class="text-center">
                                                    <?php if ($role->id != 1) : ?>
                                                        <div class="dropdown btn-group">
                                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                            </button>

                                                            <div class="dropdown-menu dropdown-menu-animated">
                                                                <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal-role" onclick="$('form').attr('action', '/admin/role-management/edit-role-post'); $('#modal-modalLabel').text('<?php echo trans('edit'); ?>'); $('#modal_id').val('<?php echo html_escape($role->id); ?>'); $('#modal_name').val('<?php echo html_escape($role->role_name); ?>');"><?php echo trans('edit'); ?></a>
                                                                <div class=" dropdown-divider">
                                                                </div>
                                                                <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/role-management/delete-role-post','<?php echo $role->id; ?>','<?php echo trans('confirm_delete'); ?>');"><?php echo trans('delete'); ?></a>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal -->
<div id="modal-role" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-modalLabel"><?php echo trans('add'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_safe" action="" method="post">
                <?php echo csrf_field() ?>
                <input type="hidden" id="modal_id" name="id" class="form-control form-input">

                <div class="modal-body">
                    <div class="form-group">
                        <label><?php echo trans("name"); ?></label>
                        <input type="text" id="modal_name" name="role_name" class="form-control form-input" placeholder="<?php echo trans("name"); ?>" required>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><?php echo trans('save'); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php echo $this->endSection() ?>
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
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="<?php echo admin_url() ?>roles-permissions/add-role" class="btn btn-primary float-right"><?php echo trans("add_role"); ?> </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped" role="grid">
                                <thead>
                                    <tr role="row">
                                        <th width="20"><?php echo trans('role'); ?></th>
                                        <?php foreach ($permissions as $panel) : ?>
                                            <th class="text-center"><?php echo trans($panel); ?></th>
                                        <?php endforeach; ?>
                                        <th width="10" class="text-center"><?php echo trans('options'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($roles as $role) : ?>
                                        <tr>
                                            <td><strong style="font-weight: 600;"><?php echo $role->role_name; ?></strong></td>
                                            <?php foreach ($permissions as $panel) : ?>
                                                <td width="20" class="text-center">
                                                    <?php if ($role->$panel == 1) : ?>
                                                        <span class="label btn btn-sm btn-primary  waves-effect waves-light text-center"><i class="fas fa-check"></i></span>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endforeach; ?>
                                            <td width="10" class="text-center">
                                                <?php if ($role->role != "admin") : ?>
                                                    <a href="<?php echo admin_url(); ?>roles-permissions/edit-role/<?php echo $role->id; ?>" class="btn btn btn-sm btn-primary  waves-effect waves-light"><i class="fa fa-edit"></i>&nbsp;&nbsp;<?php echo trans("edit"); ?></a>

                                                    <a href="javascript:void(0)" onclick="delete_item('/admin/rolemanagement/delete_role_post','<?php echo $role->id; ?>','<?php echo trans('confirm_delete'); ?>')" class="btn btn btn-sm btn-danger  waves-effect waves-light"><i class="fa fa-trash"></i>&nbsp;&nbsp;<?php echo trans("delete"); ?></a>
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
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php echo $this->endSection() ?>
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
                                                        <td>
                                                            <?php if ($user['status'] == 1) : ?>
                                                                <span class="badge badge-success-lighten"><?php echo trans('active'); ?></span>
                                                            <?php else : ?>
                                                                <span class="badge badge-danger-lighten"><?php echo trans('banned'); ?></span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo formatted_date($user['created_at']); ?></td>
                                                        <td>




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

<?php echo $this->endSection() ?>
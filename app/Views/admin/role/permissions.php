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
                            <li class="breadcrumb-item active"><a href="<?php echo admin_url() ?>">/</a></li>
                        <?php else :  ?>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>"><?php echo trans('dashboard') ?></a></li>
                            <li class="breadcrumb-item"><a href="<?php echo admin_url() ?>role-management"><?php echo trans('roles_permissions') ?></a></li>
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
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-uppercase"><?php echo trans("permissions"); ?> - <?php echo $role->role_name ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover my-0">
                                    <thead>
                                        <tr>
                                            <th>Menu</th>
                                            <th>Url</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($MenuCategories as $menuCategory) : ?>
                                            <tr>
                                                <td colspan="2"><strong><?= $menuCategory['menu_category']; ?></strong></td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input menu_category_permission" type="checkbox" <?= check_menuCategory_access($role->id, $menuCategory['id']) ?> data-role="<?= $role->id ?>" data-menucategory="<?= $menuCategory['id'] ?>">
                                                        <label class="form-check-label">
                                                            <?= (check_menuCategory_access($role->id, $menuCategory['id']) == 'checked') ? 'Access Granted' : 'Access Not Granted' ?>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php foreach ($Menus as $menu) : if ($menu['menu_category'] == $menuCategory['id']) : ?>
                                                    <tr>
                                                        <td><?= $menu['title']; ?></td>
                                                        <td class="d-none d-md-table-cell">/<?= $menu['url']; ?></td>
                                                        <td>
                                                            <div class="form-check">
                                                                <input class="form-check-input menu_permission" type="checkbox" <?= check_menu_access($role->id, $menu['id']) ?> data-role="<?= $role->id ?>" data-menu="<?= $menu['id'] ?>">
                                                                <label class="form-check-label">
                                                                    <?= (check_menu_access($role->id, $menu['id']) == 'checked') ? 'Access Granted' : 'Access Not Granted' ?>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php foreach ($Submenus as $subMenu) :  if ($menu['id'] == $subMenu['menu']) : ?>
                                                            <tr>
                                                                <td>
                                                                    <p class="ml-4"> <?= $subMenu['title']; ?></p>
                                                                </td>
                                                                <td class="d-none d-md-table-cell">
                                                                    <p class="ml-4">/<?= $subMenu['url']; ?></p>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check ms-4">
                                                                        <input class="form-check-input submenu_permission" type="checkbox" <?= check_submenu_access($role->id, $subMenu['id']) ?> data-role="<?= $role->id ?>" data-submenu="<?= $subMenu['id'] ?>">
                                                                        <label class="form-check-label">
                                                                            <?= (check_submenu_access($role->id, $subMenu['id']) == 'checked') ? 'Access Granted' : 'Access Not Granted' ?>
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                    <?php endif;
                                                    endforeach; ?>
                                            <?php endif;
                                            endforeach; ?>
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

<script>

</script>
<?php echo $this->endSection() ?>
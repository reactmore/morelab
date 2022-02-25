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
                            <?php echo view('admin/menu/_add_form_tabs'); ?>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="menu-category" role="tabpanel" aria-labelledby="menu-category-tab">
                                    <?php echo form_open_multipart('admin/menu-management/add-menu-category-post', ['class' => 'custom-validation needs-validation']); ?>
                                    <?php if (!empty(session()->getFlashdata('mes_add_category'))) :
                                        echo view('Common/_messages');
                                    endif; ?>
                                    <div class="form-group mb-3">
                                        <label><?php echo trans('menu_category') ?><span class="required"> *</span></label>
                                        <input type="text" class="form-control" name="menu_category" placeholder="<?php echo trans('menu_category') ?>" value="<?php echo old('menu_category'); ?>" required>

                                    </div>
                                    <div class="form-group mb-3">
                                        <label><?php echo trans('menu_order') ?></label>
                                        <input type="number" class="form-control" name="menu_category_order" placeholder="1" value="<?php echo old('menu_category_order'); ?>">
                                    </div>

                                    <button type="submit" class="btn btn-primary float-right"><?php echo trans('add'); ?></button>
                                    <?php echo form_close(); ?>
                                </div>
                                <div class="tab-pane fade" id="menu" role="tabpanel" aria-labelledby="menu-tab">
                                    <?php echo form_open_multipart('admin/menu-management/add-menu-post', ['class' => 'custom-validation needs-validation']); ?>
                                    <?php if (!empty(session()->getFlashdata('mes_add_menu'))) :
                                        echo view('Common/_messages');
                                    endif; ?>
                                    <div class="form-group mb-3">
                                        <label><?php echo trans('menu_category') ?><span class="required"> *</span></label>
                                        <select id="menu-category" name="menu_category" class="form-control select2" required>
                                            <option value=""><?php echo trans("select"); ?></option>
                                            <?php foreach ($MenuCategories as $menuCat) : ?>
                                                <option value="<?php echo $menuCat['id']; ?>"><?php echo $menuCat['menu_category']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label><?php echo trans('menu_title') ?><span class="required"> *</span></label>
                                        <input type="text" class="form-control" name="menu_title" placeholder="menu title" value="<?php echo old('menu_title'); ?>" required>
                                        <small>(<?php echo trans('need_translations_desc') ?>)</small>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label><?php echo trans('menu_url') ?><span class="required"> *</span></label>
                                        <input type="text" class="form-control" name="menu_url" placeholder="menu url" value="<?php echo old('menu_url'); ?>" required>
                                        <small>(<?php echo trans('need_routes_desc') ?>)</small>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label><?php echo trans('icon') ?><span class="required"> *</span> </label>
                                        <input type="text" class="form-control" name="menu_icon" placeholder="menu icon" value="<?php echo old('menu_icon'); ?>" required>
                                        <small>Font Awesome 6</small>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label><?php echo trans('menu_order') ?></label>
                                        <input type="number" class="form-control" name="menu_order" placeholder="1" value="<?php echo old('menu_order'); ?>">
                                    </div>

                                    <button type="submit" class="btn btn-primary float-right"><?php echo trans('add'); ?></button>
                                    <?php echo form_close(); ?>
                                </div>
                                <div class="tab-pane fade" id="submenu" role="tabpanel" aria-labelledby="submenu-tab">
                                    <?php echo form_open_multipart('admin/menu-management/add-submenu-post', ['class' => 'custom-validation needs-validation']); ?>
                                    <?php if (!empty(session()->getFlashdata('mes_add_submenu'))) :
                                        echo view('Common/_messages');
                                    endif; ?>
                                    <div class="form-group mb-3">
                                        <label><?php echo trans('menu_parent') ?><span class="required"> *</span></label>
                                        <select id="menu-parent" name="menu_parent" class="form-control select2" required>
                                            <option value=""><?php echo trans("select"); ?></option>
                                            <?php foreach ($Menus as $m) : ?>
                                                <option value="<?php echo $m['id']; ?>"><?php echo trans($m['title']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label><?php echo trans('submenu_title') ?><span class="required"> *</span></label>
                                        <input type="text" class="form-control" name="submenu_title" placeholder="Submenu Title" value="<?php echo old('submenu_title'); ?>" required>
                                        <small>(<?php echo trans('need_translations_desc') ?>)</small>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label><?php echo trans('submenu_url') ?><span class="required"> *</span></label>
                                        <input type="text" class="form-control" name="submenu_url" placeholder="Submenu URL" value="<?php echo old('submenu_url'); ?>" required>
                                        <small>(<?php echo trans('need_routes_desc') ?>)</small>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label><?php echo trans('menu_order') ?></label>
                                        <input type="number" class="form-control" name="submenu_order" placeholder="1" value="<?php echo old('submenu_order'); ?>">
                                    </div>

                                    <button type="submit" class="btn btn-primary float-right"><?php echo trans('add'); ?></button>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-uppercase"><?php echo trans("menu_management"); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" role="grid">
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
                                                    <div class="dropdown btn-group">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-animated">
                                                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal-category" onclick="$('form').attr('action', '/admin/menu-management/edit-menu-category-post'); $('#modal-modalLabel').text('<?php echo trans('edit'); ?>'); $('#modal_id').val('<?php echo html_escape($menuCategory['id']); ?>'); $('#modal_name').val('<?php echo html_escape($menuCategory['menu_category']); ?>'); $('#menu_category_order').val('<?php echo $menuCategory['position_order']; ?>');"><?php echo trans('edit'); ?></a>
                                                            <div class=" dropdown-divider">
                                                            </div>
                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/menu-management/delete-menu-category-post','<?php echo $menuCategory['id']; ?>','<?php echo trans('confirm_delete'); ?>');"><?php echo trans('delete'); ?></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php foreach ($Menus as $menu) : if ($menu['menu_category'] == $menuCategory['id']) : ?>
                                                    <tr>
                                                        <td><?= trans($menu['title']); ?></td>
                                                        <td class="d-none d-md-table-cell">/<?= $menu['url']; ?></td>
                                                        <td>
                                                            <div class="dropdown btn-group">
                                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                </button>

                                                                <div class="dropdown-menu dropdown-menu-animated">
                                                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal-menu" onclick="$('form').attr('action', '/admin/menu-management/edit-menu-post'); $('#modal-MenuLabel').text('<?php echo trans('edit'); ?>'); $('#menu_id').val('<?php echo html_escape($menu['id']); ?>'); $('#menu_parent').val('<?php echo html_escape($menu['parent']); ?>'); $('#menu_category').val('<?php echo html_escape($menu['menu_category']); ?>'); $('#menu_title').val('<?php echo html_escape($menu['title']); ?>'); $('#menu_url').val('<?php echo html_escape($menu['url']); ?>'); $('#menu_icon').val('<?php echo html_escape($menu['icon']); ?>'); $('#menu_order').val('<?php echo $menu['position_order']; ?>');"><?php echo trans('edit'); ?></a>
                                                                    <div class=" dropdown-divider">
                                                                    </div>
                                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/menu-management/delete-menu-post','<?php echo $menu['id']; ?>','<?php echo trans('confirm_delete'); ?>');"><?php echo trans('delete'); ?></a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php foreach ($Submenus as $subMenu) :  if ($menu['id'] == $subMenu['menu']) : ?>
                                                            <tr>
                                                                <td>
                                                                    <p class="ml-4"> <?= trans($subMenu['title']); ?></p>
                                                                </td>
                                                                <td class="d-none d-md-table-cell">
                                                                    <p class="ml-4">/<?= $subMenu['url']; ?></p>
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown btn-group">
                                                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                            <i class="mdi mdi-circle-edit-outline mr-2"></i><?php echo trans('select_an_option'); ?>
                                                                        </button>

                                                                        <div class="dropdown-menu dropdown-menu-animated">
                                                                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal-submenu" onclick="$('form').attr('action', '/admin/menu-management/edit-submenu-post'); $('#modal-SubMenuLabel').text('<?php echo trans('edit'); ?>'); $('#submenu_id').val('<?php echo html_escape($subMenu['id']); ?>');  $('#_cache_menu_parent').val('<?php echo html_escape($subMenu['menu']); ?>'); $('#menu_parent').val('<?php echo html_escape($subMenu['menu']); ?>'); $('#submenu_title').val('<?php echo html_escape($subMenu['title']); ?>'); $('#submenu_url').val('<?php echo html_escape($subMenu['url']); ?>'); $('#submenu_order').val('<?php echo $subMenu['position_order']; ?>');"><?php echo trans('edit'); ?></a>
                                                                            <div class=" dropdown-divider">
                                                                            </div>
                                                                            <a class="dropdown-item" href="javascript:void(0)" onclick="delete_item('/admin/menu-management/delete-submenu-post','<?php echo $subMenu['id']; ?>','<?php echo trans('confirm_delete'); ?>');"><?php echo trans('delete'); ?></a>
                                                                        </div>
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

<?php echo view('admin/menu/_modal'); ?>

<?php echo $this->endSection() ?>
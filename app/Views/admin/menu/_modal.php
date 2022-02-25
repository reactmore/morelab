<!-- Modal -->
<div id="modal-category" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-modalLabel" aria-hidden="true">
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
                        <label><?php echo trans('menu_category') ?><span class="required"> *</span></label>
                        <input type="text" id="modal_name" name="menu_category" class="form-control form-input" placeholder="<?php echo trans("name"); ?>" required>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label><?php echo trans('menu_order') ?></label>
                    <input type="number" class="form-control" id="menu_category_order" name="menu_category_order" placeholder="1" value="<?php echo old('menu_order'); ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><?php echo trans('save'); ?></button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal -->
<div id="modal-menu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-MenuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-MenuLabel"><?php echo trans('add'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_safe" action="" method="post">
                <?php echo csrf_field() ?>
                <input type="hidden" id="menu_id" name="id" class="form-control form-input">
                <input type="hidden" id="menu_parent" name="menu_parent" class="form-control form-input">

                <div class="modal-body">


                    <div class="form-group mb-3">
                        <label><?php echo trans('menu_category') ?><span class="required"> *</span></label>
                        <select id="menu_category" name="menu_category" class="form-control select2" required>
                            <option value=""><?php echo trans("select"); ?></option>
                            <?php foreach ($MenuCategories as $menuCat) : ?>
                                <option value="<?php echo $menuCat['id']; ?>"><?php echo $menuCat['menu_category']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label><?php echo trans('menu_title') ?><span class="required"> *</span></label>
                        <input type="text" class="form-control" id="menu_title" name="menu_title" placeholder="<?php echo trans('menu_title') ?>" value="<?php echo old('menu_title'); ?>" required>
                        <small>(<?php echo trans('need_translations_desc') ?>)</small>
                    </div>

                    <div class="form-group mb-3">
                        <label><?php echo trans('menu_url') ?><span class="required"> *</span></label>
                        <input type="text" class="form-control" id="menu_url" name="menu_url" placeholder="<?php echo trans('menu_url') ?>" value="<?php echo old('menu_url'); ?>" required>
                        <small>(<?php echo trans('need_routes_desc') ?>)</small>
                    </div>

                    <div class="form-group mb-3">
                        <label><?php echo trans('icon') ?><span class="required"> *</span> </label>
                        <input type="text" class="form-control" id="menu_icon" name="menu_icon" placeholder="<?php echo trans('icon') ?>" value="<?php echo old('menu_icon'); ?>" required>
                        <small>Font Awesome 6</small>
                    </div>

                    <div class="form-group mb-3">
                        <label><?php echo trans('menu_order') ?></label>
                        <input type="number" class="form-control" id="menu_order" name="menu_order" placeholder="1" value="<?php echo old('menu_order'); ?>">
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

<!-- Modal -->
<div id="modal-submenu" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-SubMenuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal-SubMenuLabel"><?php echo trans('edit'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_safe" action="" method="post">
                <?php echo csrf_field() ?>
                <input type="hidden" id="submenu_id" name="id" class="form-control form-input">
                <input type="hidden" id="_cache_menu_parent" name="_cache_menu_parent" class="form-control form-input">

                <div class="modal-body">


                    <div class="form-group mb-3">
                        <label><?php echo trans('menu_parent') ?><span class="required"> *</span></label>
                        <select id="menu_parent" name="menu_parent" class="form-control select2" required>
                            <option value=""><?php echo trans("select"); ?></option>
                            <?php foreach ($Menus as $m) : ?>
                                <option value="<?php echo $m['id']; ?>"><?php echo $m['title']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label><?php echo trans('submenu_title') ?><span class="required"> *</span></label>
                        <input type="text" class="form-control" id="submenu_title" name="submenu_title" placeholder="<?php echo trans('submenu_title') ?>" value="<?php echo old('submenu_title'); ?>" required>
                        <small>(<?php echo trans('need_translations_desc') ?>)</small>
                    </div>

                    <div class="form-group mb-3">
                        <label><?php echo trans('submenu_url') ?><span class="required"> *</span></label>
                        <input type="text" class="form-control" id="submenu_url" name="submenu_url" placeholder="<?php echo trans('submenu_url') ?>" value="<?php echo old('submenu_url'); ?>" required>
                        <small>(<?php echo trans('need_routes_desc') ?>)</small>
                    </div>

                    <div class="form-group mb-3">
                        <label><?php echo trans('menu_order') ?></label>
                        <input type="number" class="form-control" id="submenu_order" name="submenu_order" placeholder="1" value="<?php echo old('submenu_order'); ?>">
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
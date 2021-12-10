<div class="row table-filter-container">
    <div class="col-sm-12">
        <?php $uri = service('uri'); ?>
        <?php $RolesPermissionsModel = model('Roles_permissionsModel'); ?>
        <?php $request = \Config\Services::request();; ?>
        <?php echo form_open(admin_url() . $uri->getSegment(2), ['method' => 'GET']); ?>

        <div class="item-table-filter" style="width: 80px; min-width: 80px;">
            <label><?php echo trans("show"); ?></label>
            <select name="show" class="form-control">
                <option value="15" <?php echo ($request->getVar('show') == '15') ? 'selected' : ''; ?>>15</option>
                <option value="30" <?php echo ($request->getVar('show') == '30') ? 'selected' : ''; ?>>30</option>
                <option value="60" <?php echo ($request->getVar('show') == '60') ? 'selected' : ''; ?>>60</option>
                <option value="100" <?php echo ($request->getVar('show') == '100') ? 'selected' : ''; ?>>100</option>
            </select>
        </div>

        <div class="item-table-filter">
            <label><?php echo trans("status"); ?></label>
            <select name="status" class="form-control">
                <option value=""><?php echo trans("all"); ?></option>
                <option value="1" <?php echo ($request->getVar('status') == 1) ? 'selected' : ''; ?>><?php echo trans("active"); ?></option>
                <option value="0" <?php echo $request->getVar('status') != null && $request->getVar('status') != 1 ? 'selected' : ''; ?>><?php echo trans("banned"); ?></option>
            </select>
        </div>
        <div class="item-table-filter">
            <label><?php echo trans("email_status"); ?></label>
            <select name="email_status" class="form-control">
                <option value=""><?php echo trans("all"); ?></option>
                <option value="1" <?php echo ($request->getVar('email_status') == 1) ? 'selected' : ''; ?>><?php echo trans("confirmed"); ?></option>
                <option value="0" <?php echo $request->getVar('email_status') != null && $request->getVar('email_status') != 1 ? 'selected' : ''; ?>><?php echo trans("unconfirmed"); ?></option>
            </select>
        </div>

        <?php if ($uri->getSegment(2) != 'administrators') : ?>
            <div class="item-table-filter">
                <label><?php echo trans("role"); ?></label>
                <select name="role" class="form-control">
                    <option value=""><?php echo trans("all"); ?></option>
                    <?php foreach (model('Roles_permissionsModel')->get_roles() as $role) : ?>
                        <option value="<?php echo $role->role ?>" <?php echo ($request->getVar('role') == $role->role) ? 'selected' : ''; ?>><?php echo $role->role_name; ?></option>
                    <?php endforeach; ?>

                </select>
            </div>
        <?php endif; ?>

        <div class="item-table-filter item-table-filter-long">
            <label><?php echo trans("search"); ?></label>
            <input name="search" class="form-control" placeholder="<?php echo trans("search") ?>" type="search" value="<?php echo $request->getVar('search'); ?>">
        </div>


        <div class="item-table-filter md-top-10" style="width: 65px; min-width: 65px;">
            <label style="display: block">&nbsp;</label>
            <button type="submit" class="btn btn-primary"><?php echo trans("filter"); ?></button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
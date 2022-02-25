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
            <?php echo form_open('admin/usermanagement/change_user_role_post'); ?>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <input type="hidden" name="user_id" id="modal_user_id" value="">
                    <label><?php echo trans("role"); ?></label>
                    <select id="role" name="role" class="form-control select2" required>
                        <option value=""><?php echo trans("select"); ?></option>
                        <?php foreach (model('RolesPermissionsModel')->getRole() as $role) : ?>
                            <option value="<?php echo $role->id; ?>"><?php echo $role->role_name; ?></option>
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
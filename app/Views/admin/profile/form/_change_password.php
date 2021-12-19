<?php echo form_open_multipart('admin/profile/change_password_post', ['id' => 'form_safe', 'class' => 'custom-validation needs-validation']); ?>
<input type="hidden" name="id" value="<?php echo html_escape($user->id); ?>">
<input id="newimage_id" type="hidden" class="form-control mb-3" name="newimage_id" value="">
<input type="hidden" id="crsf">
<div class="card">
    <div class="card-header">
        <h5><?php echo trans('change_password') ?></h5>
    </div>
    <div class="card-body">

        <?php if (!empty($user->password)) : ?>
            <div class="form-group mb-3">
                <label><?php echo trans("form_old_password"); ?></label>
                <input type="password" name="old_password" class="form-control form-input" value="<?php echo old("old_password"); ?>" placeholder="<?php echo trans("form_old_password"); ?>" required>
            </div>
            <input type="hidden" name="old_password_exists" value="1">
        <?php else : ?>
            <input type="hidden" name="old_password_exists" value="0">
        <?php endif; ?>
        <div class="form-group mb-3">
            <label><?php echo trans("form_password"); ?></label>
            <input type="password" name="password" class="form-control form-input" value="<?php echo old("password"); ?>" placeholder="<?php echo trans("form_password"); ?>" required>

        </div>
        <div class="form-group mb-3">
            <label><?php echo trans("form_confirm_password"); ?></label>
            <input type="password" name="password_confirm" class="form-control form-input" value="<?php echo old("password_confirm"); ?>" placeholder="<?php echo trans("form_confirm_password"); ?>" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary float-right"><?php echo trans('change_password'); ?></button>

    </div>
</div>
<?php echo form_close(); ?>
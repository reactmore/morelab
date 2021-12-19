<?php echo form_open_multipart('admin/profile/delete_account_post', ['id' => 'form_safe', 'class' => 'custom-validation needs-validation']); ?>
<?php echo $this->include('admin/includes/_messages') ?>
<input type="hidden" name="id" value="<?php echo html_escape($user->id); ?>">
<input id="newimage_id" type="hidden" class="form-control mb-3" name="newimage_id" value="">
<input type="hidden" id="crsf">
<div class="card">
    <div class="card-header">
        <h5><?php echo trans('delete_account') ?></h5>
    </div>
    <div class="card-body">

        <div class="form-group mb-3">
            <label><?php echo trans("form_password"); ?></label>
            <input type="password" name="password" class="form-control form-input" value="<?php echo old("password"); ?>" placeholder="<?php echo trans("form_password"); ?>" required>
        </div>

        <div class="form-group mb-3">
            <label class="custom-checkbox">
                <input type="checkbox" name="confirm" class="checkbox_terms_conditions" required>
                <span class="checkbox-icon"><i class="icon-check"></i></span>
                <?php echo trans("delete_account_confirm"); ?></a>
            </label>
        </div>

        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary float-right"><?php echo trans("delete_account") ?></button>
        </div>



    </div>
</div>
<?php echo form_close(); ?>
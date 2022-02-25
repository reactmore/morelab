<?php echo form_open_multipart('admin/profile/profile_post', ['id' => 'form_safe', 'class' => 'custom-validation needs-validation']); ?>
<input type="hidden" name="id" value="<?php echo html_escape($user->id); ?>">
<input id="newimage_id" type="hidden" class="form-control mb-3" name="newimage_id" value="">
<input type="hidden" id="crsf">
<div class="card">
    <div class="card-header">
        <h5><?php echo trans('basic_informations') ?></h5>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-6">
                <div class="form-group mb-3">
                    <label><?php echo trans("fullname"); ?><span class="required"> *</span></label>
                    <input type="text" name="fullname" class="form-control auth-form-input" placeholder="<?php echo trans("firstname"); ?>" value="<?php echo html_escape($user->fullname); ?>" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group mb-3">
                    <label><?php echo trans('username'); ?><span class="required"> *</span></label>
                    <input type="text" class="form-control form-input" name="username" placeholder="<?php echo trans('username'); ?>" value="<?php echo html_escape($user->username); ?>" required>
                </div>
            </div>
        </div>



        <div class="form-group mb-3">
            <label><?php echo trans('slug'); ?></label>
            <input type="text" class="form-control form-input" name="slug" placeholder="<?php echo trans('slug'); ?>" value="<?php echo html_escape($user->slug); ?>">
        </div>

        <div class="form-group mb-3">
            <label><?php echo trans('email'); ?><span class="required"> *</span></label>
            <?php if (get_general_settings()->email_verification == 1) : ?>
                <?php if ($user->email_status == 1) : ?>
                    &nbsp;
                    <small class="text-success">(<?php echo trans("confirmed"); ?>)</small>
                <?php else : ?>
                    &nbsp;
                    <small class="text-danger">(<?php echo trans("unconfirmed"); ?>)</small>
                    <button type="submit" name="submit" value="resend_activation_email" class="btn btn-primary float-right mb-2"><?php echo trans("resend_activation_email"); ?></button>
                <?php endif; ?>
            <?php endif; ?>
            <input type="email" class="form-control form-input" name="email" placeholder="<?php echo trans('email'); ?>" value="<?php echo html_escape($user->email); ?>" parsley-type="email" required>
        </div>

        <div class="form-group mb-3">
            <label><?php echo trans('mobile_no'); ?></label>
            <input type="number" class="form-control form-input" name="mobile_no" placeholder="<?php echo trans('mobile_no'); ?>" value="<?php echo html_escape($user->mobile_no); ?>">
        </div>



        <div class="form-group mb-3">
            <label class="control-label"><?php echo trans('about_me'); ?></label>
            <textarea class="form-control text-area" name="about_me" placeholder="<?php echo trans('about_me'); ?>"><?php echo html_escape($user->about_me); ?></textarea>
        </div>



        <button type="submit" name="submit" value="basic" class="btn btn-primary float-right"><?php echo trans('save_changes'); ?></button>

    </div>
</div>
<?php echo form_close(); ?>
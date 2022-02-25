<div id="add-translations" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="standard-modalLabel"><?php echo trans('add_translations'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php echo form_open_multipart('admin/language-settings/add-translation-post'); ?>

            <div class="modal-body">
                <input type="hidden" name="lang_id" id="lang_id" value="<?php echo selected_lang()->id ?>">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label><?php echo trans("label"); ?></label>
                            <input type="text" name="label" class="form-control form-input" placeholder="<?php echo trans("label"); ?>" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label><?php echo trans("translation"); ?></label>
                            <input type="text" name="translation" class="form-control form-input" placeholder="<?php echo trans("translation"); ?>" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><?php echo trans('save'); ?></button>
            </div>
            <?php echo form_close(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
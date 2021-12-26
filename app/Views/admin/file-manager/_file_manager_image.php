<!-- Full width modal -->
<div id="file_manager_image" class="modal fade modal-file-manager" tabindex="-1" role="dialog" aria-labelledby="file_manager_image_label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header " style="padding-bottom: 0px;">
                <!-- <h4 class="modal-title" id="file_manager_image_label"><?php echo trans('images'); ?></h4> -->
                <div class="p-0">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="true"><?php echo trans('images'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="browse_files-tab" data-toggle="tab" href="#browse_files" role="tab" aria-controls="browse_files" aria-selected="false"><?php echo trans('browse_files'); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="p-0"></div>
                <div class="ml-auto p-2">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="file-manager">
                    <div class="tab-content" id="filemanager-content">
                        <div class="tab-pane fade show active" id="images" role="tabpanel" aria-labelledby="images-tab">
                            <div class="file-manager-left">
                                <div class="d-flex">
                                    <div class="p-2">
                                        <select name="" id="filter_time" class="form-control">
                                            <option value="">Date</option>
                                        </select>
                                    </div>
                                    <div class="p-2"></div>
                                    <div class="ml-auto p-2"> <input type="text" id="input_search_image" class="form-control" placeholder="<?php echo trans("search"); ?>"></div>
                                </div>
                                <div class="file-manager-content">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div id="image_file_upload_response"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="file-manager-right">
                                <div class="row " id="form_image_sidebar" style="display: none;">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label ">Alt Text</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="alt_name" class="form-control " id="images-alt" data-toggle="images_form" data-input="#images-alt" placeholder="Alt Image">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label ">Title</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="file_name" class="form-control " id="images-title" data-toggle="images_form" data-input="#images-title" placeholder="Title Image">

                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label ">Captions</label>
                                            <div class="col-sm-8">
                                                <textarea name="file_caption" id="images-captions" class="form-control" data-toggle="images_form" data-input="#images-captions" cols="30" rows="3" placeholder="Captions"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-4 col-form-label ">Descriptions</label>
                                            <div class="col-sm-8">
                                                <textarea name="file_desc" id="images-desc" class="form-control" data-toggle="images_form" data-input="#images-desc" cols="30" rows="3" placeholder="Descriptions"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="images-url" class="col-sm-4 col-form-label ">Url</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="images-url" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="tab-pane fade" id="browse_files" role="tabpanel" aria-labelledby="browse_files-tab">
                            <div class="col-12 p-5">
                                <div class="dm-uploader-container">
                                    <div id="drag-and-drop-zone-image" class="dm-uploader text-center">
                                        <p class="file-manager-file-types">
                                            <span>JPG</span>
                                            <span>JPEG</span>
                                            <span>PNG</span>
                                            <span>GIF</span>
                                            <span>SVG</span>
                                        </p>
                                        <p class="dm-upload-icon">
                                            <i class="fa fa-images"></i>
                                        </p>
                                        <p class="dm-upload-text"><?php echo trans("drag_drop_files_here"); ?></p>
                                        <p class="text-center">
                                            <button class="btn btn-default btn-browse-files"><?php echo trans('browse_files'); ?></button>
                                        </p>
                                        <a class='btn btn-md dm-btn-select-files'>
                                            <input type="file" name="file" size="40" multiple="multiple">
                                        </a>
                                        <ul class="dm-uploaded-files" id="files-image"></ul>
                                        <button type="button" id="btn_reset_upload_image" class="btn btn-reset-upload"><?php echo trans("reset"); ?></button>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>



                    <input type="hidden" id="selected_img_file_id">
                    <input type="hidden" id="selected_img_mid_file_path">
                    <input type="hidden" id="selected_img_default_file_path">
                    <input type="hidden" id="selected_img_slider_file_path">
                    <input type="hidden" id="selected_img_big_file_path">
                    <input type="hidden" id="selected_img_storage">
                    <input type="hidden" id="selected_img_base_url">
                </div>
            </div>
            <div class="modal-footer">
                <div class="file-manager-footer">
                    <button type="button" id="btn_img_delete" class="btn btn-danger float-start btn-file-delete"><i class="fa fa-trash"></i>&nbsp;&nbsp;<?php echo trans('delete'); ?></button>
                    <button type="button" id="btn_img_select" class="btn bg-olive btn-file-select"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo 'Select Image'; ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo trans('close'); ?></button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- File item template -->
<script type="text/html" id="files-template-image">
    <li class="media">
        <img class="preview-img" src="<?php echo base_url(); ?>/public/assets/admin/plugins/file-manager/file.png" alt="">
        <div class="media-body">
            <div class="progress">
                <div class="dm-progress-waiting"><?php echo 'waiting'; ?></div>
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </li>
</script>

<script>
    var txt_processing = "<?php echo "processing"; ?>";
    $(function() {
        $('#drag-and-drop-zone-image').dmUploader({
            url: '<?php echo base_url(); ?>/admin/file/upload_image_file',
            queue: true,
            allowedTypes: 'image/*',
            extFilter: ["jpg", "jpeg", "png", "gif", "svg"],
            extraData: function(id) {
                return {
                    "file_id": id,
                    "<?php echo csrf_token() ?>": $.cookie(csrfCookie)
                };
            },
            onDragEnter: function() {
                this.addClass('active');
            },
            onDragLeave: function() {
                this.removeClass('active');
            },
            onInit: function() {},
            onComplete: function(id) {},
            onNewFile: function(id, file) {
                ui_multi_add_file(id, file, "image");
                if (typeof FileReader !== "undefined") {
                    var reader = new FileReader();
                    var img = $('#uploaderFile' + id).find('img');

                    reader.onload = function(e) {
                        img.attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            },
            onBeforeUpload: function(id) {
                $('#uploaderFile' + id + ' .dm-progress-waiting').hide();
                ui_multi_update_file_progress(id, 0, '', true);
                ui_multi_update_file_status(id, 'uploading', 'Uploading...');
                $("#btn_reset_upload_image").show();
            },
            onUploadProgress: function(id, percent) {
                ui_multi_update_file_progress(id, percent);
            },
            onUploadSuccess: function(id, data) {
                document.getElementById("uploaderFile" + id).remove();
                refresh_images();
                ui_multi_update_file_status(id, 'success', 'Upload Complete');
                ui_multi_update_file_progress(id, 100, 'success', false);
                $("#btn_reset_upload_image").hide();
            },
            onUploadError: function(id, xhr, status, message) {
                if (message == "Not Acceptable") {
                    $("#uploaderFile" + id).remove();
                    $(".error-message-img-upload").show();
                    $(".error-message-img-upload p").html("");
                    setTimeout(function() {
                        $(".error-message-img-upload").fadeOut("slow");
                    }, 4000)
                }
            },
            onFallbackMode: function() {},
            onFileSizeError: function(file) {},
            onFileTypeError: function(file) {
                swal.fire({
                    text: "<?php echo  trans("invalid_file_type"); ?>",
                    icon: "warning",
                    button: sweetalert_ok
                });
            },
            onFileExtError: function(file) {
                swal.fire({
                    text: "<?php echo  trans("invalid_file_type"); ?>",
                    icon: "warning",
                    button: sweetalert_ok
                });
            }
        });
    });

    $(document).on('click', '#btn_reset_upload_image', function() {
        $("#drag-and-drop-zone-image").dmUploader("reset");
        $("#files-image").empty();
        $(this).hide();
    });
</script>
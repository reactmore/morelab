/*
*------------------------------------------------------------------------------------------
* IMAGES
*------------------------------------------------------------------------------------------
*/
var image_type = 'main';
var data_item_id = '';
var data_input_id = '';

//update images
$('#file_manager_image').on('shown.bs.modal', function (e) {
    image_type = $(e.relatedTarget).attr('data-bs-image-type');
    $('#form_image_sidebar').hide();
    if (image_type == 'input') {
        data_item_id = $(e.relatedTarget).attr('data-bs-item-id');
        data_input_field = $(e.relatedTarget).attr('data-bs-field');
        data_input_id = $(e.relatedTarget).attr('data-bs-input-id');
    }

    refresh_images();
});

//select image
$(document).on('click', '#file_manager_image .file-box', function () {
    $('#file_manager_image .file-box').removeClass('selected');
    $(this).addClass('selected');
    $('#selected_img_file_id').val($(this).attr('data-file-id'));
    $('#selected_img_mid_file_path').val($(this).attr('data-mid-file-path'));
    $('#selected_img_default_file_path').val($(this).attr('data-default-file-path'));
    $('#selected_img_slider_file_path').val($(this).attr('data-slider-file-path'));
    $('#selected_img_big_file_path').val($(this).attr('data-big-file-path'));
    $('#selected_img_storage').val($(this).attr('data-file-storage'));
    $('#selected_img_base_url').val($(this).attr('data-file-base-url'));
    // Editor 
    $('#images-alt').val($(this).attr('data-file-alt'));
    $('#images-title').val($(this).attr('data-file-name'));
    $('#images-captions').val($(this).attr('data-file-captions'));
    $('#images-desc').val($(this).attr('data-file-des'));
    $('#images-url').val($(this).attr('data-file-base-url') + $(this).attr('data-default-file-path'));
    $('#btn_img_delete').show();
    $('#btn_img_select').show();
    $('#form_image_sidebar').show();
});


document.querySelectorAll('[data-toggle="images_form"]').forEach(function (el) {
    el.addEventListener("change", function () {
        var file_id = $('#selected_img_file_id').val();
        var input = el.dataset.input;


        document.querySelector(input).focus();
        console.log(document.querySelector(input).value);

        var data = {
            "file_id": file_id,
            "alt_name": $('#images-alt').val(),
            "file_name": $('#images-title').val(),
            "file_caption": $('#images-captions').val(),
            "file_desc": $('#images-desc').val(),
        };

        data[csrfName] = $.cookie(csrfCookie);

        $.ajax({
            type: "POST",
            url: baseUrl + '/admin/file/edit_image_file',
            data: data,
            beforeSend: function () {
                document.querySelector(input).classList.add('more-loader');
            },
            complete: function () {
                document.querySelector(input).classList.remove('more-loader');
            },
            success: function (response) {

            }

        });



    });
});


//refresh images
function refresh_images() {
    var data = {};
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/admin/file/get_images",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("image_file_upload_response").innerHTML = obj.content;
            }
        }
    });
}

//delete image file
$(document).on('click', '#file_manager_image #btn_img_delete', function () {
    var file_id = $('#selected_img_file_id').val();
    $('#img_col_id_' + file_id).remove();
    var data = {
        "file_id": file_id
    };
    data[csrfName] = $.cookie(csrfCookie);

    $.ajax({
        type: "POST",
        url: baseUrl + "/admin/file/delete_image_file",
        data: data,
        success: function (response) {
            $('#btn_img_delete').hide();
            $('#btn_img_select').hide();
        }
    });
});

//select image file
$(document).on('click', '#file_manager_image #btn_img_select', function () {
    select_image();
});

//select image file on double click
$(document).on('dblclick', '#file_manager_image .file-box', function () {
    select_image();
});

function select_image() {
    var file_id = $('#selected_img_file_id').val();
    var img_mid_file_path = $('#selected_img_mid_file_path').val();
    var img_default_file_path = $('#selected_img_default_file_path').val();
    var img_slider_file_path = $('#selected_img_slider_file_path').val();
    var img_big_file_path = $('#selected_img_big_file_path').val();
    var img_storage = $('#selected_img_storage').val();
    var img_base_url = $('#selected_img_base_url').val();

    if (image_type == 'editor') {
        tinymce.activeEditor.execCommand('mceInsertContent', false, '<p><img src="' + img_base_url + img_default_file_path + '" alt=""/></p>');
    } else {
        console.log(data_input_field);
        if (data_input_field) {
            $(data_input_id).val(img_base_url + img_default_file_path);
        } else {
            $(data_input_id).val(file_id);
        }

        $(data_item_id).attr('src', img_base_url + img_default_file_path);
    }

    $('#file_manager_image').modal('toggle');
    $('#file_manager_image .file-box').removeClass('selected');
    $('#btn_img_delete').hide();
    $('#btn_img_select').hide();
}

//load more images
jQuery(function ($) {
    $('#file_manager_image .file-manager-content').on('scroll', function () {
        var search = $("#input_search_image").val().trim();
        if (search.length < 1) {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                var min = 0;
                $('#image_file_upload_response .file-box').each(function () {
                    var value = parseInt($(this).attr('data-file-id'));
                    if (min == 0) {
                        min = value;
                    }
                    if (value < min) {
                        min = value;
                    }
                });
                var data = {
                    'min': min
                };
                data[csrfName] = $.cookie(csrfCookie);
                $.ajax({
                    type: "POST",
                    url: baseUrl + "/admin/file/load_more_images",
                    data: data,
                    success: function (response) {
                        setTimeout(function () {
                            var obj = JSON.parse(response);
                            if (obj.result == 1) {
                                $("#image_file_upload_response").append(obj.content);
                            }
                        }, 100);
                    }
                });
            }
        }
    })
});

//search image
$(document).on('input', '#input_search_image', function () {
    var search = $(this).val().trim();
    var data = {
        "search": search
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/admin/file/search_image_file",
        data: data,
        success: function (response) {
            if (search.length > 1) {
                var obj = JSON.parse(response);
                if (obj.result == 1) {
                    document.getElementById("image_file_upload_response").innerHTML = obj.content;
                }
            } else {
                refresh_images();
            }

        }
    });
});



//validate
$(document).on('input change keyup paste', '.validate-file-manager-input', function () {
    if ($(this).val().trim() == '') {
        $(this).addClass("input-error");
    } else {
        $(this).removeClass("input-error");
    }
});
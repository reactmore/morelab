$(document).ready(function () {
    $.fn.editableform.buttons = '<button type="submit" class="btn btn-success editable-submit btn-sm waves-effect waves-light"><i class="fa fa-check"></i></button><button type="button" class="btn btn-danger editable-cancel btn-sm waves-effect waves-light"><i class="fa fa-times"></i></button>';
    $(".inline-editable").editable({
        validate: function (e) {
            if ("" == $.trim(e)) return "This field is required"
        },
        mode: "inline",
        inputclass: "form-control-sm",
        success: function (response, newValue) {

            var data = {
                'id': $(this).attr('data-pk'),
                'translation': newValue,
            };

            data[csrfName] = $.cookie(csrfCookie);

            $.ajax({
                type: "POST",
                url: $(this).attr('data-link'),
                data: data,

                beforeSend: function () {
                    $("#wait").show();
                },
                complete: function () {
                    $("#wait").hide();

                },
                success: function (response) {
                    location.reload();
                },
                error: function (e) {
                    custom_alert('error', 'Some Error ! Data Not change please Try again', false)
                }

            });

        }
    });
});
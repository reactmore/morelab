/**
 * Theme: Reactmore Admin
 * Author: More
 */

$(document).ready(function () {
    $('#wait').hide();
    $("form").on('submit', function () {
        $("#crsf").attr("name", csrfName).val($.cookie(csrfCookie));
    });

    $("#checkAll").on('click', function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('.btnNext').click(function () {
        $('.nav-tabs .active').parent().next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function () {
        $('.nav-tabs .active').parent().prev('li').find('a').trigger('click');
    });

    document.querySelectorAll('[data-toggle="password"]').forEach(function (el) {
        el.addEventListener("click", function (e) {
            e.preventDefault();

            var target = el.dataset.target;
            var icon = el.dataset.icon;
            document.querySelector(target).focus();
            document.querySelector(icon).focus();

            if (document.querySelector(target).getAttribute('type') == 'password') {
                document.querySelector(target).setAttribute('type', 'text');
                document.querySelector(icon).setAttribute('class', 'fa fa-eye-slash');
            } else {
                document.querySelector(target).setAttribute('type', 'password');
                document.querySelector(icon).setAttribute('class', 'fa fa-eye');
            }
        });
    });
});




function generateUniqueString(prefix) {
    var time = String(new Date().getTime()),
        i = 0,
        output = '';
    for (i = 0; i < time.length; i += 2) {
        output += Number(time.substr(i, 2)).toString(36);
    }
    return (prefix + '-' + output.toUpperCase());
}

function custom_alert(type, msg, reload = true) {
    var toastMixin = Swal.mixin({
        toast: true,
        icon: type,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,

        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
            toast.addEventListener('click', Swal.close);
        },
        didClose: () => {
            if (reload) {
                location.reload();
            }
        }


    });

    toastMixin.fire({
        title: msg
    });
};


//confirm user email
function confirm_user_email(id) {
    var data = {
        'id': id,
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: `${baseUrl}/admin/usermanagement/confirm_user_email`,
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

//delete item
function delete_item(url, id, message) {
    Swal.fire({
        text: message,
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: sweetalert_ok,
        cancelButtonText: sweetalert_cancel,
    }).then(function (willDelete) {
        if (willDelete.value) {
            var data = {
                'id': id,
            };
            data[csrfName] = $.cookie(csrfCookie);
            $.ajax({
                type: "POST",
                url: baseUrl + url,
                data: data,
                beforeSend: function () {
                    $("#wait").show();
                },
                complete: function () {
                    $("#wait").hide();

                },
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

//ban user
function ban_user(id, message, option) {
    Swal.fire({
        text: message,
        icon: "warning",
        showCancelButton: 1,
        confirmButtonColor: "#34c38f",
        cancelButtonColor: "#f46a6a",
        confirmButtonText: sweetalert_ok,
        cancelButtonText: sweetalert_cancel,

    }).then(function (willDelete) {
        if (willDelete.value) {
            var data = {
                'id': id,
                'option': option
            };
            const newLocal = $.cookie(csrfCookie);
            data[csrfName] = newLocal;
            $.ajax({
                type: "POST",
                url: `${baseUrl}/admin/usermanagement/ban_user_post`,
                data: data,
                beforeSend: function () {
                    $("#wait").show();
                },
                complete: function () {
                    $("#wait").hide();

                },
                success: function (response) {
                    location.reload();
                }
            });
        }
    });
};

function get_states_by_country(val) {
    var data = {
        "country_id": val
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/AjaxController/get_states_by_country",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("selected_states").innerHTML = obj.content;
            }
        }
    });
}

function get_states(val, map) {
    $('#select_states').children('option').remove();
    $('#select_cities').children('option').remove();
    $('#get_states_container').hide();
    $('#get_cities_container').hide();
    var data = {
        "country_id": val,
        "sys_lang_id": sys_lang_id
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/AjaxController/get_states",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("select_states").innerHTML = obj.content;
                $('#get_states_container').show();
            } else {
                document.getElementById("select_states").innerHTML = "";
                $('#get_states_container').hide();
            }
            if (map) {
                update_product_map();
            }
        }
    });
}

function get_cities(val, map) {
    var data = {
        "state_id": val,
        "sys_lang_id": sys_lang_id
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/AjaxController/get_cities",
        data: data,
        success: function (response) {
            var obj = JSON.parse(response);
            if (obj.result == 1) {
                document.getElementById("select_cities").innerHTML = obj.content;
                $('#get_cities_container').show();
            } else {
                document.getElementById("select_cities").innerHTML = "";
                $('#get_cities_container').hide();
            }
            if (map) {
                update_product_map();
            }
        }
    });
}


function update_product_map() {
    var country_text = $("#select_countries").find('option:selected').text();
    var country_val = $("#select_countries").find('option:selected').val();
    var state_text = $("#select_states").find('option:selected').text();
    var state_val = $("#select_states").find('option:selected').val();
    var address = $("#address_input").val();
    var zip_code = $("#zip_code_input").val();
    var data = {
        "country_text": country_text,
        "country_val": country_val,
        "state_text": state_text,
        "state_val": state_val,
        "address": address,
        "zip_code": zip_code,
        "sys_lang_id": sys_lang_id
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/AjaxController/show_address_on_map",
        data: data,
        success: function (response) {
            document.getElementById("map-result").innerHTML = response;
        }
    });
}

//activate inactivate countries
function activate_inactivate_countries(action) {
    var data = {
        "action": action
    };
    data[csrfName] = $.cookie(csrfCookie);
    $.ajax({
        type: "POST",
        url: baseUrl + "/AjaxController/activate_inactivate_countries",
        data: data,
        success: function (response) {
            location.reload();
        }
    });
};

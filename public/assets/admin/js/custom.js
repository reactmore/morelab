/**
 * Theme: Reactmore Admin
 * Author: More
 */

$(document).ready(function () {
    $('#wait').hide();

    $("form").on('submit', function () {
        $("#crsf").attr("name", csrfName).val(csrfHash);
    });

    $("#checkAll").on('click', function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
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

document.querySelectorAll('#role').forEach(function (role) {
    role.addEventListener("change", function (event) {

        var selected = event.target.value;
        const result = document.querySelector('#addon_info');
        const button = document.querySelector('#single_submit');

        if (selected === 'employee') {
            result.style.display = "block";
            button.style.display = "none";
            document.querySelector('[data-required="true"]').required = true;
        } else {
            result.style.display = "none";
            button.style.display = "block";
            document.querySelector('[data-required="true"]').required = false;
        }
        get_department();
        $('.department').change(function () {
            var dept_id = $('.department').val();
            get_positions_by_id(dept_id);
        });

    });
});

$('.edit_department').change(function () {
    var dept_id = $('.edit_department').val();
    get_positions_by_id(dept_id);
});

function get_department() {


    $.ajax({
        url: baseUrl + "ajax_controller/get_department",
        method: "GET",
        async: true,
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].id + '>' + data[i].text + '</option>';
            }

            $('.department').html(html);

        }
    });
}

function get_positions_by_id(id) {
    $.ajax({
        url: baseUrl + "ajax_controller/get_positions/" + id,
        method: "GET",
        async: true,
        dataType: 'json',
        success: function (data) {
            var html = '';
            var i;
            for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].id + '>' + data[i].text + '</option>';
            }
            $('.positions').html(html);

        }
    });
}

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
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
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
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: baseUrl + "admin_controller/ban_user_post",
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
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: baseUrl + "ajax_controller/get_states_by_country",
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
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: baseUrl + "ajax_controller/get_states",
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
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: baseUrl + "ajax_controller/get_cities",
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
    data[csfr_token_name] = $.cookie(csfr_cookie_name);
    $.ajax({
        type: "POST",
        url: baseUrl + "ajax_controller/show_address_on_map",
        data: data,
        success: function (response) {
            document.getElementById("map-result").innerHTML = response;
        }
    });
}
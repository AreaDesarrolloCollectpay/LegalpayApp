$(function () {
    $(".btn-change-pass").click(function () {
        if ($.trim($("#anteriorcontrasena").val()) === "") {
            $(".resp-change-pass").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+messages[1]+'</div>');
            return;
        }
        if ($("#nuevacontrasena").val() !== $("#repitacontrasena").val()) {
            $(".resp-change-pass").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+messages[2]+'</div>');
            return;
        }
        if ($.trim($("#nuevacontrasena").val()) === "" && $.trim($("#repitacontrasena").val()) === "") {
            $(".resp-change-pass").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>'+messages[3]+'</div>');
            return;
        }
        $.ajax({
            url: pathurl + "cms/dashboard/changepass",
            type: 'POST',
            data: {ant: $.trim($("#anteriorcontrasena").val()), new : $.trim($("#nuevacontrasena").val()), YII_CSRF_TOKEN: csrfToken},
            success: function (result) {
                if (result === "ok") {
                    $("#nuevacontrasena").val("");
                    $("#repitacontrasena").val("");
                    $("#anteriorcontrasena").val("");
                    $(".resp-change-pass").html("");
                    $('#login-form').modal('hide');
                    toastr['success'](messages[4]);
                } else{
                    $(".resp-change-pass").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>' + result + '</div>');
                }
            },
            beforeSend: function () {

            },
            error: function (result) {
                toastr['error'](result.status + ' ' + result.statusText);
            }
        });
    });
});
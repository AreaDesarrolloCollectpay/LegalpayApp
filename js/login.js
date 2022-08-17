$(function () {
    $('#login').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: pathurl +  "cms/dashboard/login",
            type: 'POST',
            data: $('#login').serialize(),
            complete : function(){
                unloading('#login');
            },
            success: function(result){
                if(result.status === "ok"){
                    window.location = pathurl + result.url;                
                }else{
                    toastr['error'](result.message);
                }
            },
            beforeSend: function() {
                 loading('#login');
            },
            error: function(result) {
                unloading('#login');
                toastr['error'](result.status + ' ' + result.statusText);
            }
        });
    });
    $('#recovery').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: pathurl +  "cms/dashboard/recoverypassword",
            type:'POST',
            data: { emailRecipient: $(".email").val(), YII_CSRF_TOKEN : csrfToken},
            success: function(result){
                if(result==="ok"){
                    toastr['success']("Hemos enviado un email a "+ $(".email").val() +", consúltelo y siga las instrucciones...");
                    setTimeout(function(){
                        window.location = pathurl + "cms/";
                    }, 2000);
                }else{
                    toastr['error'](result);
                }
                unloading();
            },
            beforeSend: function() {
                 loading();
            },
            error: function(result) {
                toastr['error'](result.status + ' ' + result.statusText);
            }
        });
    });
});
(function($){

    var notificationBar = $('.notification-container').sudoNotify({
        autoHide: false,
        showCloseButton: false
    });

    $('.mobile-nav').click(function () {
        $(this).toggleClass('active');
        $('.login-box ul').slideToggle('fast');
    });

    $('#login-form').submit(function () {
        $("#login-form input[type=submit]").attr('disabled', 'disabled');
        $("#login-form input[type=submit]").val('SENDING');
        var loginData = $('#login-form').serialize();
        $.post('/v2/auth/loginPost', loginData, function () {
            window.location.href = '/';
            return false;
        }).always(function () {
            $("#login-form input[type=submit]").removeAttr('disabled');
            $("#login-form input[type=submit]").val('LOGIN');
        }).fail(function(){
            notificationBar.error("We can't login you with email and password you have provided");
            $('.notification-container').click(function(){
                notificationBar.close();
            });
            setTimeout(function () {
                notificationBar.close();
            }, 8000);
        });

        return false;
    });

    $('#signup-form').submit(function(){
        $('#signup-form input[type=text], #signup-form input[type=password]').each(function () {
            if ($(this).val().length < 1) {
                $(this).addClass('error');
            }
        });

        if ($('#signup-form input.error').length < 1) {
            var registerData = $('#signup-form').serialize();
            $.post('/v2/auth/registerPost', registerData, function(){
                window.location.href = '/';
            }).always(function(){
                setTimeout(function () {
                    // restore text on signup button
                    $('.do-register').html('Register');
                }, 150);
            }).fail(function(jqXHR, textStatus, errorThrown){
                response = $.parseJSON(jqXHR.responseText);
                if (response.error) {
                    notificationBar.error(response.error);
                } else {
                    notificationBar.error("Oops. Something went wrong. Please try again. If you keep seeing this message, contact us");
                }
                $('.notification-container').click(function(){
                    notificationBar.close();
                });
                setTimeout(function () {
                    notificationBar.close();
                }, 8000);
            });
            loadSpinner();
        } else {
            notificationBar.error('Fields in Red are mandatory ones');
            setTimeout(function () {
                notificationBar.close();
            }, 8000);
        }

        return false;
    });

    $('#signup-form input[type=text], #signup-form input[type=password]').on('focus', function () {
        $(this).removeClass('error');
    });
}(jQuery));

function loadSpinner() {
    object = $('.do-register');
    html = '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
    object.html(html);
}

function unloadSpinned() {
    object = $('.do-register');
    object.html('Register');
}
$(document).ready(function () {

    var notificationBar = $('.notification-container').sudoNotify({
        autoHide: false,
        showCloseButton: false
    });

    console.log($.fn.sudoNotify);

    $('.mobile-nav').click(function () {
        $(this).toggleClass('active');
        $('.login-box ul').slideToggle('fast');
    });

    $('#signup-form input[type=text], #signup-form input[type=password]').on('focus', function () {
        $(this).removeClass('error');
    });

    $('.do-register').on('click', function () {
        $('#signup-form input[type=text], #signup-form input[type=password]').each(function () {
            if ($(this).val().length < 1) {
                $(this).addClass('error');
            }
        });
        if ($('#signup-form input.error').length < 1) {
            loadSpinner();
            setTimeout(function () {
                // restore text on signup button
                $('.do-register').html('Register');
            }, 2500);
        } else {
            notificationBar.error('Fields in Red are mandatory ones');
            setTimeout(function () {
                notificationBar.close();
            }, 8000);
        }

        return false;
    });

});

function loadSpinner() {
    object = $('.do-register');
    html = '<div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
    object.html(html);
}

function unloadSpinned() {
    object = $('.do-register');
    object.html('Register');
}
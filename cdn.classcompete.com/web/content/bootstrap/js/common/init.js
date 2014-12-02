var description_limter = 200;
var ajax_loader_url = BASEURL + 'assets/images/ajax_loader.gif';

var current_url = window.location.pathname;
var url_parts = current_url.split('/');

var url_segments = jQuery.map(url_parts, function (el) {
    return el !== '' ? el : null;
});

var subdomain_name = window.location.hostname.match(/^.*?-?(\w*)\./)[1];

if (subdomain_name === 'admin') {
    // gritter options
    $.extend($.gritter.options, {
        position: 'bottom-right',
        time: 4000
    });
}

if (subdomain_name === 'teacher') {
    // gritter options
    $.extend($.gritter.options, {
        position: 'bottom-right',
        time: 4000
    });
}

// reset error indicators to default state
function clearErrorIndicators() {
    $('.control-group').removeClass('error');
    $('.help-inline').empty();
}

function moveToTop() {
    $('html,body').animate({ scrollTop: 0 }, 400);
}

function isOldEnough(dob_year, dob_month, dob_day) {
    var now = new Date();

    var user_dob = new Date(dob_year + '-' + dob_month + '-' + dob_day);

    var now_month = now.getMonth() + 1;
    now_month = (now_month < 10) ? ("0" + now_month) : now_month;
    var now_day = now.getDate();
    now_day = (now_day < 10) ? ("0" + now_day) : now_day;

    var unix_dob = user_dob.getTime();
    var allowed_year = (now.getFullYear() - 13);
    var unix_allowed = new Date(allowed_year + '-' + now_month + '-' + now_day);
    if ((unix_allowed - unix_dob) < 0) {
        // not old enough
        return false;
    } else {
        // old enough
        return true;
    }
}

$(document).ready(function () {
    // reset error indicators to default state for edit forms
    $('.edit').unbind('click').click(function () {
        clearErrorIndicators();
    });

    // alert that you reached maxlenght on inputs
    $('textarea[maxlength],:text[maxlength]').keyup(function () {
        var t = $(this);
        var max_length = parseInt(t.attr('maxlength'));
        var current_length = t.val().length;

        if (max_length === current_length) {
            $.gritter.add({
                title: 'Info',
                text: 'You have reached max length of this field',
                before_open: function () {
                    if ($('.gritter-item-wrapper').length == 1) {
                        return false;
                    }
                }
            });
        }
    });
});


jQuery(document).ready(function () {

    subscribe_ajax();
    connection_ajax();
});

jQuery(document).ajaxSuccess(function () {
    subscribe_ajax();
    connection_ajax();
});

function subscribe_ajax()
{
    jQuery('.ajax_form_subscribe').unbind('submit').submit(function (e) {

        var t = jQuery(this);

        var postdata = t.serialize();
        jQuery.ajax({
            url: 'http://ccapi.classcompete.com/subscriber',
            dataType: 'json',
            type: 'POST',
            data: postdata,
            success: function (r) {
                //show_response(r, '#wrapper_subscribe', 'success');
                show_alert(r);
            },
            error: function (jqXHR, text, error) {
                error = jQuery.parseJSON(jqXHR.responseText);
                //show_response(error, '#wrapper_subscribe', 'error');
                show_alert(error);
            }
        });

        return false;

//        e.preventDefault();
    });
}

function connection_ajax(){
    jQuery('.ajax_form_connection').unbind('submit').submit(function (e) {

        var t = jQuery(this);

        var postdata = t.serialize();
        jQuery.ajax({
            url: 'http://ccapi.classcompete.com/connection',
            dataType: 'json',
            type: 'POST',
            data: postdata,
            success: function (r) {
                //show_response(r, '#wrapper_connection', 'success');
                show_alert(r);
            },
            error: function (jqXHR, text, error) {

                error = jQuery.parseJSON(jqXHR.responseText);

                //show_response(error, '#wrapper_connection', 'error');
                show_alert(error);
            }
        });

        e.preventDefault();

    });
}



function show_response(json, wrapper, response_type) {
    var msg = '<div class="' + response_type + '">';

    jQuery.each(json, function (k, v) {
        msg += '<p>' + v + '</p>';
    });

    msg += '</div>';
    jQuery(wrapper).empty().html(msg);
}

function show_alert(json){
    var msg = '';

    if (json === null){
        msg = 'error';
    } else {
        jQuery.each(json, function (k, v) {
            msg += v + '\n';
        });
    }

    alert(msg);
}
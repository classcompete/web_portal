$(document).ready(function () {
    $('#teacher_register').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#registration_form').serialize();

        model.validateTeacherRegistration(data, function (r) {

            if (r.validation === true) {
                $('#registration_form').submit();
            } else {
                if (r.username) {
                    $('#username').removeClass('success_border').addClass('error_border');
                    $('#username').siblings('.help-inline').addClass('error_text').html(r.username);
                }else if(r.username_taken){
                    $('#username').removeClass('success_border').addClass('error_border');
                    $('#username').siblings('.help-inline').addClass('error_text').html(r.username_taken);
                } else {
                    $('#username').removeClass('error_border').addClass('success_border');
                    $('#username').siblings('.help-inline').empty();
                }

                if (r.first_name) {
                    $('#first_name').removeClass('success_border').addClass('error_border');
                    $('#first_name').siblings('.help-inline').addClass('error_text').html(r.first_name);
                } else {
                    $('#first_name').removeClass('error_border').addClass('success_border');
                    $('#first_name').siblings('.help-inline').empty();
                }

                if (r.last_name) {
                    $('#last_name').removeClass('success_border').addClass('error_border');
                    $('#last_name').siblings('.help-inline').addClass('error_text').html(r.last_name);
                } else {
                    $('#last_name').removeClass('error_border').addClass('success_border');
                    $('#last_name').siblings('.help-inline').empty();
                }

                if (r.email) {
                    $('#email').removeClass('success_border').addClass('error_border');
                    $('#email').siblings('.help-inline').addClass('error_text').html(r.email);
                }else if(r.email_taken){
                    $('#email').removeClass('success_border').addClass('error_border');
                    $('#email').siblings('.help-inline').addClass('error_text').html(r.email_taken);
                } else {
                    $('#email').removeClass('error_border').addClass('success_border');
                    $('#email').siblings('.help-inline').empty();
                }

                if (r.password) {
                    $('#password').removeClass('success_border').addClass('error_border');
                    $('#password').siblings('.help-inline').addClass('error_text').html(r.password);
                } else {
                    $('#password').removeClass('error_border').addClass('success_border');
                    $('#password').siblings('.help-inline').empty();
                }

                if (r.re_password) {
                    $('#re_password').removeClass('success_border').addClass('error_border');
                    $('#re_password').siblings('.help-inline').addClass('error_text').html(r.re_password);
                } else {
                    $('#re_password').removeClass('error_border').addClass('success_border');
                    $('#re_password').siblings('.help-inline').empty();
                }

                if(r.terms_and_policy){
                    $('#terms_and_policy').parent().addClass('error_text');
                    $('#terms_and_policy').parent().siblings('.help-inline').addClass('error_text').html(r.terms_and_policy);
                }else{
                    $('#terms_and_policy').parent().removeClass('error_text');
                    $('#terms_and_policy').parent().siblings('.help-inline').removeClass('error_text').html();
                }
                if(r.not_listed_school){
                    $('#not_listed').parent().addClass('error_text');
                    $('#not_listed').parent().siblings('.help-inline').addClass('error_text').html(r.not_listed_school);
                }else{
                    $('#not_listed').parent().removeClass('error_text');
                    $('#not_listed').parent().siblings('.help-inline').removeClass('error_text').html();
                }
            }

        });

    });

    $('#reset').unbind('click').click(function(e){
        e.preventDefault();
        var formData = $('#reset_password').serialize();
        model.validateTeacherForgotPassword(formData, function(c){
            if(c.validation === true){
                $('#reset_password').submit();
            }
            else{
                $('#email').addClass('error_border');
                $('.error').addClass('error_text').html(c.error);
            }
        });

    });

    $('#school_name').autocomplete({
        minLength: 5,
        cache: false,
        focus: function(event, ui){
            return false;
        },
        select: function(event, ui){
            this.value = ui.item.label;
            $('#school_id').val(ui.item.id)
        },
        source: function(request, response){
            var zip_code = $('#zip_code').val();
            var data = {school:request.term, zip_code:zip_code}

            $.post(BASEURL +'auth/ajax_school',{school:data}, function(data){
                response($.map(data, function(item){
                    return {
                        label:item.name,
                        id: item.school_id
                    }
                }))
                },'json');
            }
        });
});
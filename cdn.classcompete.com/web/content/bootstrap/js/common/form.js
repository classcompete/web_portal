function clearFormFields(id) {
    $(id).find("input[type=text], input[type=hidden], textarea").val("");
    $(id).find("input[type=radio], input[type=checkbox]").removeAttr('checked');
    clearErrorIndicators();
}

function clearDropDownBoxAll(id) {
    $(id).find("select").empty();
}

function clearDropDownBoxSpec(id) {
    $(id).empty();
}

$(document).ready(function () {
    /**
     * Add new Classroom form validation
     */
    $('#class_form_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#class_form').serialize();

        model.validateClass(data, function (r) {
            if (r.validation !== true) {
                if (r.name) {
                    $('#name').parents('.control-group').addClass('error');
                    $('#name').siblings('.help-inline').html(r.name);
                }
                if (r.class_code) {
                    $('#auth_code').parents('.control-group').addClass('error');
                    $('#auth_code').siblings('.help-inline').html(r.class_code);
                }
            } else {
                $('#class_form').submit();
            }
        });
    });
});
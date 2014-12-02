$(document).ready(function () {
    jQuery.fn.modal.Constructor.prototype.enforceFocus = function () {
    };

    /**
     * CLASSES TRIGGERS
     */
    $("#addNewClassTeacher").click(function (e) {
        e.preventDefault();

        clearFormFields('#addEditClassTeacher');

        model.getNewClassCode(function (r) {
            $("#auth_code").val(r);
            $("#limit").val('2');
            $("#price").val('0');
        });
    });

    $(".mod-classes .edit").click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        clearFormFields('#addEditClass');

        $('#user_id').html('<option value="" selected="selected" disabled="disabled">Select teacher...</option>');

        model.getClassById(id, function (r) {

            if (subdomain_name === 'admin') {
                model.getTeachersFromClasses(function (a) {
                    $.each(a, function (key, value) {
                        if (r.user_id === value.user_id) {
                            $('#user_id').append("<option value=" + value.user_id + " selected='selected'>" + value.first_name + ' ' + value.last_name + "</option>");
                        } else {
                            $('#user_id').append("<option value=" + value.user_id + ">" + value.first_name + ' ' + value.last_name + "</option>");
                        }
                    });
                    $('#name').val(r.name);
                    $('#auth_code').val(r.auth_code);
                    $('#edit_class_id').val(r.id);
                    $('#price').val(r.price);
                    $('#limit').val(r.limit);
                });
            } else {
                $('#name').val(r.name);
                $('#auth_code').val(r.auth_code);
                $('#edit_class_id').val(r.id);
            }
        });
    });

    $('.mod-classes .refresh').unbind('click').click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        var t = $(this);

        var degrees = 360;
        t.animateRotate(degrees);

        showClassStudents(id);
    });

    $('.mod-classes .students_in_class_stats_accordion').unbind('click').click(function () {
        var t = $(this);
        var class_id = t.data('class-id');

        model.getReportStudentStatsClassroom(class_id, function (r) {
            do_chart(r, 'students_in_class_chart_wrap');
        });
    });

    $('.mod-classes .accordion-toggle').unbind('click').click(function () {
        var t = $(this);

        if (t.hasClass('triggered') === false) {
            var id = $(this).attr('id');

            showClassStudents(id);

        }
        t.addClass('triggered');
    });

    $('#student_password_change_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var form_data = $('#change_student_password_form').serializeArray();
        if (form_data[0].value === form_data[1].value) {

            //var user_id = $(this).data('user-id');
            var user_id = $('#student_password_change_user_id').val();
            var data = {
                user_id: user_id,
                password: form_data[0].value
            };

            model.changeUserPassword(data, function (r) {
                $.gritter.add({
                    title: 'Success',
                    text: 'Student password successfully changed'
                });

                $('#passwordChange').modal('hide');
            });
        } else {
            $.gritter.add({
                title: 'Error',
                text: 'Passwords do not match, please retype'
            });
        }
    });

    /**
     * CHALLENGES PAGE
     */
        // marketplace filters
    $('#challenge_filter_grade_selector, #challenge_filter_subject_selector, #challenge_filter_topic_selector').unbind('change').change(function (e) {

        var selected_grade = $('#challenge_filter_grade_selector').val();
        var selected_subject = $('#challenge_filter_subject_selector').val();
        var selected_skill = $('#challenge_filter_topic_selector').val();

        console.log('grade: ' + selected_grade);
        console.log('subject: ' + selected_subject);
        console.log('skill: ' + selected_skill);

        if (this.id === 'challenge_filter_subject_selector') {
            selected_skill = 'all';
            if (selected_subject === 'all') {
                $('#challenge_filter_topic_selector').html('<option value="all">All</option>');
                model.getSkillListMarketplace(function (r) {
                    $.each(r, function (k, v) {
                        $('#challenge_filter_topic_selector').append("<option value=" + v.skill_id + ">" + v.skill_name + "</option>");
                    });
                    $('#challenge_filter_topic_selector').removeAttr('disabled');
                });
            } else {
                $('#challenge_filter_topic_selector').html('<option value="all">All</option>');
                model.getSkillBySubjectIdMarketplace(selected_grade,selected_subject, function (r) {
                    if (r.length > 0) {
                        $.each(r, function (k, v) {
                            $('#challenge_filter_topic_selector').append("<option value=" + v.skill_id + ">" + v.skill_name + "</option>");
                        });
                        $('#challenge_filter_topic_selector').removeAttr('disabled');
                    } else {
                        $('#challenge_filter_topic_selector').attr('disabled', 'disabled');
                    }
                });
            }
        }

        var grade = '';
        var subject = '';
        var skill = '';

        if (selected_grade !== 'all') {
            grade = '[data-grade="' + selected_grade + '"]';
        }

        if (selected_subject !== 'all') {
            subject = '[data-subjectid="' + selected_subject + '"]';
        }

        if (selected_skill !== 'all') {
            skill = '[data-skill-id="' + selected_skill + '"]';
        }

        $('#challenge_filter_challenges_list .challenge').fadeOut();
        if (selected_grade === 'all' && selected_subject === 'all' && selected_skill === 'all') {
            $('#challenge_filter_challenges_list .challenge').fadeOut('slow', function(){
                $('#challenge_filter_intro').fadeIn('slow');
            });
        } else {
            if ($('#challenge_filter_intro').css('display') === 'none') {
                $('#challenge_filter_challenges_list .challenge' + grade + subject + skill).fadeIn('slow');
            } else {
                $('#challenge_filter_intro').fadeOut('slow', function(){
                    $('#challenge_filter_challenges_list .challenge' + grade + subject + skill).fadeIn('slow');
                });
            }
        }
    });

    var current_grade_tab = 0;
    $('.myTabBeauty li').unbind('click').click(function () {

        // if clicked on different tab
        if ($(this).index() !== current_grade_tab) {
            var selected_grade = $('.myTabBeauty li.active').index() + 1;
            $('#subject_all_option').attr('selected', 'selected');
            $('#grade_' + selected_grade + ' .container-fluid .challenge').fadeIn();
        }
        current_grade_tab = $(this).index();
    });

    $('#marketplace_challenges_list .install_challenge, #challenge_filter_challenges_list .install_challenge').unbind('click').click(function () {

        // set class select to default state
        $('#class_id option:first').attr('selected', 'selected');

        var challenge_id = $(this).data('challengeid');

        $('#class_id').html('<option selected="selected" disabled="disabled">Select class...</option>');

        $('#challenge_id').val(challenge_id);


        model.getClassesForMarketplaceAddChallenge(challenge_id, function (r) {
            if (r.installed === 'all') {
                $('#class_id').parents('.control-group').hide();
                $('#challenge_btn_install').hide();
                $('#no_classes').show();
                $('#challenge_btn_close').show();
            } else {
                $('#no_classes').hide();
                $('#challenge_btn_close').hide();
                $('#class_id').parents('.control-group').show();
                $('#challenge_btn_install').show();

                $.each(r, function (k, v) {
                    $('#class_id').append("<option value=" + v.class_id + ">" + v.class_name + "</option>");
                });
            }
        });
    });

    $('#challenge_btn_install').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#install_challenge_form').serialize();

        model.validateInstallChallengeFromMarketplace(data, function (r) {

            if (r.validation === true) {

                model.installChallengeFromMarketplace(data, function(c){
                    $('#installChallenge').modal('hide');
                });
            } else {
                if (r.class_id) {
                    $('#class_id').parents('.control-group').addClass('error');
                    $('#class_id').siblings('.help-inline').html(r.class_id);
                }
            }
        });
    });

    /**
     * EXTENSIONS
     */

    jQuery.fn.dotdotdot = function (length) {
        if (typeof length === 'undefined') {
            length = 40;
        }

        var element = $(this);

        var text = element.html();

        if (text.length >= length) {
            text = text.substr(0, length) + '...';
            element.html(text);
        }
    };

    jQuery.fn.dd_add_title = function () {
        var element = $(this);

        var title = element.find(":selected").text();
        element.attr('title', title);
    };

    jQuery.fn.animateRotate = function (angle, duration, easing, complete) {
        angle += angle;
        var args = $.speed(duration, easing, complete);
        var step = args.step;
        return this.each(function () {
            var $elem = $(this);
            args.step = function (now) {
                $elem.css({
                    transform: 'rotate(' + now + 'deg)'
                });
                if (step) return step.apply(this, arguments);
            };

            $({deg: 0}).animate({deg: angle}, args);
        });
    };
});

function do_chart(stats, wrapper, chart_type, colors) {
    if (stats !== false && stats.length > 1) {
        if (typeof chart_type === 'undefined' || chart_type === null) {
            chart_type = 'column';
        }

        var color_set = ['#ed6d49', '#0daed3', '#ffb400', '#74b749', '#f63131'];
        if (typeof colors === 'object') {
            if (colors.randomize === true) {
                if (typeof colors.no === 'number') {
                    color_set = randomize_hex_colors(colors.no);
                } else {
                    color_set = randomize_hex_colors(5);
                }
            }
        }

        var data = google.visualization.arrayToDataTable(stats);
        var options = {
            width: 'auto',
            height: '160',
            backgroundColor: 'transparent',
            colors: color_set,
            tooltip: {
                textStyle: {
                    color: '#666666',
                    fontSize: 11
                },
                showColorCode: true
            },
            legend: {
                textStyle: {
                    color: 'black',
                    fontSize: 12
                }
            },
            chartArea: {
                left: 60,
                top: 10,
                height: '80%'
            },
            vAxis: {
                baseline: 0
            }
        };
        var chart;
        switch (chart_type) {
            case 'column':
                chart = new google.visualization.ColumnChart(document.getElementById(wrapper));
                break;
            case 'line':
                chart = new google.visualization.LineChart(document.getElementById(wrapper));
                break;
        }
        chart.draw(data, options);
    } else {
        $('#' + wrapper).empty();
    }
}

function randomize_hex_colors(no) {
    if (typeof no !== 'number') {
        no = 1;
    }
    var colors = [];
    for (var i = 1; i <= no; i++) {
        colors.push('#' + ((1 << 24) * Math.random() | 0).toString(16));
    }
    return colors;
}

function showClassStudents(classId)
{
    var id = classId;

    model.getStudentsFromClassByClassId(id, function (r) {
        $('#accordion_list' + id).empty();
        $('#accordion_list_count' + id).html(r.students_count);

        $.each(r.students, function (k, v) {
            if (v.is_active === 'yes') {
                var displayEnable = 'none';
                var displayDisable = '';
            } else {
                var displayEnable = '';
                var displayDisable = 'none';
            }

            var html = '<li class="active_' + v.is_active + '">' +
                '<i class="icon-user" data-original-title=""></i>&nbsp;' +
                v.first_name + ' ' + v.last_name +
                '<div class="buttons pull-right">' +
                '<a id="' + v.user_id + '" data-icon="&#xe096" aria-hidden="true" class="fs1 student_profile show-tooltip" data-toggle="modal" title="View Student Profile" ' +
                'data-target="#studentInfo" data-original-title="" data-backdrop="static">&nbsp;</a>' +
                '<a data-icon="&#xe087" aria-hidden="true" class="fs1 student_password_change show-tooltip" data-toggle="modal" title="Change Student Password" ' +
                'data-target="#passwordChange" data-original-title="" data-backdrop="static" data-user-id="' + v.user_id + '">&nbsp;</a>' +
                '<a data-icon="&#xe0a8" aria-hidden="true" class="fs1 student_remove show-tooltip" data-toggle="modal" title="Remove student from class"' +
                'data-target="#removeStudentFromClass" data-original-title="" data-backdrop="static" data-user-id="' + v.user_id + '">&nbsp;</a>' +
                '<a data-icon="&#xe107" aria-hidden="true" class="fs1 disable_student_access show-tooltip" style="display: ' + displayDisable + '" title="Disable student access"' +
                'data-target="#disableStudentAccess" data-original-title="" data-backdrop="static" data-user-id="' + v.user_id + '">&nbsp;</a>' +
                '<a data-icon="&#xe105" aria-hidden="true" class="fs1 enable_student_access show-tooltip" style="display: ' + displayEnable + '" title="Enable student access"' +
                'data-target="#enableStudentAccess" data-original-title="" data-backdrop="static" data-user-id="' + v.user_id + '">&nbsp;</a>' +
                '</div></li>';
            $('#accordion_list' + id).append(html);
        });

        $('.disable_student_access').unbind('click').click(function(){
            var a = $(this);

            $.ajax({
                type: "POST",
                url: "/classes/ajax_set_student_active",
                data: {
                    user_id: a.data('user-id'),
                    class_id: id,
                    is_active: 'no'
                },
                success: function(response){
                    var user = $.parseJSON(response);
                    if (user.is_active === 'no') {
                        a.parent('div').parent('li').toggleClass('active_yes').toggleClass('active_no');
                        a.hide();
                        a.parent('div').children('.enable_student_access').show();
                    }
                }
            });


        });

        $('.enable_student_access').unbind('click').click(function(){
            var a = $(this);

            $.ajax({
                type: "POST",
                url: "/classes/ajax_set_student_active",
                data: {
                    user_id: a.data('user-id'),
                    class_id: id,
                    is_active: 'yes'
                },
                success: function(response){
                    user = $.parseJSON(response);

                    if (user.is_active === 'yes') {
                        a.parent('div').parent('li').toggleClass('active_yes').toggleClass('active_no');
                        a.hide();
                        a.parent('div').children('.disable_student_access').show();
                    }
                }
            });
        });

        $('.student_password_change').unbind('click').click(function () {
            var user_id = $(this).data('user-id');
            $('#student_password_change_user_id').val(user_id);
        });

        var table_initalized = false;

        $('.student_profile').unbind('click').click(function () {
            var t = $(this);

            moveToTop();

//                    if (t.hasClass('triggered') === false) {
            var id = $(this).attr('id');
            model.getStudentProfileFromClassByUserId(id, function (s) {
                var user_id = s.user_id;

                $('#username').empty().html(s.username);
                $('#full_name').empty().html(s.first_name + ' ' + s.last_name);
                $('#email').empty().html(s.student_email);

                if (typeof s.student_dob === 'string') {
                    var dob = s.student_dob.split('/');

                    if (isOldEnough(dob[0], dob[1], dob[2]) === true) {
                        $('#parent_email').empty();
                        $('#parent_email').parent().hide();
                        $('#email').parent().show();
                    } else {
                        if (s.parent_email !== 'false') {
                            $('#parent_email').empty().html(s.parent_email);
                            $('#parent_email').parent().show();
                            $('#email').parent().hide();
                        } else {
                            $('#parent_email').empty();
                            $('#parent_email').parent().hide();
                            $('#email').parent().show();
                        }
                    }
                } else {
                    if (s.parent_email !== 'false') {
                        $('#parent_email').empty().html(s.parent_email);
                        $('#parent_email').parent().show();
                        $('#email').parent().hide();
                    } else {
                        $('#parent_email').empty();
                        $('#parent_email').parent().hide();
                        $('#email').parent().show();
                    }
                }

                $('#profilepic').attr('src', BASEURL + 'classes/display_student_image/' + user_id);

                var class_id = t.parents('ul').data('classid');

                var studentData = {user_id: user_id, class_id: class_id};


                // here was model.getStudentStatReportingTable......
                model.getStudentStatIndividuallyChallengeReportingTable(studentData, function (r) {

                    $('#class_student_stats_table_wrapper').empty().html(r);

                    var datatable_settings = {
                        "sPaginationType": "full_numbers",
                        "bPaginate": true,
                        "bLengthChange": true,
                        "bFilter": false,
                        "bSort": true,
                        "bInfo": true,
                        "bAutoWidth": true,
                        bDestroy: true
                    };

                    $('#class_student_stats_table').dataTable(datatable_settings);

                });

                model.getReportStudentGlobalStatsByUserId(user_id, class_id, function (r) {
                    if (r.error) {
                        $('#column_chart_student_info').html('<p>' + r.error + '</p>');
                    } else {
                        do_chart(r, 'column_chart_student_info');
                    }
                });
            });

//                    }
            t.addClass('triggered');
        });

        $('.student_remove').unbind('click').click(function () {

            var t = $(this);
            var class_id = t.parents('ul').data('classid');
            var user_id = t.data('user-id');

            // remove student from class - teacher panel
            $('#removeStudentFromClass #student_btn_remove').unbind('click').click(function (e) {
                e.preventDefault();
                var data = {
                    class_id: class_id,
                    user_id: user_id
                };
                model.removeStudentFromClass(data, function (r) {
                    if (r.deleted === true) {
                        refresh_class_by_id(class_id);
                        $('#removeStudentFromClass').modal('hide');
                    }
                });
            });
        });
    });
}
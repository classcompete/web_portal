$(document).ready(function () {
    $.fn.modal.Constructor.prototype.enforceFocus = function () {
    };
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

    function clearQuestionPreviews() {
        $('.question, .answer').css('border', '1px solid black');
        $('.question').empty();

        $('#question_type_1 .answer').empty();
        $('#question_type_2 .answer').empty();
        $('#question_type_3 .answer').empty();

        $('#question_type_6 .answer').empty();
        $('#question_type_7 .answer').empty();
        $('#question_type_9 .answer').empty();

        $('#question_type_10 .answer').empty();
        $('#question_type_13 .answer').empty();
        $('#question_type_14 .answer').empty();
        $('#question_type_15 .answer').empty();
        $('#question_type_16 .answer').empty();

        $('.question_image img').removeAttr('src');
        $('.answer img').removeAttr('src');
    }

    // reset error indicators to default state
    function clearErrorIndicators() {
        $('.control-group').removeClass('error');
        $('.help-inline').empty();
    }

    function moveToTop() {
        $('html,body').animate({ scrollTop: 0 }, 400);
    }

    // reset error indicators to default state for edit forms
    $('.edit').unbind('click').click(function () {
        clearErrorIndicators();
    });

    /** subject ajax modal form */
    $(".mod-subject .edit").click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        model.getSubjectById(id, function (r) {
            $('#name').val(r.name);
            $('#edit_subject_id').val(r.id);
        });
    });

    $("#addNewSubject").click(function (e) {
        e.preventDefault();

        clearFormFields('#addEditSubject');
    });


    /** skill ajax modal form */

    $(".mod-skill .edit").click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        clearFormFields('#addEditSkill');
        $('#subject_id').html('<option value="" selected="selected" disabled="disabled">Select subject...</option>');


        model.getSkillById(id, function (r) {
            model.getSubjectsFromSkills(function (a) {
                $.each(a, function (key, value) {
                    if (r.subject_id === value.subject_id) {
                        $('#subject_id').append("<option value=" + value.subject_id + " selected='selected'>" + value.name + "</option>");
                    } else {
                        $('#subject_id').append("<option value=" + value.subject_id + ">" + value.name + "</option>");
                    }
                });
                $('#name').val(r.name);
                $('#edit_skill_id').val(r.id);
            });
        });
    });

    $("#addNewSkill").click(function (e) {
        e.preventDefault();

        clearFormFields('#addEditSkill');
        $('#subject_id').html('<option value="" selected="selected" disabled="disabled">Select subject...</option>');

        model.getSubjectsFromSkills(function (r) {
            $.each(r, function (key, value) {
                $('#subject_id').append("<option value=" + value.subject_id + ">" + value.name + "</option>");
            });
        });
    });

    /** admin ajax modal form */

    $(".mod-admin .edit").click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        model.getAdminById(id, function (r) {
            $('#username').val(r.username);
            $('#first_name').val(r.first_name);
            $('#last_name').val(r.last_name);
            $('#email').val(r.email);
            $('#edit_admin_id').val(r.id);
        });
    });

    $("#addNewAdmin").click(function (e) {
        e.preventDefault();

        clearFormFields('#addEditAdmin');
    });

    /** games ajax modal form */
    $(".mod-games .edit").click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        model.getGameById(id, function (r) {
            $('#name').val(r.name);
            $('#edit_game_id').val(r.id);
        });
    });

    $("#addNewGame").click(function (e) {
        //$('#edit_game_id').remove();
        e.preventDefault();

        clearFormFields('#addEditGame');
    });

    /** game levels ajax modal form */
    $(".mod-gamelevel .edit").click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        clearFormFields('#addEditGamelevel');
        $('#game_id').html('<option value="" selected="selected" disabled="disabled">Select game...</option>');

        model.getGameLevelById(id, function (r) {
            model.getGamesFromGameLevels(function (a) {
                $.each(a, function (key, value) {
                    if (r.game_id === value.game_id) {
                        $('#game_id').append("<option value=" + value.game_id + " selected='selected'>" + value.name + "</option>");
                    } else {
                        $('#game_id').append("<option value=" + value.game_id + ">" + value.name + "</option>");
                    }
                });
                $('#name').val(r.name);
                $('#edit_gamelevel_id').val(r.id);
            });
        });
    });

    $("#addNewGamelevel").click(function (e) {
        e.preventDefault();

        clearFormFields('#addEditGamelevel');
        $('#game_id').html('<option value="" selected="selected" disabled="disabled">Select game...</option>');
        model.getGamesFromGameLevels(function (r) {
            $.each(r, function (key, value) {
                $('#game_id').append("<option value=" + value.game_id + ">" + value.name + "</option>");
            });
        });
    });


    /** student ajax modal form */
    $(".mod-student .edit").click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        $('#dob_year').val($('#dob_year option:first').val());
        $('#dob_month').val($('#dob_month option:first').val());
        $('#dob_day').val($('#dob_day option:first').val());

        model.getUserById(id, function (r) {
            $('#username').val(r.username);
            $('#first_name').val(r.firstname);
            $('#last_name').val(r.lastname);
            $('#email').val(r.email);

            if (r.dob != null) {

                var dob = r.dob.split('/');

                var dob_year = dob[0];
                var dob_month = dob[1];
                var dob_day = dob[2];

                // ceck if we have valid date
                var today = new Date();
                var year = today.getFullYear();

                if (parseInt(year) - parseInt(dob_year) > 20) {
                    $('#dropdown_date').hide();
                    $('#text_date').show();
                    $('#t_dob_year').val(dob_year);
                    $('#t_dob_month').val(dob_month);
                    $('#t_dob_day').val(dob_day);
                } else {
                    $('#text_date').hide();
                    $('#dropdown_date').show();
                    $('#dob_year').val(dob_year);
                    $('#dob_month').val(dob_month);
                    $('#dob_day').val(dob_day);
                }

                if(isOldEnough(dob_year, dob_month, dob_day) === false){
                    $('#parent_email').parents('.control-group').slideDown();
                }else{
                    $('#parent_email').parents('.control-group').slideUp();
                }
            }

            $('#parent_email').val(r.parent_email);
            $('#edit_student_id').val(r.id);
            $("#image_link").attr('src', BASEURL + 'users/display_student_image/' + r.id);
            $("#image_link").show();
        });
    });

    $('#t_dob_year').unbind('keyup').keyup(function () {

        var tdob_year =  $('#t_dob_year').val();
        if(tdob_year.length < 4) return;
        var tdob_month =  $('#t_dob_month').val();
        var tdob_day =  $('#t_dob_day').val();

        if (isOldEnough(tdob_year, tdob_month, tdob_day) === false) {
            //less than 13 years old
            $('#parent_email').parents('.control-group').slideDown();
        } else {
            $('#parent_email').parents('.control-group').slideUp();
        }
    });

    $('#dob_year').unbind('change').change(function () {
        var dob_year = $(this).val();
        var dob_month = $('#dob_month').val();
        var dob_day = $('#dob_day').val();

        if (isOldEnough(dob_year, dob_month, dob_day) === false) {
            //less than 13 years old
            $('#parent_email').parents('.control-group').slideDown();
        } else {
            $('#parent_email').parents('.control-group').slideUp();
        }
    });

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

    $("#addNewStudent").click(function (e) {
        e.preventDefault();
        $('#image_link').hide();
        clearFormFields('#addEditUser');
        $('#text_date').hide();
        $('#user_type').val('student');
    });

    /** teacher ajax modal form */
    $(".mod-teacher .edit").click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        model.getUserById(id, function (r) {
            $('#username').val(r.username);
            $('#first_name').val(r.firstname);
            $('#last_name').val(r.lastname);
            $('#email').val(r.email);
            $('#edit_teacher_id').val(r.id);
            $.each(r.grades, function (key, val) {
                $('#' + val).attr('checked', 'checked');
            });
            $('#zip_code').val(r.zip_code);
            $('#school_name').val(r.school_name);
            if(r.isPublisher === 'public'){
                $('#publisher').attr('checked','checked');
            }
        });
    });

    $("#addNewTeacher").click(function (e) {
        e.preventDefault();

        clearFormFields('#addEditUser');
        $('#user_type').val('teacher');
    });

    $(".mod-teacher .profile_info").click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        model.getTeacherProfileData(id, function (r) {
            $('#t_username').val(r.username);
            $('#t_email').val(r.email);
            $('#t_first_name').val(r.firstname);
            $('#t_last_name').val(r.lastname);
            $('#t_school').val(r.school);
            $('#t_grade').val(r.grade);
        });
    });

    /** class ajax modal form */

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
                $('#licenses').val(r.licenses);
                if (r.licenses > 2) {
                    maxLicenses = parseInt($('#licenses').attr('data-max')) + r.licenses;
                } else {
                    maxLicenses = parseInt($('#licenses').attr('data-max'));
                }

                $('#licenses option').each(function(k, object){
                    if (parseInt($(object).attr('value')) <= maxLicenses) {
                        $(object).removeAttr('disabled');
                    }
                    if (parseInt($(object).attr('value')) == r.licenses) {
                        $(object).attr('selected', 'selected');
                    }
                });
            }
        });
    });

    $("#addNewClass").click(function (e) {
        e.preventDefault();

        clearFormFields('#addEditClass');
        $('#user_id').html('<option value="" selected="selected" disabled="disabled">Select teacher...</option>');

        if (subdomain_name === 'admin') {
            model.getTeachersFromClasses(function (r) {
                $.each(r, function (key, value) {
                    $('#user_id').append("<option value=" + value.user_id + ">" + value.first_name + ' ' + value.last_name + "</option>");
                });
            });

            model.getNewClassCode(function (r) {
                $("#auth_code").val(r);
                $("#limit").val('2');
                $("#price").val('0');
            });
        }
    });

    $("#addNewClassTeacher").click(function (e) {
        e.preventDefault();
        clearFormFields('#addEditClassTeacher');

        model.getNewClassCode(function (r) {
            $("#auth_code").val(r);
            $("#limit").val('2');
            $("#price").val('0');
            maxLicenses = parseInt($('#licenses').attr('data-max'));
            $('#licenses option').each(function(k, object){
                if (parseInt($(object).attr('value')) <= maxLicenses) {
                    $(object).removeAttr('disabled');
                }
            });
        });
    });

        // Import Students button on Classroom tab
    $(".btn-import-students-file").click(function (e) {
        e.preventDefault();
        var xClassId = parseInt($(this).data('classId'));
        clearFormFields('#student_import_form');
        $('#stud_import_class_id').val(xClassId);

        model.getClassById(xClassId, function (res) {
            $('#dlgImportStudents span.import-class-name').text(res.name);
            //$('#licenses').val(res.licenses);
        });
    });

    /** class submit validation */
    if (subdomain_name !== 'admin') {
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
                    if (r.licenses) {
                        $('#licenses').parents('.control-group').addClass('error');
                        $('#licenses').siblings('.help-inline').html(r.licenses);
                    }
                } else {
                    $('#class_form').submit();
                }
            });
        });
    }

    /** class student */

    $('#addClassStudent').click(function (e) {
        e.preventDefault();

        clearFormFields('#addEditClassStudent');

        $('#dl_class_id').html('<option value="" selected="selected" disabled="disabled">Select class...</option>');
        $('#dl_student_id').html('<option value="" selected="selected" disabled="disabled">Select student...</option>');
        $('#dl_student_id').attr('disabled', 'disabled');
        model.getClassFromClassStudent(function (r) {
            $.each(r, function (key, value) {
                $('#dl_class_id').append("<option value=" + value.class_id + ">" + value.class_name + "</option>");
            });
        });
    });
    /** get and fill students dropdown*/
    $('#dl_class_id').change(function () {
        $('#dl_student_id').html('<option value="" selected="selected" disabled="disabled">Select student...</option>');
        $('#dl_student_id').removeAttr('disabled');
        var class_id = $(this).val();

        model.getExcludedStudentsFromClassByClassId(class_id, function (r) {
            $.each(r, function (key, value) {
                $('#dl_student_id').append("<option value=" + value.user_id + ">" + value.first_name + ' ' + value.last_name + "</option>");
            });
        });
    });

    /** class student edit */
    $('.mod-class-student .edit').unbind('click').click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        clearDropDownBoxAll('#addEditClassStudent');
        clearFormFields('#addEditClassStudent');

        $('#dl_class_id').html('<option selected="selected" disabled="disabled">Select class...</option>');
        $('#dl_student_id').html('<option selected="selected" disabled="disabled">Select student...</option>');

        model.getClassStudentById(id, function (r) {
            $('#edit_classstud_id').val(r.id);
            model.getClassFromClassStudent(function (c) {
                $.each(c, function (k, v) {
                    if (parseInt(r.class_id) === parseInt(v.class_id)) {
                        $('#dl_class_id').append("<option value=" + v.class_id + " selected='selected'>" + v.class_name + "</option>");
                    } else {
                        $('#dl_class_id').append("<option value=" + v.class_id + ">" + v.class_name + "</option>");
                    }
                });
            });


            model.getStudentsByClassId($('#dl_class_id').val(), function (s) {
                $.each(s, function (k, v) {
                    if (parseInt(r.student_id) === parseInt(v.student_id)) {
                        $('#dl_student_id').append("<option value=" + v.student_id + "  selected='selected'>" + v.first_name + ' ' + v.last_name + "</option>");
                    } else {
                        $('#dl_student_id').append("<option value=" + v.student_id + ">" + v.first_name + ' ' + v.last_name + "</option>");
                    }
                });
            });
        });

    });

    /** class student submit validation */
    if (subdomain_name !== 'admin') {
        $('#class_student_form_submit').unbind('click').click(function (e) {
            e.preventDefault();

            var data = $('#class_student_form').serialize();

            model.validateClassStudent(data, function (r) {
                if (r.validation !== true) {
                    if (r.class_id) {
                        $('#dl_class_id').parents('.control-group').addClass('error');
                        $('#dl_class_id').siblings('.help-inline').html(r.class_id);
                    }
                    if (r.user_id) {
                        $('#dl_student_id').parents('.control-group').addClass('error');
                        $('#dl_student_id').siblings('.help-inline').html(r.user_id);
                    }
                } else {
                    $('#class_student_form').submit();
                }
            });
        });
    }

    /** add challenge */

    $('#addNewChallenge').click(function (e) {
        e.preventDefault();
        clearDropDownBoxAll('#addEditChallenge');
        clearFormFields('#addEditChallenge');

        // make sure you are on first tab of wizard
        $('#inverse').bootstrapWizard('show', 0);
        $('.save').hide();
        $('.nextnext').show();

        // because of plupload enter key is disabled for these inputs
        $('#challenge_name').disableEnter();
        //$('#level').disableEnter();
        $('#inverse-tab3').disableEnter();

        // description character limit

        var elem = $("#chars");
        $('#description').limiter(description_limter, elem);
        $('#read_text').limiter(description_limter, $('#read_chars'));

        $('#class_id').html('<option value="0" selected="selected" disabled="disabled">Select class...</option>');
        $('#level').html('' +
            '<option value="-2">Pre k</option>' +
            '<option value="-1">K</option>' +
            '<option value="1">1</option>' +
            '<option value="2">2</option>' +
            '<option value="3">3</option>' +
            '<option value="4">4</option>' +
            '<option value="5">5</option>' +
            '<option value="6">6</option>' +
            '<option value="7">7</option>' +
            '<option value="8">8</option>' +
            '<option value="9">High School</option>').val([]);

        // scroll to top because modal is not position fixed
        moveToTop();

        $('#dl_subject_id').append('<option value="" selected="selected" disabled="disabled">Select subject...</option>');
        $('#dl_skill_id').append('<option value="" selected="selected" disabled="disabled">Select skill...</option>');
        $('#dl_game_id').append('<option value="" selected="selected" disabled="disabled">Select game...</option>');
        $('#dl_game_level_id').append('<option value="" selected="selected" disabled="disabled">Select game level...</option>');

        model.getSubjectsFromChallenge(function (r) {
            $.each(r, function (key, value) {
                $('#dl_subject_id').append("<option value=" + value.subject_id + ">" + value.name + "</option>");
            });
        });

        model.getGamesFromChallenge(function (r) {
            $.each(r, function (key, value) {
                $('#dl_game_id').append("<option value=" + value.game_id + ">" + value.name + "</option>");
            });
        });

    });

    $('#dl_subject_id').change(function (e) {
        e.preventDefault();
        clearDropDownBoxSpec('#dl_skill_id');
        $('#dl_skill_id').append('<option value="" selected="selected" disabled="disabled">Select skill...</option>');
        var skill_id = $(this).find('option:selected').attr('value');

        model.getSkillBySkillIdFromChallenge(skill_id, function (r) {
            $.each(r, function (key, value) {
                $('#dl_skill_id').append("<option value=" + value.skill_id + ">" + value.name + "</option>");
            });
            $('#dl_skill_id').removeAttr('disabled');
            $('#dl_topic_id').html('<option selected="selected">Select subtopic...</option>');
            $('#dl_topic_id').attr('disabled', 'disabled');
        });
    });
    $('#dl_skill_id').change(function (e) {
        e.preventDefault();
        clearDropDownBoxSpec('#dl_topic_id');
        $('#dl_topic_id').append('<option value="" selected="selected" disabled="disabled">Select subtopic...</option>');
        var skill_id = $(this).find('option:selected').attr('value');
        model.getTopicBySkillIdFromChallengeBuilder(skill_id, function (r) {
            $.each(r, function (key, value) {
                $('#dl_topic_id').append("<option value=" + value.topic_id + " title='" + value.name + "'>" + value.name + "</option>");
            });
            $('#dl_topic_id').removeAttr('disabled');
        });
    });
    $('#dl_game_id').change(function (e) {
        e.preventDefault();
        clearDropDownBoxSpec('#dl_game_level_id');
        $('#dl_game_level_id').append('<option value="" selected="selected" disabled="disabled">Select game level...</option>');
        var game_id = $(this).find('option:selected').attr('value');

        model.getGameLevelByGameIdFromChallenge(game_id, function (r) {
            $.each(r, function (key, value) {
                $('#dl_game_level_id').append("<option value=" + value.game_level_id + ">" + value.name + "</option>");
            });
            $('#dl_game_level_id').removeAttr('disabled');
        });
    });

    // edit challenge dropdown change
    $('#editChallenge #subject_id_edit').change(function (e) {
        e.preventDefault();
        clearDropDownBoxSpec('#skill_id_edit');
        $('#skill_id_edit').append('<option value="" selected="selected" disabled="disabled">Select skill...</option>');
        var skill_id = $(this).find('option:selected').attr('value');

        model.getSkillBySkillIdFromChallenge(skill_id, function (r) {
            $.each(r, function (key, value) {
                $('#skill_id_edit').append("<option value=" + value.skill_id + ">" + value.name + "</option>");
            });
            $('#skill_id_edit').removeAttr('disabled');
            $('#topic_id_edit').html('<option selected="selected">Select subtopic...</option>');
            $('#topic_id_edit').attr('disabled', 'disabled');
        });
    });

    $('#editChallenge #skill_id_edit').change(function (e) {
        e.preventDefault();
        clearDropDownBoxSpec('#topic_id_edit');
        $('#topic_id_edit').append('<option value="" selected="selected" disabled="disabled">Select subtopic...</option>');
        var skill_id = $(this).find('option:selected').attr('value');
        model.getTopicBySkillIdFromChallengeBuilder(skill_id, function (r) {
            $.each(r, function (key, value) {
                $('#topic_id_edit').append("<option value=" + value.topic_id + ">" + value.name + "</option>");
            });
            $('#topic_id_edit').removeAttr('disabled');
        });
    });

    $('#editChallenge #game_id_edit').change(function (e) {
        e.preventDefault();
        clearDropDownBoxSpec('#game_level_id_edit');
        $('#game_level_id_edit').append('<option value="" selected="selected" disabled="disabled">Select game level...</option>');
        var game_id = $(this).find('option:selected').attr('value');

        model.getGameLevelByGameIdFromChallenge(game_id, function (r) {
            $.each(r, function (key, value) {
                $('#game_level_id_edit').append("<option value=" + value.game_level_id + ">" + value.name + "</option>");
            });
            $('#game_level_id_edit').removeAttr('disabled');
        });
    });

    // my challenges edit form 
    $('#addEditChallenge #subject_id_edit').change(function (e) {
        e.preventDefault();
        clearDropDownBoxSpec('#skill_id_edit');
        $('#skill_id_edit').append('<option value="" selected="selected" disabled="disabled">Select skill...</option>');
        var skill_id = $(this).find('option:selected').attr('value');

        model.getSkillBySkillIdFromChallenge(skill_id, function (r) {
            $.each(r, function (key, value) {
                $('#skill_id_edit').append("<option value=" + value.skill_id + ">" + value.name + "</option>");
            });
            $('#skill_id_edit').removeAttr('disabled');
            $('#topic_id_edit').html('<option selected="selected">Select subtopic...</option>');
            $('#topic_id_edit').attr('disabled', 'disabled');
        });
    });

    $('#addEditChallenge #skill_id_edit').change(function (e) {
        e.preventDefault();
        clearDropDownBoxSpec('#topic_id_edit');
        $('#topic_id_edit').append('<option value="" selected="selected" disabled="disabled">Select subtopic...</option>');
        var skill_id = $(this).find('option:selected').attr('value');
        model.getTopicBySkillIdFromChallengeBuilder(skill_id, function (r) {
            $.each(r, function (key, value) {
                $('#topic_id_edit').append("<option value=" + value.topic_id + ">" + value.name + "</option>");
            });
            $('#topic_id_edit').removeAttr('disabled');
        });
    });


    // edit challenge
    $(".mod-challenge .edit").click(function (e) {
        var challenge_choice_image_url = BASEURL + 'challenge/display_choice_image/';
        e.preventDefault();

//        var url = $(this).attr('href').split('#');
//        var id = url[1].split('/');
//        id = id[2];
        var id = $(this).data('id');

        clearDropDownBoxAll('#editChallenge');
        clearFormFields('#editChallenge');
        clearDropDownBoxAll('#addEditChallenge');
        clearFormFields('#addEditChallenge');
        $('#topic_id_edit').removeAttr('disabled');

        $('#level_edit').html('' +
            '<option value="-2">Pre k</option>' +
            '<option value="-1">k</option>' +
            '<option value="1">1</option>' +
            '<option value="2">2</option>' +
            '<option value="3">3</option>' +
            '<option value="4">4</option>' +
            '<option value="5">5</option>' +
            '<option value="6">6</option>' +
            '<option value="7">7</option>' +
            '<option value="8">8</option>' +
            '<option value="9">High School</option>');

        // scroll to top because modal is not position fixed
        moveToTop();


        // because we use same form on 2 pages, this will be parameter for redirection back to that page
        var my_challenges_redirection = $(this).data('mychallenges');

        if (my_challenges_redirection === true) {
            $('#my_challenges_redirection').val('true');
        }

        model.getChallengeById(id, function (r) {

            $('#description_edit').val(r.description);

            $('#challenge_name_edit').val(r.name);
            $('#read_title_edit').val(r.read_title);
            $('#read_text_edit').val(r.read_text);

            if (r.read_title) {
                $('#is_read_passage_edit').attr('checked','checked');
                $('#read_passage_box').show();
                $('#read_image_preview_edit .img_to_upload').attr('src', challenge_choice_image_url + r.challenge_id);
                $('#read_image_preview_edit .img_to_upload').show();
            } else {
                $('#is_read_passage_edit').removeAttr('checked');
                $('#read_passage_box').hide();
            }

            $('#is_read_passage_edit').change(function(){
                if ($('#is_read_passage_edit').is(':checked')){
                    $('#read_passage_box').show();
                } else {
                    $('#read_passage_box').hide();
                }
            });

            if (r.is_public === "1") {
                $('#is_public').attr('checked', 'checked');
            } else {
                $('#is_public').removeAttr('checked');
            }
            var elem = $("#chars_edit");
            $('#description_edit').limiter(description_limter, elem);

            model.getSubjectsFromChallenge(function (a) {
                $.each(a, function (key, value) {
                    if (parseInt(r.subject_id) === parseInt(value.subject_id)) {
                        $('#subject_id_edit').append("<option value=" + value.subject_id + " selected='selected'>" + value.name + "</option>");
                    } else {
                        $('#subject_id_edit').append("<option value=" + value.subject_id + ">" + value.name + "</option>");
                    }
                });
            });

            model.getSkillByIdFromChallenge(r.subject_id, function (a) {
                $('#skill_id_edit').removeAttr('disabled');
                $.each(a, function (key, value) {
                    if (parseInt(r.skill_id) === parseInt(value.skill_id)) {
                        $('#skill_id_edit').append("<option value=" + value.skill_id + " selected='selected'>" + value.name + "</option>");
                    } else {
                        $('#skill_id_edit').append("<option value=" + value.skill_id + ">" + value.name + "</option>");
                    }
                });
            });

            model.getTopicBySkillIdFromChallengeBuilder(r.skill_id, function (t) {
                $.each(t, function (key, value) {
                    if (parseInt(r.topic_id) === parseInt(value.topic_id)) {
                        $('#topic_id_edit').append("<option value=" + value.topic_id + " selected='selected' title='" + value.name + "'>" + value.name + "</option>");
                    } else {
                        $('#topic_id_edit').append("<option value=" + value.topic_id + " title='" + value.name + "'>" + value.name + "</option>");
                    }
                });
                $('.add_title').dd_add_title();
            });

            $("#level_edit").val(r.level);

            model.getGamesFromChallenge(function (a) {
                $.each(a, function (key, value) {
                    if (parseInt(r.game_id) === parseInt(value.game_id)) {
                        $('#game_id_edit').append("<option value=" + value.game_id + " selected='selected'>" + value.name + "</option>");
                    } else {
                        $('#game_id_edit').append("<option value=" + value.game_id + ">" + value.name + "</option>");
                    }
                });
            });

            model.getGameLevelByIdFromChallenge(r.game_id, function (a) {
                $('#game_level_id_edit').removeAttr('disabled');
                $.each(a, function (key, value) {
                    if (parseInt(r.gamelevel_id) === parseInt(value.game_level_id)) {
                        $('#game_level_id_edit').append("<option value=" + value.game_level_id + " selected='selected'>" + value.name + "</option>");
                    } else {
                        $('#game_level_id_edit').append("<option value=" + value.game_level_id + ">" + value.name + "</option>");
                    }
                });
            });

            $('#edit_challenge_id_edit').val(r.challenge_id);
        });
    });

    /** challenge submit validation */
    if (subdomain_name !== 'admin') {
        $('#challenge_form_submit').unbind('click').click(function (e) {
            e.preventDefault();

            $('.error').removeClass('error');
            $('.help-inline').empty();

            var data = $('#challenge_form_edit').serialize();

            model.validateChallengeBuilder(data, function (r) {
                if (r.validation !== true) {
                    if (r.challenge_name) {
                        $('#challenge_name_edit').parents('.control-group').addClass('error');
                        $('#challenge_name_edit').siblings('.help-inline').html(r.challenge_name);
                    }
                    if (r.subject_id) {
                        $('#subject_id_edit').parents('.control-group').addClass('error');
                        $('#subject_id_edit').siblings('.help-inline').html(r.subject_id);
                    }
                    if (r.skill_id) {
                        $('#skill_id_edit').parents('.control-group').addClass('error');
                        $('#skill_id_edit').siblings('.help-inline').html(r.skill_id);
                    }
                    if (r.topic_id) {
                        $('#topic_id_edit').parents('.control-group').addClass('error');
                        $('#topic_id_edit').siblings('.help-inline').html(r.topic_id);
                    }
                    if (r.level) {
                        $('#level_edit').parents('.control-group').addClass('error');
                        $('#level_edit').siblings('.help-inline').html(r.level);
                    }
                    if (r.game_id) {
                        $('#game_id_edit').parents('.control-group').addClass('error');
                        $('#game_id_edit').siblings('.help-inline').html(r.game_id);
                    }
                    if (r.game_level_id) {
                        $('#game_level_id_edit').parents('.control-group').addClass('error');
                        $('#game_level_id_edit').siblings('.help-inline').html(r.game_level_id);
                    }
                } else {
//                    
                    $('#challenge_form_edit').submit();
                }
            });
        });
    }


    /**
     * challenge_classes
     * */
    $('#addNewChallengeClass').click(function (e) {
        e.preventDefault();
        clearDropDownBoxAll('#addEditChallengeClass');
        clearFormFields('#addEditChallengeClass');
        $('#dl_challenge_id').append('<option value="" selected="selected" disabled="disabled">Select challenge...</option>');
        $('#dl_challenge_class_id').append('<option value="" selected="selected" disabled="disabled">Select class...</option>');


        model.getChallengesFromChallengeClass(function (r) {
            $.each(r, function (key, value) {
                $('#dl_challenge_id').append("<option value=" + value.challenge_id + ">" + value.name + "</option>");
            });
        });


        model.getChallengeClassFromChallengeClass(function (r) {
            $.each(r, function (key, value) {
                $('#dl_challenge_class_id').append("<option value=" + value.class_id + ">" + value.name + "</option>");
            });
        });

    });

    $(".mod-challenge-class .edit").click(function (e) {
        e.preventDefault();

        var data = null;
        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];
        clearDropDownBoxAll('#addEditChallengeClass');
        clearFormFields('#addEditChallengeClass');

        model.getChallengeByIdFromChallengeClass(id, function (r) {
            data = r;
            model.getChallengesFromChallengeClass(function (a) {
                $.each(a, function (key, value) {
                    if (parseInt(data.challenge_id) === parseInt(value.challenge_id)) {
                        $('#dl_challenge_id').append("<option value=" + value.challenge_id + " selected='selected'>" + value.name + "</option>");
                    } else {
                        $('#dl_challenge_id').append("<option value=" + value.challenge_id + ">" + value.name + "</option>");
                    }
                });
            });
            model.getChallengeClassFromChallengeClass(function (a) {
                $.each(a, function (key, value) {
                    if (parseInt(data.class_id) === parseInt(value.class_id)) {
                        $('#dl_challenge_class_id').append("<option value=" + value.class_id + " selected='selected'>" + value.name + "</option>");
                    } else {
                        $('#dl_challenge_class_id').append("<option value=" + value.class_id + ">" + value.name + "</option>");
                    }
                });
            });
            $('#edit_challenge_class_id').val(data.challclass_id);
        });
    });

    /** challenge class submit validation */
    if (subdomain_name !== 'admin') {
        $('#challenge_class_form_submit').unbind('click').click(function (e) {
            e.preventDefault();

            var data = $('#challenge_class_form').serialize();

            model.validateChallengeClass(data, function (r) {
                if (r.validation !== true) {
                    if (r.challenge_id) {
                        $('#dl_challenge_id').parents('.control-group').addClass('error');
                        $('#dl_challenge_id').siblings('.help-inline').html(r.challenge_id);
                    }
                    if (r.class_id) {
                        $('#dl_challenge_class_id').parents('.control-group').addClass('error');
                        $('#dl_challenge_class_id').siblings('.help-inline').html(r.class_id);
                    }
                } else {
                    $('#challenge_class_form').submit();
                }
            });
        });
    }


    /**
     *  Questions
     * */

    $('#addNewQuestion').unbind('click').click(function (e) {
        e.preventDefault();

        fadeOutAllTypes('fast');
        fadeOutMultipleChoices('fast');
        $('#multiple_choice').attr('disabled', false);

        $('#type_holder').show();

        clearDropDownBoxAll('#addEditQuestion');
        clearFormFields('#addEditQuestion');
        $('#type_id').html('<option selected="selected" disabled="disabled">Select type...</option>');
        $('#dl_question_subject_id').html('<option selected="selected" disabled="disabled">Select subject...</option>');

        model.getSubjects(function (r) {
            $.each(r, function (k, v) {
                $('#dl_question_subject_id').append("<option value=" + v.subject_id + ">" + v.name + "</option>");
            });
        });

        model.getQuestionTypeList(function (r) {
            $.each(r, function (k, v) {
                $('#type_id').append("<option value=" + v + ">" + v + "</option>");
            });
            $('#type_id').attr('disabled', false);
        });

        $('#type_id').unbind('change').change(function () {

            fadeOutAllTypes('fast');
            fadeOutMultipleChoices('fast');
            switch ($(this).val()) {
                case 'multiple_choice':

                    $('#multiple_choice').html('<option selected="selected" disabled="disabled">Select choice...</option>');
                    model.getMultipleChoiceList(function (r) {
                        $.each(r, function (k, v) {
                            $('#multiple_choice').append("<option value=" + v + ">" + v + "</option>");
                        });
                        $('.question_type_multiple_choice').fadeIn();
                    });
                    break;
                case ('text'):
                    $('#correct_text').fadeIn();

                    break;
                case ('order_slider'):
                    $('#order_slider').fadeIn();
                    break;
                case ('calculator'):

                    $('#correct_calculation').fadeIn();
                    break;
                default:

            }
        });

        $('#dl_question_subject_id').unbind('change').change(function (e) {

            var subject_id = $(this).val();
            clearDropDownBoxSpec("#dl_question_skill_id");
            $('#dl_question_skill_id').append('<option value="" selected="selected" disabled="disabled">Select skill...</option>');

            model.getSkillBySubjectId(subject_id, function (r) {
                $.each(r, function (key, value) {
                    $('#dl_question_skill_id').append("<option value=" + value.skill_id + '>' + value.skill_name + '</option>');
                });
                $('#dl_question_skill_id').removeAttr('disabled');
            });
        });


        $('#multiple_choice').unbind('change').change(function () {
            fadeOutMultipleChoices('fast');
            switch ($(this).val()) {
                case 'true/false':
                    $('#true_false').fadeIn();
                    break;
                case '4_quest':
                    $('#dl_4_quest').fadeIn();
                    break;
                case '8_quest':
                    $('#dl_8_quest').fadeIn();
                    break;
                default:
            }
        });

        var order_slider_counter = 1;

        $('#order_slider_add').unbind('click').click(function (e) {
            e.preventDefault();

            order_slider_counter++;

            var html = '<div id="order_slider_answer' + order_slider_counter + '"><div class="control-group">' +
                '<label class="control-label">Answer ' + order_slider_counter + '</label><div class="controls">' +
                '<input type="text" name="order_slider[' + order_slider_counter + ']"/>' +
                '<label><input type="file" name="order_slider_image[' + order_slider_counter + ']"/></label></div></div></div>';

            $('#order_slider_answer_holder').append(html);
        });

        $('#order_slider_remove').unbind('click').click(function (e) {
            e.preventDefault();

            if (order_slider_counter > 1) {
                $('#order_slider_answer' + order_slider_counter).remove();
                order_slider_counter--;
            }
        });

    });

    function fadeOutAllTypes(speed) {
        speed = "'" + speed + "'";
        $('.question_type_multiple_choice').fadeOut(speed);
        $('#order_slider_answer_holder').empty();
        order_slider_counter = 1;
    }

    function fadeOutMultipleChoices(speed) {
        speed = "'" + speed + "'";
        $('.dl_question').fadeOut(speed);
        $('#correct_text').fadeOut(speed);
        $('#correct_calculation').fadeOut(speed);
        $('#true_false').fadeOut(speed);
        $('#order_slider').fadeOut(speed);
    }

    /**
     *  question edit
     * */

    $('.mod-question .edit').unbind('click').click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        fadeOutAllTypes('fast');
        fadeOutMultipleChoices('fast');

        $('#type_id').html('<option selected="selected" disabled="disabled">Select type...</option>');
        $('#dl_question_subject_id').html('<option selected="selected" disabled="disabled">Select subject...</option>');

        model.getQuestionById(id, function (r) {

            model.getSubjects(function (s) {
                $.each(s, function (k, v) {
                    if (parseInt(r.subject_id) === parseInt(v.subject_id)) {
                        $('#dl_question_subject_id').append("<option value=" + v.subject_id + " selected='selected'>" + v.name + "</option>");
                    } else {
                        $('#dl_question_subject_id').append("<option value=" + v.subject_id + ">" + v.name + "</option>");
                    }
                });
            });

            model.getSkillBySubjectId(r.subject_id, function (skill) {
                $.each(skill, function (k, v) {
                    if (parseInt(r.skill_id) === parseInt(v.skill_id)) {
                        $('#dl_question_skill_id').append("<option value=" + v.skill_id + " selected='selected'>" + v.skill_name + "</option>");
                    } else {
                        $('#dl_question_skill_id').append("<option value=" + v.skill_id + '>' + v.skill_name + '</option>');
                    }
                });
                $('#dl_question_skill_id').removeAttr('disabled');
            });

            $('#dl_question_subject_id').unbind('change').change(function (e) {

                var subject_id = $(this).val();
                clearDropDownBoxSpec("#dl_question_skill_id");
                $('#dl_question_skill_id').append('<option value="" selected="selected" disabled="disabled">Select skill...</option>');

                model.getSkillBySubjectId(subject_id, function (skill) {
                    $.each(skill, function (key, value) {
                        $('#dl_question_skill_id').append("<option value=" + value.skill_id + '>' + value.skill_name + '</option>');
                    });
                    $('#dl_question_skill_id').removeAttr('disabled');
                });
            });

            $('#level').val(r.level);
            $('#text').val(r.text);
            $('#edit_question_id').val(r.question_id);

            model.getQuestionTypeList(function (q) {
                $.each(q, function (k, v) {
                    if (r.type === v) {
                        $('#type_id').append("<option value=" + v + " selected='selected'>" + v + "</option>");
                    } else {
                        $('#type_id').append("<option value=" + v + ">" + v + "</option>");
                    }
                });
                //$('#type_id').attr('disabled', true);
            });

            var correct_text = r.correct_text;

            switch (r.type) {
                case 'multiple_choice':
                    $('#multiple_choice').html('<option selected="selected" disabled="disabled">Select choice...</option>');
                    model.getMultipleChoiceList(function (c) {
                        $.each(c, function (k, v) {
                            $('#multiple_choice').append("<option value=" + v + ">" + v + "</option>");
                        });
                        //$('#multiple_choice').attr('disabled', true);
                        var correct_answer_position = $.inArray(r.correct_choice_text, r.question_answers) + 1;

                        if (correct_text === 'true' || correct_text === 'false') {
                            $('#multiple_choice option[value="true/false"]').attr('selected', 'selected');

                            $('#answer_' + correct_text).attr('checked', true);

                            $('#true_false').fadeIn();
                        } else if (r.no_of_choices === 4) {
                            $('#multiple_choice option[value="4_quest"]').attr('selected', 'selected');
                            $('#four_answer_1').val(r.question_answers[0]);
                            $('#four_answer_2').val(r.question_answers[1]);
                            $('#four_answer_3').val(r.question_answers[2]);
                            $('#four_answer_4').val(r.question_answers[3]);

                            $('#correct_four_answer_' + correct_answer_position).attr('checked', true);

                            $('#dl_4_quest').fadeIn();
                        } else if (r.no_of_choices === 8) {
                            $('#multiple_choice option[value="8_quest"]').attr('selected', 'selected');

                            $('#eight_answer_1').val(r.question_answers[0]);
                            $('#eight_answer_2').val(r.question_answers[1]);
                            $('#eight_answer_3').val(r.question_answers[2]);
                            $('#eight_answer_4').val(r.question_answers[3]);
                            $('#eight_answer_5').val(r.question_answers[4]);
                            $('#eight_answer_6').val(r.question_answers[5]);
                            $('#eight_answer_7').val(r.question_answers[6]);
                            $('#eight_answer_8').val(r.question_answers[7]);

                            $('#correct_eight_answer_' + correct_answer_position).attr('checked', true);

                            $('#dl_8_quest').fadeIn();
                        }

                        //$('.question_type_multiple_choice').show();
                    });
                    break;
                case 'order_slider':

                    $('#order_slider_1').val(r.question_answers[0]);

                    for (i = 1; i < r.no_of_choices; i++) {
                        var no = parseInt(i) + 1;
                        var html = '<div id="order_slider_answer' + no + '"><div class="control-group">' +
                            '<label class="control-label">Answer ' + no + '</label><div class="controls">' +
                            '<input type="text" id="order_slider_' + no + '" name="order_slider[' + no + ']"/>' +
                            '<label><input type="file" name="order_slider_image[' + no + ']"/></label></div></div></div>';

                        $('#order_slider_answer_holder').append(html);

                        $('#order_slider_' + no).val(r.question_answers[no - 1]);
                    }

                    var order_slider_counter = parseInt(r.no_of_choices);

                    $('#order_slider_add').unbind('click').click(function (e) {
                        e.preventDefault();

                        order_slider_counter++;

                        var html = '<div id="order_slider_answer' + order_slider_counter + '"><div class="control-group">' +
                            '<label class="control-label">Answer ' + order_slider_counter + '</label><div class="controls">' +
                            '<input type="text" name="order_slider[' + order_slider_counter + ']"/>' +
                            '<label><input type="file" name="order_slider_image[' + order_slider_counter + ']"/></label>' +
                            '</div></div></div>';

                        $('#order_slider_answer_holder').append(html);
                    });

                    $('#order_slider_remove').unbind('click').click(function (e) {
                        e.preventDefault();

                        if (order_slider_counter > 1) {
                            $('#order_slider_answer' + order_slider_counter).remove();
                            order_slider_counter--;
                        }
                    });

                    var list = r.correct_text.split(',');
                    var temp = [];
                    $.each(list, function (key, value) {
                        temp.push({k: key + 1, v: value});
                    });

                    temp.sort(function (a, b) {
                        return a.v - b.v;
                    });

                    var order_slider_correct = [];
                    $.each(temp, function (key, val) {
                        order_slider_correct.push(val.k);
                    });

                    order_slider_correct = order_slider_correct.toString();
                    $('#order_slider_correct').val(order_slider_correct);

                    $('#order_slider').fadeIn();
                    break;
                case 'calculator':
                    $('#calculator_correct_text').val(correct_text);
                    $('#correct_calculation').fadeIn();
                    break;
                case 'text':
                    $('#correct_answer_text').val(correct_text);
                    $('#correct_text').fadeIn();
                    break;
                default:
                    $('#multiple_choice').attr('disabled', false);
                    $('.question_type_multiple_choice').hide();
            }


            $('#multiple_choice').unbind('change').change(function () {
                fadeOutMultipleChoices('fast');
                switch ($(this).val()) {
                    case 'true/false':
                        $('#true_false').fadeIn();
                        break;
                    case '4_quest':
                        $('#dl_4_quest').fadeIn();
                        break;
                    case '8_quest':
                        $('#dl_8_quest').fadeIn();
                        break;
                    default:
                }
            });

        });

        $('#multiple_choice_holder').css("display", "none");
        $('#type_holder').css("display", "none");

    });

    $('#addNewConnection').unbind('click').click(function (e) {
        e.preventDefault();

        clearDropDownBoxAll('#addEditConnection');
        clearFormFields('#addEditConnection');

        $('#to_user_id').attr('disabled', true);
        $('#edit_connection_id').val('');

        model.getAllUsersConnections(function (u) {
            $('#from_user_id').html('<option selected="selected" disabled="disabled">Select user...</option>');
            $('#to_user_id').html('<option selected="selected" disabled="disabled">Select user...</option>');

            $.each(u, function (k, v) {
                $('#from_user_id').append("<option value=" + v.user_id + ">" + v.first_name + ' ' + v.last_name + "</option>");
            });
        });

        $('#from_user_id').unbind('change').change(function () {
            $('#to_user_id').html('<option selected="selected" disabled="disabled">Select user...</option>');
            var user_id = $(this).val();

            model.getExcludedUsersConnections(user_id, function (ue) {
                $.each(ue, function (k, v) {
                    $('#to_user_id').append("<option value=" + v.user_id + ">" + v.first_name + ' ' + v.last_name + "</option>");
                });
                $('#to_user_id').attr('disabled', false);
            });
        });

        model.getStatusConnections(function (s) {
            $('#status').html('<option selected="selected" disabled="disabled">Select status...</option>');
            $.each(s, function (k, v) {
                $('#status').append("<option value=" + v + ">" + v + "</option>");
            });
        });
    });

    $('.mod-connection .edit').unbind('click').click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        $('#to_user_id').attr('disabled', false);

        model.getConnectionById(id, function (r) {
            $('#edit_connection_id').val(r.id);

            model.getAllUsersConnections(function (u) {
                $('#from_user_id').html('<option selected="selected" disabled="disabled">Select user...</option>');

                $.each(u, function (k, v) {
                    if (parseInt(r.from_user_id) === parseInt(v.user_id)) {
                        $('#from_user_id').append("<option value=" + v.user_id + " selected='selected'>" + v.first_name + ' ' + v.last_name + "</option>");
                    } else {
                        $('#from_user_id').append("<option value=" + v.user_id + ">" + v.first_name + ' ' + v.last_name + "</option>");
                    }
                });

                $('#to_user_id').html('<option selected="selected" disabled="disabled">Select user...</option>');
                var user_id = $('#from_user_id').val();

                model.getExcludedUsersConnections(user_id, function (ue) {
                    $.each(ue, function (k, v) {
                        if (parseInt(r.to_user_id) === parseInt(v.user_id)) {
                            $('#to_user_id').append("<option value=" + v.user_id + " selected='selected'>" + v.first_name + ' ' + v.last_name + "</option>");
                        } else {
                            $('#to_user_id').append("<option value=" + v.user_id + ">" + v.first_name + ' ' + v.last_name + "</option>");
                        }
                    });
                });
            });

            $('#from_user_id').unbind('change').change(function () {
                $('#to_user_id').html('<option selected="selected" disabled="disabled">Select user...</option>');
                var user_id = $(this).val();

                model.getExcludedUsersConnections(user_id, function (ue) {
                    $.each(ue, function (k, v) {
                        if (parseInt(r.to_user_id) === parseInt(v.user_id)) {
                            $('#to_user_id').append("<option value=" + v.user_id + " selected='selected'>" + v.first_name + ' ' + v.last_name + "</option>");
                        } else {
                            $('#to_user_id').append("<option value=" + v.user_id + ">" + v.first_name + ' ' + v.last_name + "</option>");
                        }
                    });
                });
            });

            model.getStatusConnections(function (s) {
                $('#status').html('<option selected="selected" disabled="disabled">Select status...</option>');
                $.each(s, function (k, v) {
                    if (r.status === v) {
                        $('#status').append("<option value=" + v + " selected='selected'>" + v + "</option>");
                    } else {
                        $('#status').append("<option value=" + v + ">" + v + "</option>");
                    }
                });
            });
        });
    });

    $('#addNewTopic').unbind('click').click(function (e) {
        e.preventDefault();

        clearDropDownBoxAll('#addEditTopic');
        clearFormFields('#addEditTopic');

        model.getSkillListFromTopic(function (r) {
            $('#skill_id').html('<option selected="selected" disabled="disabled">Select skill...</option>');
            $.each(r, function (k, v) {
                $('#skill_id').append("<option value=" + v.skill_id + ">" + v.name + "</option>");
            });
        });
    });

    $('.mod-topic .edit').unbind('click').click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        model.getTopicById(id, function (r) {

            model.getSkillListFromTopic(function (t) {
                $('#skill_id').html('<option selected="selected" disabled="disabled">Select skill...</option>');

                $.each(t, function (k, v) {
                    if (parseInt(r.skill_id) === parseInt(v.skill_id)) {
                        $('#skill_id').append("<option value=" + v.skill_id + " selected='selected'>" + v.name + "</option>");
                    } else {
                        $('#skill_id').append("<option value=" + v.skill_id + ">" + v.name + "</option>");
                    }
                });
            });

            $('#name').val(r.name);
            $('#edit_topic_id').val(r.topic_id);
        });

    });

    /** teacher password change form validation */
    $('#teacher_pass_form_submit').unbind('click').click(function (e) {
        e.preventDefault();

        clearErrorIndicators();

        var data = $('#teacher_password_form').serialize();

        model.validateTeacherPassword(data, function (r) {
            if (r.validation !== true) {
                if (r.old_password) {
                    $('#old_password').parents('.control-group').addClass('error');
                    $('#old_password').siblings('.help-inline').html(r.old_password);
                }
                if (r.password1) {
                    $('#password1').parents('.control-group').addClass('error');
                    $('#password1').siblings('.help-inline').html(r.password1);
                }
                if (r.password2) {
                    $('#password2').parents('.control-group').addClass('error');
                    $('#password2').siblings('.help-inline').html(r.password2);
                }
            } else {
                $('#teacher_password_form').submit();
            }
        });
    });

    /** teacher info change form validation */
    $('#teacher_info_form_submit').unbind('click').click(function (e) {
        e.preventDefault();

        clearErrorIndicators();

        var data = $('#teacher_info_form').serialize();

        model.validateTeacherInfo(data, function (r) {
            if (r.validation !== true) {
                if (r.first_name) {
                    $('#first_name').parents('.control-group').addClass('error');
                    $('#first_name').siblings('.help-inline').html(r.first_name);
                }
                if (r.last_name) {
                    $('#last_name').parents('.control-group').addClass('error');
                    $('#last_name').siblings('.help-inline').html(r.last_name);
                }
                if (r.email) {
                    $('#email').parents('.control-group').addClass('error');
                    $('#email').parent().siblings('.help-inline').html(r.email);
                }
            } else {
                $('#teacher_info_form').submit();
            }
        });
    });


    /** teacher info change timze zone*/
    $('#teacher_time_zone_submit').unbind('click').click(function(e){
        e.preventDefault();

        $('#teacher_timezone_form').submit();
    });


    /* delete action */
    $('.delete').unbind('click').click(function (e) {
        e.preventDefault();
        var t = $(this);
        var url = t.attr('href');

        t.parents('.btn-group').removeClass('open');

        if (confirm("Confirm delete.") === false) {
            return false;
        } else {
            window.location = url;
        }
    });

    /* reset password on admin page */
    $('.reset_pwd').unbind('click').click(function (e) {
        e.preventDefault();
        var t = $(this);
        var url = t.attr('href');

        t.parents('.btn-group').removeClass('open');

        if (confirm("Confirm reset password.") === false) {
            return false;
        } else {
            window.location = url;
        }
    });

    var datatable_settings = {
        "sPaginationType": "full_numbers",
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": true,
        bDestroy: true
    };

    function showClassStudents(classId)
    {
        var id = classId;

        model.getStudentsFromClassByClassId(id, function (r) {
            $('#accordion_list' + id).empty();
            $('#accordion_list_count' + id).html(r.students_count);

            $.each(r.students, function (k, v) {
                if (v.is_active === 'yes') {
                    displayEnable = 'none';
                    displayDisable = '';
                } else {
                    displayEnable = '';
                    displayDisable = 'none';
                }

                var html = '<li class="active_' + v.is_active + '">' +
                    '<i class="icon-user" data-original-title=""></i>&nbsp;' +
                    v.first_name + ' ' + v.last_name +
                    '<div class="buttons pull-right">' +
                    '<a id="' + v.user_id + '" data-icon="&#xe096" aria-hidden="true" class="fs1 student_profile show-tooltip" data-toggle="modal" title="View Student Profile" ' +
                    'data-target="#studentInfo" data-original-title="" data-backdrop="static">&nbsp;</a>' +
                    '<a data-icon="&#xe087" aria-hidden="true" class="fs1 student_password_change show-tooltip" data-toggle="modal" title="Change Student Password" ' +
                    'data-target="#passwordChange" data-original-title="" data-backdrop="static" data-user-id="' + v.user_id + '">&nbsp;</a>' +
                    '<a data-icon="&#xe070" aria-hidden="true" class="fs1 student_profile_change show-tooltip" data-toggle="modal" title="Change Student Profile" ' +
                    'data-target="#profileChange" data-original-title="" data-backdrop="static" data-user-id="' + v.user_id + '">&nbsp;</a>' +
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
                        user = $.parseJSON(response);
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

            $('.student_profile_change').unbind('click').click(function () {
                var user_id = $(this).data('user-id');
                $('#student_profile_change_user_id').val(user_id);
                model.getStudentProfileFromClassByUserId(user_id, function (s) {
                    $('#change_student_profile_form input[name=first_name]').val(s.first_name);
                    $('#change_student_profile_form input[name=last_name]').val(s.last_name);
                    $('#change_student_profile_form input[name=username]').val(s.username);
                    $('#change_student_profile_form input[name=email]').val(s.student_email);
                    $('#change_student_profile_form input[name=parent_email]').val(s.parent_email);
                });
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

                    var data = {user_id: user_id, class_id: class_id};


                    // here was model.getStudentStatReportingTable......
                    model.getStudentStatIndividuallyChallengeReportingTable(data, function (r) {

                        $('#class_student_stats_table_wrapper').empty().html(r);

                        datatable_settings.bFilter = false;

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

    $('.accordion-toggle').unbind('click').click(function () {
        var t = $(this);

        if (t.hasClass('triggered') === false) {
            var id = $(this).attr('id');

            showClassStudents(id);

        }
        t.addClass('triggered');
    });

    $('.admin_student_profile').unbind('click').click(function () {
        var t = $(this);

        moveToTop();

//                    if (t.hasClass('triggered') === false) {
        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        var class_id = url[1].split('/');
        id = id[2];
        class_id = class_id[3];
        model.getStudentProfileFromClassByUserId(id, function (s) {
            var user_id = s.user_id;

            $('#student_username').empty().html(s.username);
            $('#full_name').empty().html(s.first_name + ' ' + s.last_name);
            $('#student_email').empty().html(s.student_email);

            if (typeof s.student_dob === 'string') {
                var dob = s.student_dob.split('/');

                if (isOldEnough(dob[0], dob[1], dob[2]) === true) {
                    $('#parent_email').empty();
                    $('#parent_email').parent().hide();
                    $('#student_email').parent().show();
                } else {
                    if (s.parent_email !== 'false') {
                        $('#parent_email').empty().html(s.parent_email);
                        $('#parent_email').parent().show();
                        $('#student_email').parent().hide();
                    } else {
                        $('#parent_email').empty();
                        $('#parent_email').parent().hide();
                        $('#student_email').parent().show();
                    }
                }
            } else {
                if (s.parent_email !== 'false') {
                    $('#parent_email').empty().html(s.parent_email);
                    $('#parent_email').parent().show();
                    $('#student_email').parent().hide();
                } else {
                    $('#parent_email').empty();
                    $('#parent_email').parent().hide();
                    $('#student_email').parent().show();
                }
            }

            $('#profilepic').attr('src', BASEURL + 'classes/display_student_image/' + user_id);

            if(class_id === undefined){
                var urlPath = window.location.pathname.split('/');
                class_id = urlPath[3];
            }

            var data = {user_id: user_id, class_id: class_id};


            // here was model.getStudentStatReportingTable......
            model.getStudentStatIndividuallyChallengeReportingTable(data, function (r) {

                $('#class_student_stats_table_wrapper').empty().html(r);

                datatable_settings.bFilter = false;

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

    $('.students_in_class_stats_accordion').unbind('click').click(function () {
        var t = $(this);
        var class_id = t.data('class-id');

        model.getReportStudentStatsClassroom(class_id, function (r) {
            do_chart(r, 'students_in_class_chart_wrap');
        });
    });


    $('.admin_students_in_class_stats_accordion').unbind('click').click(function () {
        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        var class_id = id[1];

        model.getReportStudentStatsClassroom(class_id, function (r) {
            setTimeout(function(){
                do_chart(r, 'students_in_class_chart_wrap');
            },250);

        });
    });

    $('#student_stats_class_id').unbind('change').change(function () {
        var class_id = $(this).val();

        model.getReportStudentStatsClassroom(class_id, function (r) {
            if (r.error) {
                $('#students_in_class_stats').html(r.error);
            } else {
                do_chart(r, 'students_in_class_stats');
            }
        });
    });

    $('.student_password_change').unbind('click').click(function () {
        var user_id = $(this).data('user-id');
        $('#student_password_change_user_id').val(user_id);
    });

    $('#change_student_profile_form').unbind('submit').submit(function (e) {
        var form_data = $('#change_student_profile_form').serializeArray();
        var user_id = $('#student_profile_change_user_id').val();

        model.changeStudentProfile(form_data, function(response){
            if (response.error) {
                //we have an error
                var extendedError = '';
                if (response.extended) {
                    extendedError = response.extended.join('<br/>');
                }

                $.gritter.add({
                    title: 'Error',
                    text: response.error + '<br/>' + extendedError
                });
            } else {
                // looks like it was fine
                $.gritter.add({
                    title: 'Success',
                    text: 'Student details successfully updated'
                });
                $('#profileChange').modal('hide');
            }
        });

        return false;
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

    $('.mod-classes .refresh').unbind('click').click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        var t = $(this);

        var degrees = 360;
        t.animateRotate(degrees);

        refresh_class_by_id(id);
    });

    function refresh_class_by_id(id) {
        showClassStudents(id);
    }

    // rotate with animation
    $.fn.animateRotate = function (angle, duration, easing, complete) {
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

    $('.teacherAddClassStudent').unbind('click').click(function (e) {
        e.preventDefault();

        clearFormFields('#addEditClassStudent');

        $('#dl_class_id').html('<option>Select class...</option>').attr('disabled', 'disabled');
        $('#dl_student_id').html('<option value="" selected="selected" disabled="disabled">Select student...</option>');

        var class_id = $(this).parents('.accordion-body').siblings('.accordion-heading').children('.accordion-toggle').attr('id');

        model.getClassesFromClasses(function (r) {
            $.each(r, function (k, v) {
                if (v.class_id === parseInt(class_id)) {
                    $('#dl_class_id').append("<option value=" + v.class_id + " selected='selected'>" + v.class_name + "</option>");
                } else {
                    $('#dl_class_id').append("<option value=" + v.class_id + ">" + v.class_name + "</option>");
                }
            });
        });

        model.getExcludedStudentsByClassId(class_id, function (s) {
            $.each(s, function (k, v) {
                $('#dl_student_id').append("<option value=" + v.user_id + ">" + v.first_name + ' ' + v.last_name + "</option>");
            });
        });
    });

    $('#class_student_save').unbind('click').click(function (e) {
        e.preventDefault();

        clearErrorIndicators();

        var class_id = $('#dl_class_id').val();
        var data = $('#class_student_form').serialize();
        data = 'class_id=' + class_id + '&' + data;

        model.validateClassStudentForm(data, function (r) {
            if (r.validation !== true) {
                if (r.user_id) {
                    $('#dl_student_id').parents('.control-group').addClass('error');
                    $('#dl_student_id').siblings('.help-inline').html(r.user_id);
                }
            } else {
                model.classStudentSave(data, function (s) {
                    if (s.passed === true) {
                        $('#addEditClassStudent .close').click();
                        refresh_class_by_id(class_id);
                    }
                });
            }
        });
    });

    $('#question_selector').change(function (e) {

        var selected = $(this).val();

        question_type(selected, true);
    });


    function question_type(selected, slider) {

        if (slider === true) {
            $('.question_type').slideUp();

            $('#question_type_' + selected).slideDown();
        }

//        $('#question_type_' + selected + '_question').live('keyup', function () {
//            $('#question_type_' + selected + '_question_preview').html($(this).val());
//        });
//
//        // TODO: maybe find better solution for this
//        $('#question_type_' + selected + '_answer_1').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_1_preview').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_2').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_2_preview').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_3').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_3_preview').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_4').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_4_preview').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_5').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_5_preview').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_6').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_6_preview').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_7').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_7_preview').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_8').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_8_preview').html($(this).val());
//        });

//        $('#question_type_7_answer').live('keyup', function () {
//            $('#question_type_7_answer_preview').html($(this).val());
//        });
//
//        $('#question_type_8_answer').live('keyup', function () {
//            $('#question_type_8_answer_preview').html($(this).val());
//        });

        $('.question_type_' + selected + '_correct').change(function () {
            if (selected == 4 || selected == 5) {
                $('#question_type_' + selected + ' .answer').removeClass('correct_answer_image');

                var correct_index = $(this).val();
                $('#question_type_' + selected + '_answer_' + correct_index + '_preview').addClass('correct_answer_image');
            } else {
                $('#question_type_' + selected + ' .answer').removeClass('correct_answer');

                var correct_index = $(this).val();
                $('#question_type_' + selected + '_answer_' + correct_index + '_preview').addClass('correct_answer');
            }
        });

        $('#question_type_7_answer').forceNumericOnly();

        $('#question_type_8_answer').forceNumericOnly();

        if (selected === '9') {
            var order_radio_1 = $('input[name=question_type_9_order_1]:checked', '#inverse2').val();
            var order_radio_2 = $('input[name=question_type_9_order_2]:checked', '#inverse2').val();
            var order_radio_3 = $('input[name=question_type_9_order_3]:checked', '#inverse2').val();
            var order_radio_4 = $('input[name=question_type_9_order_4]:checked', '#inverse2').val();
            var order = order_radio_1 + ',' + order_radio_2 + ',' + order_radio_3 + ',' + order_radio_4;
            $('#question_type_9_correct_text').val(order);
        }

        if (selected === '15') {
            var order_radio_1 = $('input[name=question_type_15_order_1]:checked', '#inverse2').val();
            var order_radio_2 = $('input[name=question_type_15_order_2]:checked', '#inverse2').val();
            var order_radio_3 = $('input[name=question_type_15_order_3]:checked', '#inverse2').val();
            var order_radio_4 = $('input[name=question_type_15_order_4]:checked', '#inverse2').val();
            var order = order_radio_1 + ',' + order_radio_2 + ',' + order_radio_3 + ',' + order_radio_4;
            $('#question_type_15_correct_text').val(order);
        }
    }

    // Numeric only control handler
    jQuery.fn.forceNumericOnly = function () {
        return this.each(function () {
            $(this).keydown(function (e) {
                var key = e.charCode || e.keyCode || 0;
                // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
                // home, end, period, and numpad decimal

                var allowed_keys = [8, 9, 46, 110, 190];

                if (!($.inArray(key, allowed_keys) > -1 || (key >= 35 && key <= 40) || (key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
                    $.gritter.add({
                        title: 'Info',
                        text: 'Only numbers are allowed for the answer of this qusetion.',
                        before_open: function () {
                            if ($('.gritter-item-wrapper').length == 1) {
                                return false;
                            }
                        }
                    });
                }

                return (
                    key == 8 ||
                        key == 9 ||
                        key == 46 ||
                        key == 110 ||
                        key == 190 ||
                        (key >= 35 && key <= 40) ||
                        (key >= 48 && key <= 57) ||
                        (key >= 96 && key <= 105)
                    );
            });
        });
    };

    function humanFileSize(bytes, si) {
        var thresh = si ? 1024 : 1024;
        if (bytes < thresh) return bytes + ' B';
        var units = si ? ['KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'] : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
        var u = -1;
        do {
            bytes /= thresh;
            ++u;
        } while (bytes >= thresh);
        return bytes.toFixed(1) + ' ' + units[u];
    }

    var imageRealWidth, imgRealHeight, clicked_image_uplader, prev_clicked_image_uplader;

    function resize_and_crop(image, image_tag_id, image_name) {

//        $("<img/>") // Make in memory copy of image to avoid css issues
//            .attr("src", image)
//            .load(function () {
//                imageRealWidth = this.width;   // Note: $(this).width() will not
//                imgRealHeight = this.height; // work for in memory images.
//            });

        var canvas_width = parseInt($('#crop_image_wrapper').css('width').replace('px', ''));
        var canvas_height = parseInt($('#crop_image_wrapper').css('height').replace('px', ''));

        $(image_tag_id).attr('src', image).draggable();

        var img = $('#crop_image').load(function () {
            imageRealWidth = this.naturalWidth;
            imgRealHeight = this.naturalHeight;
        });

        $(image_tag_id).css('width', imageRealWidth);

        // reset slider value
        if (typeof $('#image_zoom_slider').data('slider') !== 'undefined') {
            var slider_zoom = $('#image_zoom_slider').data('slider').getValue();

            if (slider_zoom !== 100) {
//                $('#image_zoom_slider').slider('setValue', 100);
                set_zoom_slider_value('#image_zoom_slider', 100);
                imageRealWidth = 'auto';
            }
        }

        $('#image_zoom_slider').slider({min: 0, max: 200, step: 1, value: 100}).on('slide', function (e) {
            var value = e.value;

            var valuePx;
            if (value === 100) {
                valuePx = imageRealWidth;
            }
            else {
                valuePx = imageRealWidth * value / 100;
            }

            $(image_tag_id).css('height', 'auto');
            $(image_tag_id).css('width', valuePx + 'px');
        });

        $('#crop_image').css('width', '');

        $('.image_zoom_slider_caption').show();

        $('#crop_image_name').val(image_name);
    }

    function hexToRgb(h) {
        var r = parseInt((cutHex(h)).substring(0, 2), 16);
        var g = parseInt((cutHex(h)).substring(2, 4), 16);
        var b = parseInt((cutHex(h)).substring(4, 6), 16);
        return r + ',' + g + ',' + b;
    }

    function cutHex(h) {
        return (h.charAt(0) == "#") ? h.substring(1, 7) : h
    }


    $('#reset_position').click(function (e) {
        e.preventDefault();
        reset_crop_image_position();
    });

    function reset_crop_image_position() {
        $('#crop_image').css('left', 0).css('top', 0);
    }

    function set_zoom_slider_value(id, value) {
        $(id).slider('setValue', value);
    }

    function set_colorpicker_hex(id, hex) {
//        $(id).color.fromString(hex);
        document.getElementById(id).color.fromString(hex);
    }

    $('#crop_image_submit').click(function (e) {
        e.preventDefault();

        var image_name = $('#crop_image_name').val();

        var image_pos_left = $('#crop_image').css('left').replace('px', '');
        var image_pos_top = $('#crop_image').css('top').replace('px', '');

        var image_wrapper_width = $('#crop_wrapper #crop_image_wrapper').css('width').replace('px', '');
        var image_wrapper_height = $('#crop_wrapper #crop_image_wrapper').css('height').replace('px', '');

        var slider_zoom = $('#image_zoom_slider').data('slider').getValue();

        var color_hex = $('#image_bg_colorpicker').val();
        var colorRGB = hexToRgb(color_hex).split(',');
        var color_red = colorRGB[0];
        var color_green = colorRGB[1];
        var color_blue = colorRGB[2];

        var data = {
            image: image_name,
            x_axis: image_pos_left,
            y_axis: image_pos_top,
            width: image_wrapper_width,
            height: image_wrapper_height,
            zoom: slider_zoom,
            hex: color_hex,
            red: color_red,
            green: color_green,
            blue: color_blue
        };

        model.cropImage(data, function (r) {

            var image_baseurl = BASEURL + 'upload/';
            var image = image_baseurl + r;

            var randNum = 1 + Math.floor(Math.random() * 9999);
            image += '?rand=' + randNum;

            $('#' + clicked_image_uplader).children('img').attr('src', image);
            $('#' + clicked_image_uplader).children('.image_name').val(r);

            $('#cropModal').modal('hide');
        });
    });

    var question_image_triggers = [
        '#read_image',
        '#read_image_edit',
        '#question_type_3_image',
        '#question_type_3_image_edit',
        '#question_type_4_image_answer_1',
        '#question_type_4_image_answer_1_edit',
        '#question_type_4_image_answer_2',
        '#question_type_4_image_answer_2_edit',
        '#question_type_4_image_answer_3',
        '#question_type_4_image_answer_3_edit',
        '#question_type_4_image_answer_4',
        '#question_type_4_image_answer_4_edit',
        '#question_type_5_question_image',
        '#question_type_5_question_image_edit',
        '#question_type_5_image_answer_1',
        '#question_type_5_image_answer_1_edit',
        '#question_type_5_image_answer_2',
        '#question_type_5_image_answer_2_edit',
        '#question_type_5_image_answer_3',
        '#question_type_5_image_answer_3_edit',
        '#question_type_5_image_answer_4',
        '#question_type_5_image_answer_4_edit',
        '#question_type_8_image',
        '#question_type_8_image_edit',
        '#question_type_9_image',
        '#question_type_9_image_edit',
        '#question_type_10_image',
        '#question_type_10_image_edit',
        '#question_type_11_question_image',
        '#question_type_11_question_image_edit',
        '#question_type_11_image_answer_1',
        '#question_type_11_image_answer_1_edit',
        '#question_type_11_image_answer_2',
        '#question_type_11_image_answer_2_edit',
        '#question_type_12_image_answer_1',
        '#question_type_12_image_answer_1_edit',
        '#question_type_12_image_answer_2',
        '#question_type_12_image_answer_2_edit',
    ];

    var small_crop_image_canvas = [
        '#question_type_4_image_answer_1',
        '#question_type_4_image_answer_1_edit',
        '#question_type_4_image_answer_2',
        '#question_type_4_image_answer_2_edit',
        '#question_type_4_image_answer_3',
        '#question_type_4_image_answer_3_edit',
        '#question_type_4_image_answer_4',
        '#question_type_4_image_answer_4_edit',
        '#question_type_5_image_answer_1',
        '#question_type_5_image_answer_1_edit',
        '#question_type_5_image_answer_2',
        '#question_type_5_image_answer_2_edit',
        '#question_type_5_image_answer_3',
        '#question_type_5_image_answer_3_edit',
        '#question_type_5_image_answer_4',
        '#question_type_5_image_answer_4_edit',
        '#question_type_11_image_answer_1',
        '#question_type_11_image_answer_1_edit',
        '#question_type_11_image_answer_2',
        '#question_type_11_image_answer_2_edit',
        '#question_type_12_image_answer_1',
        '#question_type_12_image_answer_1_edit',
        '#question_type_12_image_answer_2',
        '#question_type_12_image_answer_2_edit',
    ];

    $(question_image_triggers.join(',')).unbind('click').click(function (e) {
        e.preventDefault();
        prev_clicked_image_uplader = clicked_image_uplader;

        clicked_image_uplader = e.currentTarget.id;

        if (typeof prev_clicked_image_uplader !== 'undefined' && prev_clicked_image_uplader !== clicked_image_uplader) {
            reset_crop_image_environment();
        }

        var current_clicked_image_uplader = '#' + clicked_image_uplader;

        if ($.inArray(current_clicked_image_uplader, small_crop_image_canvas) > -1) {
            $('#crop_image_wrapper').css('width', 215).css('height', 100);
        } else {
            if (clicked_image_uplader === 'read_image') {
                if ($('#read_text').val().length > 0) {
                    $('#crop_image_wrapper').css('width', 400).css('height', 200);
                    $('#read_image_preview .set_image_btn').css('margin-top', '-25%');
                } else {
                    $('#crop_image_wrapper').css('width', 400).css('height', 400);
                    $('#read_image_preview .set_image_btn').css('margin-top', '-50%');
                }
                $('#read_image .img_to_upload').show();
            } else if (clicked_image_uplader === 'read_image_edit') {
                if ($('#read_text_edit').val().length > 0) {
                    $('#crop_image_wrapper').css('width', 400).css('height', 200);
                    $('#read_image_preview_edit .set_image_btn').css('margin-top', '-25%');
                } else {
                    $('#crop_image_wrapper').css('width', 400).css('height', 400);
                    $('#read_image_preview_edit .set_image_btn').css('margin-top', '-50%');
                }
            } else {
                $('#crop_image_wrapper').css('width', 430).css('height', 200);
            }

        }
//        uploader_question_image.init();
        uploader_question_image.refresh();
        $('#cropModal').modal('show');
        uploader_question_image.refresh();
    });

    function reset_crop_image_environment() {
        reset_crop_image_position();


        if ($('#image_zoom_slider').contents().length > 0) {
            set_zoom_slider_value('#image_zoom_slider', 100);
        }

        set_colorpicker_hex('image_bg_colorpicker', 'FFFFFF');

        $('#crop_image').removeAttr('src').hide();
    }

    /********************************************************************************/
    /**                                                                            **/
    /**          question image upload for all questions and answers               **/
    /**                                                                            **/
    /********************************************************************************/

    var uploader_question_image = new plupload.Uploader({
        runtimes: 'html5,gears,html4',
        browse_button: 'question_image_upload',
        max_file_size: '2000kb',
        unique_names: true,
        chunk_size: '50kb',
        multi_selection: false,
        url: BASEURL + 'question/upload_image',
        filters: [
            {title: "Image files", extensions: "png,jpg,jpeg,gif"}
        ]
    });

//    uploader_question_image.refresh();
    uploader_question_image.init();
    uploader_question_image.bind('Error', function (up, response) {
        var file_filters = up.settings.filters;
        var max_file_size = humanFileSize(up.settings.max_file_size, 'KB');

        if (response.code === -600) {
            $.gritter.add({
                title: 'Error',
                text: response.message + ' Max file size is ' + max_file_size + '.'
            });
        } else if (response.code === -601) {
            $.gritter.add({
                title: 'Error',
                text: response.message + ' Allowed image extension is ' + file_filters[0].extensions + '.'
            });
        } else {
            $.gritter.add({
                title: 'Error',
                text: response.message
            });
        }
    });

    uploader_question_image.bind('UploadProgress', function (up, files) {
        $('#loading_spinner').show();
    });

    uploader_question_image.bind('FilesAdded', function (up, files) {
        while (up.files.length > 1) {
            up.removeFile(up.files[0]);
        }
        up.refresh();
        if (up.state != 2 & files.length > 0) {
            up.start();
        }
    });

    uploader_question_image.bind('FileUploaded', function (up, file, response) {
        if (response.status === 200 && typeof response.response !== 'undefined') {
            $('#loading_spinner').hide();
            $('#crop_image').show();
            var image_baseurl = BASEURL + 'upload/';
            var image = image_baseurl + response.response;

            resize_and_crop(image, '#crop_image', response.response);
        }
    });

    /********************************************************************************/

    function validate_any_question_type(validation_data) {
        var msg = '';
        $.each(validation_data, function (k, v) {
            if (typeof v === 'object') {
                $.each(v, function (k2, v2) {
                    msg += v2 + '<br />';
                });
            } else {
                msg += v + '<br />';
            }
        });
        $.gritter.add({
            title: 'Error',
            text: msg
        });
    }

    $('#question_type_1_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_1_form').serialize();

        model.validateQuestionType1(data, function (r) {
            if (r.validation !== true) {
//                question_type_1_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_1_form').submit();
            }
        });
    });

    function question_type_1_validation(r) {
        $('.modal_right_column .control-group').removeClass('error');
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_1_question) {
            $('#question_type_1_question').parents('.control-group').addClass('error');
            $('#question_type_1_question').siblings('.help-inline').html(r.question_type_1_question);
        }

        if (r.question_type_1_answer) {
            $.each(r.question_type_1_answer, function (k, v) {
                if (k) {
                    $('#question_type_1_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_1_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_1_correct) {
            $('#correct_error_1').addClass('error_text').html(r.question_type_1_correct);
        }
    }

    $('#question_type_2_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_2_form').serialize();

        model.validateQuestionType2(data, function (r) {

            if (r.validation !== true) {
                validate_any_question_type(r);
//                question_type_2_validation(r);
            } else {
                $('#question_type_2_form').submit();
            }
        });
    });

    function question_type_2_validation(r) {
        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_2_question) {
            $('#question_type_2_question').parents('.control-group').addClass('error');
            $('#question_type_2_question').siblings('.help-inline').html(r.question_type_2_question);
        }

        if (r.question_type_2_answer) {

            $.each(r.question_type_2_answer, function (k, v) {
                if (k) {
                    $('#question_type_2_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_2_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_2_correct) {
            $('#correct_error_2').addClass('error_text').html(r.question_type_2_correct);
        }
    }

    $('#question_type_3_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_3_form').serialize();

        model.validateQuestionType3(data, function (r) {
            if (r.validation !== true) {
//                question_type_3_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_3_form').submit();
            }
        });
    });

    function question_type_3_validation(r) {
        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_3_question) {
            $('#question_type_3_question').parents('.control-group').addClass('error');
            $('#question_type_3_question').siblings('.help-inline').html(r.question_type_3_question);
        }

        if (r.question_type_3_answer) {
            $.each(r.question_type_3_answer, function (k, v) {
                if (k) {
                    $('#question_type_3_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_3_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_3_image) {
            $('#question_type_3_image').parents('label').addClass('error');
            $('#question_type_3_image').siblings('.help-inline').addClass('error_text').html(r.question_type_3_image);
        }

        if (r.question_type_3_correct) {
            $('#correct_error_3').addClass('error_text').html(r.question_type_3_correct);
        }
    }

    $('#question_type_4_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_4_form').serialize();

        model.validateQuestionType4(data, function (r) {

            if (r.validation !== true) {
//                question_type_4_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_4_form').submit();
            }
        });
    });

    function question_type_4_validation(r) {
        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_4_question) {
            $('#question_type_4_question').parents('.control-group').addClass('error');
            $('#question_type_4_question').siblings('.help-inline').html(r.question_type_4_question);
        }

        if (r.question_type_4_image) {
            $.each(r.question_type_4_image, function (k, v) {
                if (k) {
                    $('#question_type_4_image_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_4_image_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_4_correct) {
            $('#correct_error_4').addClass('error_text').html(r.question_type_4_correct);
        }
    }

    $('#question_type_5_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_5_form').serialize();

        model.validateQuestionType5(data, function (r) {

            if (r.validation !== true) {
//                question_type_5_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_5_form').submit();
            }
        });
    });

    function question_type_5_validation(r) {
        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_5_question) {
            $('#question_type_5_question').parents('.control-group').addClass('error');
            $('#question_type_5_question').siblings('.help-inline').html(r.question_type_5_question);
        }

        if (r.question_type_5_question_image) {
            $('#question_type_5_question_image').parents('.control-group').addClass('error');
            $('#question_type_5_question_image').siblings('.help-inline').html(r.question_type_5_question_image);
        }

        if (r.question_type_5_answer_image) {
            $.each(r.question_type_5_answer_image, function (k, v) {
                if (k) {
                    $('#question_type_5_image_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_5_image_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_5_correct) {
            $('#correct_error_5').addClass('error_text').html(r.question_type_5_correct);
        }
    }

    $('#question_type_6_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_6_form').serialize();

        model.validateQuestionType6(data, function (r) {

            if (r.validation !== true) {
//                question_type_6_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_6_form').submit();
            }
        });
    });

    function question_type_6_validation(r) {
        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_6_question) {
            $('#question_type_6_question').parents('.control-group').addClass('error');
            $('#question_type_6_question').siblings('.help-inline').html(r.question_type_6_question);
        }

        if (r.question_type_6_answer) {
            $.each(r.question_type_6_answer, function (k, v) {
                if (k) {
                    $('#question_type_6_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_6_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_6_correct) {
            $('#correct_error_6').addClass('error_text').html(r.question_type_6_correct);
        }
    }

    $('#question_type_7_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_7_form').serialize();

        model.validateQuestionType7(data, function (r) {

            if (r.validation !== true) {
//                question_type_7_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_7_form').submit();
            }
        });
    });

    function question_type_7_validation(r) {
        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_7_question) {
            $('#question_type_7_question').parents('.control-group').addClass('error');
            $('#question_type_7_question').siblings('.help-inline').html(r.question_type_7_question);
        }

        if (r.question_type_7_answer) {
            $('#question_type_7_answer').parents('.control-group').addClass('error');
            $('#question_type_7_answer').siblings('.help-inline').html(r.question_type_7_answer);
        }
    }

    $('#question_type_8_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_8_form').serialize();

        model.validateQuestionType8(data, function (r) {

            if (r.validation !== true) {
//                question_type_8_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_8_form').submit();
            }
        });
    });

    function question_type_8_validation(r) {
        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_8_question) {
            $('#question_type_8_question').parents('.control-group').addClass('error');
            $('#question_type_8_question').siblings('.help-inline').html(r.question_type_8_question);
        }

        if (r.question_type_8_question_image) {
            $('#question_type_8_image_error').addClass('error_text').html(r.question_type_8_question_image);
        }

        if (r.question_type_8_answer) {
            $('#question_type_8_answer').parents('.control-group').addClass('error');
            $('#question_type_8_answer').siblings('.help-inline').html(r.question_type_8_answer);
        }
    }

    $('#question_type_9_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_9_form').serialize();


        model.validateQuestionType9(data, function (r) {

            if (r.validation !== true) {
//                question_type_9_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_9_form').submit();
            }
        });
    });



    function question_type_9_validation(r) {

        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');

        if (r.question_type_9_question) {
            $('#question_type_9_question').parents('.control-group').addClass('error');
            $('#question_type_9_question').siblings('.help-inline').html(r.question_type_9_question);
        }

        if (r.question_type_9_answer) {
            $.each(r.question_type_9_answer, function (k, v) {
                if (k) {
                    $('#question_type_9_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_9_answer_' + k).parents('.control-group').next().addClass('error');
                    $('#question_type_9_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_9_question_image) {
            $('#question_type_9_image').parents('label').addClass('error');
            $('#question_type_9_image').siblings('.help-inline').addClass('error_text').html(r.question_type_9_question_image);
        }
    }

    $('#question_type_10_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_10_form').serialize();

        model.validateQuestionType10(data, function (r) {
            if (r.validation !== true) {
//                question_type_10_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_10_form').submit();
            }
        });
    });

    function question_type_10_validation(r) {
        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_10_question) {
            $('#question_type_10_question').parents('.control-group').addClass('error');
            $('#question_type_10_question').siblings('.help-inline').html(r.question_type_10_question);
        }

        if (r.question_type_10_answer) {
            $.each(r.question_type_10_answer, function (k, v) {
                if (k) {
                    $('#question_type_10_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_10_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_10_image) {
            $('#question_type_10_image').parents('label').addClass('error');
            $('#question_type_10_image').siblings('.help-inline').addClass('error_text').html(r.question_type_10_image);
        }

        if (r.question_type_10_correct) {
            $('#correct_error_10').addClass('error_text').html(r.question_type_10_correct);
        }
    }

    $('#question_type_11_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_11_form').serialize();

        model.validateQuestionType11(data, function (r) {

            if (r.validation !== true) {
//                question_type_5_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_11_form').submit();
            }
        });
    });

    function question_type_11_validation(r) {
        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_11_question) {
            $('#question_type_11_question').parents('.control-group').addClass('error');
            $('#question_type_11_question').siblings('.help-inline').html(r.question_type_11_question);
        }

        if (r.question_type_11_question_image) {
            $('#question_type_11_question_image').parents('.control-group').addClass('error');
            $('#question_type_11_question_image').siblings('.help-inline').html(r.question_type_11_question_image);
        }

        if (r.question_type_11_answer_image) {
            $.each(r.question_type_11_answer_image, function (k, v) {
                if (k) {
                    $('#question_type_11_image_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_11_image_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_11_correct) {
            $('#correct_error_11').addClass('error_text').html(r.question_type_11_correct);
        }
    }

    $('#question_type_12_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_12_form').serialize();

        model.validateQuestionType4(data, function (r) {

            if (r.validation !== true) {
//                question_type_12_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_12_form').submit();
            }
        });
    });

    function question_type_12_validation(r) {
        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_12_question) {
            $('#question_type_12_question').parents('.control-group').addClass('error');
            $('#question_type_12_question').siblings('.help-inline').html(r.question_type_12_question);
        }

        if (r.question_type_12_image) {
            $.each(r.question_type_12_image, function (k, v) {
                if (k) {
                    $('#question_type_12_image_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_12_image_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_12_correct) {
            $('#correct_error_12').addClass('error_text').html(r.question_type_12_correct);
        }
    }

    $('#question_type_13_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_13_form').serialize();

        model.validateQuestionType13(data, function (r) {
            if (r.validation !== true) {
//                question_type_13_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_13_form').submit();
            }
        });
    });

    function question_type_13_validation(r) {
        $('.modal_right_column .control-group').removeClass('error');
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_13_question) {
            $('#question_type_13_question').parents('.control-group').addClass('error');
            $('#question_type_13_question').siblings('.help-inline').html(r.question_type_13_question);
        }

        if (r.question_type_13_answer) {
            $.each(r.question_type_13_answer, function (k, v) {
                if (k) {
                    $('#question_type_13_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_13_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_13_correct) {
            $('#correct_error_13').addClass('error_text').html(r.question_type_13_correct);
        }
    }

    $('#question_type_14_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_14_form').serialize();

        model.validateQuestionType14(data, function (r) {
            if (r.validation !== true) {
//                question_type_14_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_14_form').submit();
            }
        });
    });

    function question_type_14_validation(r) {
        $('.modal_right_column .control-group').removeClass('error');
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_14_question) {
            $('#question_type_14_question').parents('.control-group').addClass('error');
            $('#question_type_14_question').siblings('.help-inline').html(r.question_type_13_question);
        }

        if (r.question_type_14_answer) {
            $.each(r.question_type_14_answer, function (k, v) {
                if (k) {
                    $('#question_type_14_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_14_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_14_correct) {
            $('#correct_error_14').addClass('error_text').html(r.question_type_14_correct);
        }
    }

    $('#question_type_15_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_15_form').serialize();

        model.validateQuestionType15(data, function (r) {
            if (r.validation !== true) {
//                question_type_15_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_15_form').submit();
            }
        });
    });

    function question_type_15_validation(r) {
        $('.modal_right_column .control-group').removeClass('error');
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_15_question) {
            $('#question_type_15_question').parents('.control-group').addClass('error');
            $('#question_type_15_question').siblings('.help-inline').html(r.question_type_13_question);
        }

        if (r.question_type_15_answer) {
            $.each(r.question_type_15_answer, function (k, v) {
                if (k) {
                    $('#question_type_15_answer_' + k).parents('.control-group').addClass('error');
                    $('#question_type_15_answer_' + k).siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_15_correct) {
            $('#correct_error_15').addClass('error_text').html(r.question_type_15_correct);
        }
    }

    $('#question_type_16_submit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_16_form').serialize();

        model.validateQuestionType16(data, function (r) {

            if (r.validation !== true) {
//                question_type_16_validation(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_16_form').submit();
            }
        });
    });

    function question_type_16_validation(r) {
        $('.modal_right_column .control-group').removeClass('error')
        $('.help-inline').html('');
        $('#correct_error_2').html('');
        if (r.question_type_16_question) {
            $('#question_type_16_question').parents('.control-group').addClass('error');
            $('#question_type_16_question').siblings('.help-inline').html(r.question_type_16_question);
        }

        if (r.question_type_16_answer) {
            $('#question_type_16_answer').parents('.control-group').addClass('error');
            $('#question_type_16_answer').siblings('.help-inline').html(r.question_type_16_answer);
        }
    }

    /**
     *
     *  QUESTION EDIT SUBMIT AND VALIDATION
     *
     * */

    $('#question_type_1_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_1_form_edit').serialize();

        model.validateQuestionType1(data, function (r) {
            if (r.validation !== true) {
//                question_type_1_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_1_form_edit').submit();
            }
        });
    });

    function question_type_1_validation_edit(r) {
        if (r.question_type_1_question) {
            $('#question_type_1_question_edit').parents('.control-group').addClass('error');
            $('#question_type_1_question_edit').siblings('.help-inline').html(r.question_type_1_question);
        }

        if (r.question_type_1_answer) {
            $.each(r.question_type_1_answer, function (k, v) {
                if (k) {
                    $('#question_type_1_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_1_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_1_correct) {
            $('#correct_error_1_edit').html(r.question_type_1_correct);
        }
    }

    $('#question_type_2_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_2_form_edit').serialize();

        model.validateQuestionType2(data, function (r) {

            if (r.validation !== true) {
//                question_type_2_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_2_form_edit').submit();
            }
        });
    });

    function question_type_2_validation_edit(r) {
        if (r.question_type_2_question) {
            $('#question_type_2_question_edit').parents('.control-group').addClass('error');
            $('#question_type_2_question_edit').siblings('.help-inline').html(r.question_type_2_question);
        }

        if (r.question_type_2_answer) {
            $.each(r.question_type_2_answer, function (k, v) {
                if (k) {
                    $('#question_type_2_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_2_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_2_correct) {
            $('#correct_error_2_edit').html(r.question_type_2_correct);
        }
    }

    $('#question_type_3_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_3_form_edit').serialize();

        model.validateQuestionType3(data, function (r) {
            if (r.validation !== true) {
//                question_type_3_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_3_form_edit').submit();
            }
        });
    });

    function question_type_3_validation_edit(r) {
        if (r.question_type_3_question) {
            $('#question_type_3_question_edit').parents('.control-group').addClass('error');
            $('#question_type_3_question_edit').siblings('.help-inline').html(r.question_type_3_question);
        }

        if (r.question_type_3_answer) {
            $.each(r.question_type_3_answer, function (k, v) {
                if (k) {
                    $('#question_type_3_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_3_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_3_image) {
            $('#question_type_3_image_edit').parents('label').addClass('error');
            $('#question_type_3_image_edit').siblings('.help-inline').html(r.question_type_3_image);
        }

        if (r.question_type_3_correct) {
            $('#correct_error_3_edit').html(r.question_type_3_correct);
        }
    }

    $('#question_type_4_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_4_form_edit').serialize();

        model.validateQuestionType4(data, function (r) {

            if (r.validation !== true) {
//                question_type_4_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_4_form_edit').submit();
            }
        });
    });

    function question_type_4_validation_edit(r) {
        if (r.question_type_4_question) {
            $('#question_type_4_question_edit').parents('.control-group').addClass('error');
            $('#question_type_4_question_edit').siblings('.help-inline').html(r.question_type_4_question);
        }

        if (r.question_type_4_image) {
            $.each(r.question_type_4_image, function (k, v) {
                if (k) {
                    $('#question_type_4_image_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_4_image_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_4_correct) {
            $('#correct_error_4_edit').html(r.question_type_4_correct);
        }
    }

    $('#question_type_5_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_5_form_edit').serialize();

        model.validateQuestionType5(data, function (r) {

            if (r.validation !== true) {
//                question_type_5_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_5_form_edit').submit();
            }
        });
    });

    function question_type_5_validation_edit(r) {
        if (r.question_type_5_question) {
            $('#question_type_5_question_edit').parents('.control-group').addClass('error');
            $('#question_type_5_question_edit').siblings('.help-inline').html(r.question_type_5_question);
        }

        if (r.question_type_5_question_image) {
            $('#question_type_5_question_image_edit').parents('label').addClass('error');
            $('#question_type_5_question_image_edit').siblings('.help-inline').html(r.question_type_5_question_image);
        }

        if (r.question_type_5_answer_image) {
            $.each(r.question_type_5_answer_image, function (k, v) {
                if (k) {
                    $('#question_type_5_image_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_5_image_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_5_correct) {
            $('#correct_error_5_edit').html(r.question_type_5_correct);
        }
    }

    $('#question_type_6_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_6_form_edit').serialize();

        model.validateQuestionType6(data, function (r) {

            if (r.validation !== true) {
//                question_type_6_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_6_form_edit').submit();
            }
        });
    });

    function question_type_6_validation_edit(r) {
        if (r.question_type_6_question) {
            $('#question_type_6_question_edit').parents('.control-group').addClass('error');
            $('#question_type_6_question_edit').siblings('.help-inline').html(r.question_type_6_question);
        }

        if (r.question_type_6_answer) {
            $.each(r.question_type_6_answer, function (k, v) {
                if (k) {
                    $('#question_type_6_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_6_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_6_correct) {
            $('#correct_error_6_edit').html(r.question_type_6_correct);
        }
    }

    $('#question_type_7_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_7_form_edit').serialize();

        model.validateQuestionType7(data, function (r) {

            if (r.validation !== true) {
//                question_type_7_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_7_form_edit').submit();
            }
        });
    });

    function question_type_7_validation_edit(r) {
        if (r.question_type_7_question) {
            $('#question_type_7_question_edit').parents('.control-group').addClass('error');
            $('#question_type_7_question_edit').siblings('.help-inline').html(r.question_type_7_question);
        }

        if (r.question_type_7_answer) {
            $('#question_type_7_answer_edit').parents('.control-group').addClass('error');
            $('#question_type_7_answer_edit').siblings('.help-inline').html(r.question_type_7_answer);
        }
    }

    $('#question_type_8_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_8_form_edit').serialize();

        model.validateQuestionType8(data, function (r) {

            if (r.validation !== true) {
//                question_type_8_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_8_form_edit').submit();
            }
        });
    });

    function question_type_8_validation_edit(r) {
        if (r.question_type_8_question) {
            $('#question_type_8_question_edit').parents('.control-group').addClass('error');
            $('#question_type_8_question_edit').siblings('.help-inline').html(r.question_type_8_question);
        }

        if (r.question_type_8_question_image) {
            $('#question_type_8_image_error_edit').html(r.question_type_8_question_image);
        }

        if (r.question_type_8_answer) {
            $('#question_type_8_answer_edit').parents('.control-group').addClass('error');
            $('#question_type_8_answer_edit').siblings('.help-inline').html(r.question_type_8_answer);
        }
    }

    $('#question_type_9_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var order_radio_1 = $('input[name=question_type_9_order_1]:checked').val();
        var order_radio_2 = $('input[name=question_type_9_order_2]:checked').val();
        var order_radio_3 = $('input[name=question_type_9_order_3]:checked').val();
        var order_radio_4 = $('input[name=question_type_9_order_4]:checked').val();
        var order = order_radio_1 + ',' + order_radio_2 + ',' + order_radio_3 + ',' + order_radio_4;

        var order_array = [order_radio_1, order_radio_2, order_radio_3, order_radio_4];
        $('#question_type_9_correct_text_edit').val(order);

        var data = $('#question_type_9_form_edit').serialize();

        var unique = order_array.filter(function (itm, i, a) {
            return i == a.indexOf(itm);
        });
        if (unique.length !== 4) {
            $.gritter.add({
                title: 'Error',
                text: "Order of answers can't be on the same position"
            });
        } else {
            model.validateQuestionType9(data, function (r) {

                if (r.validation !== true) {
//                    question_type_9_validation_edit(r);
                    validate_any_question_type(r);
                } else {
                    $('#question_type_9_form_edit').submit();
                }
            });
        }
    });

//    $('.question_order').change(function () {
//        var t = $(this);
//        var order = t.val();
//        var answer = t.data('answerindex');
//
////        $('#question_type_9_answer_' + order + '_preview_ordered').html($('#question_type_9_answer_' + answer).val());
//    });

    function question_type_9_validation_edit(r) {
        if (r.question_type_9_question) {
            $('#question_type_9_question_edit').parents('.control-group').addClass('error');
            $('#question_type_9_question_edit').siblings('.help-inline').html(r.question_type_9_question);
        }

        if (r.question_type_9_answer) {
            $.each(r.question_type_9_answer, function (k, v) {
                if (k) {
                    $('#question_type_9_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_9_answer_' + k + '_edit').parents('.control-group').next().addClass('error');
                    $('#question_type_9_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_9_question_image) {
            $('#question_type_9_image_edit').parents('label').addClass('error');
            $('#question_type_9_image_edit').siblings('.help-inline').html(r.question_type_9_question_image);
        }
    }

    $('#question_type_10_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_10_form_edit').serialize();

        model.validateQuestionType10(data, function (r) {
            if (r.validation !== true) {
//                question_type_10_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_10_form_edit').submit();
            }
        });
    });

    function question_type_10_validation_edit(r) {
        if (r.question_type_10_question) {
            $('#question_type_10_question_edit').parents('.control-group').addClass('error');
            $('#question_type_10_question_edit').siblings('.help-inline').html(r.question_type_10_question);
        }

        if (r.question_type_10_answer) {
            $.each(r.question_type_10_answer, function (k, v) {
                if (k) {
                    $('#question_type_10_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_10_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_10_image) {
            $('#question_type_10_image_edit').parents('label').addClass('error');
            $('#question_type_10_image_edit').siblings('.help-inline').html(r.question_type_10_image);
        }

        if (r.question_type_10_correct) {
            $('#correct_error_10_edit').html(r.question_type_10_correct);
        }
    }

    $('#question_type_11_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_11_form_edit').serialize();

        model.validateQuestionType11(data, function (r) {

            if (r.validation !== true) {
//                question_type_11_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_11_form_edit').submit();
            }
        });
    });

    function question_type_11_validation_edit(r) {
        if (r.question_type_11_question) {
            $('#question_type_11_question_edit').parents('.control-group').addClass('error');
            $('#question_type_11_question_edit').siblings('.help-inline').html(r.question_type_11_question);
        }

        if (r.question_type_11_question_image) {
            $('#question_type_11_question_image_edit').parents('label').addClass('error');
            $('#question_type_11_question_image_edit').siblings('.help-inline').html(r.question_type_11_question_image);
        }

        if (r.question_type_11_answer_image) {
            $.each(r.question_type_11_answer_image, function (k, v) {
                if (k) {
                    $('#question_type_11_image_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_11_image_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_11_correct) {
            $('#correct_error_11_edit').html(r.question_type_11_correct);
        }
    }

    $('#question_type_12_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_12_form_edit').serialize();

        model.validateQuestionType12(data, function (r) {

            if (r.validation !== true) {
//                question_type_12_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_12_form_edit').submit();
            }
        });
    });

    function question_type_12_validation_edit(r) {
        if (r.question_type_12_question) {
            $('#question_type_12_question_edit').parents('.control-group').addClass('error');
            $('#question_type_12_question_edit').siblings('.help-inline').html(r.question_type_12_question);
        }

        if (r.question_type_12_image) {
            $.each(r.question_type_12_image, function (k, v) {
                if (k) {
                    $('#question_type_12_image_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_12_image_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_12_correct) {
            $('#correct_error_12_edit').html(r.question_type_12_correct);
        }
    }

    $('#question_type_13_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_13_form_edit').serialize();

        model.validateQuestionType13(data, function (r) {
            if (r.validation !== true) {
//                question_type_13_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_13_form_edit').submit();
            }
        });
    });

    function question_type_13_validation_edit(r) {
        if (r.question_type_13_question) {
            $('#question_type_13_question_edit').parents('.control-group').addClass('error');
            $('#question_type_13_question_edit').siblings('.help-inline').html(r.question_type_13_question);
        }

        if (r.question_type_13_answer) {
            $.each(r.question_type_13_answer, function (k, v) {
                if (k) {
                    $('#question_type_13_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_13_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_13_correct) {
            $('#correct_error_13_edit').html(r.question_type_13_correct);
        }
    }

    $('#question_type_14_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_14_form_edit').serialize();

        model.validateQuestionType14(data, function (r) {
            if (r.validation !== true) {
//                question_type_14_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_14_form_edit').submit();
            }
        });
    });

    function question_type_14_validation_edit(r) {
        if (r.question_type_14_question) {
            $('#question_type_14_question_edit').parents('.control-group').addClass('error');
            $('#question_type_14_question_edit').siblings('.help-inline').html(r.question_type_14_question);
        }

        if (r.question_type_14_answer) {
            $.each(r.question_type_14_answer, function (k, v) {
                if (k) {
                    $('#question_type_14_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_14_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_14_correct) {
            $('#correct_error_14_edit').html(r.question_type_14_correct);
        }
    }

    $('#question_type_15_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var order_radio_1 = $('input[name=question_type_15_order_1]:checked').val();
        var order_radio_2 = $('input[name=question_type_15_order_2]:checked').val();
        var order_radio_3 = $('input[name=question_type_15_order_3]:checked').val();
        var order_radio_4 = $('input[name=question_type_15_order_4]:checked').val();
        var order = order_radio_1 + ',' + order_radio_2 + ',' + order_radio_3 + ',' + order_radio_4;

        var order_array = [order_radio_1, order_radio_2, order_radio_3, order_radio_4];
        $('#question_type_15_correct_text_edit').val(order);

        var data = $('#question_type_15_form_edit').serialize();

        var unique = order_array.filter(function (itm, i, a) {
            return i == a.indexOf(itm);
        });
        if (unique.length !== 4) {
            $.gritter.add({
                title: 'Error',
                text: "Order of answers can't be on the same position"
            });
        } else {
            model.validateQuestionType15(data, function (r) {

                if (r.validation !== true) {
//                    question_type_15_validation_edit(r);
                    validate_any_question_type(r);
                } else {
                    $('#question_type_15_form_edit').submit();
                }
            });
        }
    });

    function question_type_15_validation_edit(r) {
        if (r.question_type_15_question) {
            $('#question_type_15_question_edit').parents('.control-group').addClass('error');
            $('#question_type_15_question_edit').siblings('.help-inline').html(r.question_type_15_question);
        }

        if (r.question_type_15_answer) {
            $.each(r.question_type_15_answer, function (k, v) {
                if (k) {
                    $('#question_type_15_answer_' + k + '_edit').parents('.control-group').addClass('error');
                    $('#question_type_15_answer_' + k + '_edit').siblings('.help-inline').html(v);
                }
            });
        }

        if (r.question_type_15_correct) {
            $('#correct_error_15_edit').html(r.question_type_15_correct);
        }
    }

    $('#question_type_16_submit_edit').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#question_type_16_form_edit').serialize();

        model.validateQuestionType16(data, function (r) {

            if (r.validation !== true) {
//                question_type_16_validation_edit(r);
                validate_any_question_type(r);
            } else {
                $('#question_type_16_form_edit').submit();
            }
        });
    });

    function question_type_16_validation_edit(r) {
        if (r.question_type_16_question) {
            $('#question_type_16_question_edit').parents('.control-group').addClass('error');
            $('#question_type_16_question_edit').siblings('.help-inline').html(r.question_type_16_question);
        }

        if (r.question_type_16_answer) {
            $('#question_type_16_answer_edit').parents('.control-group').addClass('error');
            $('#question_type_16_answer_edit').siblings('.help-inline').html(r.question_type_16_answer);
        }
    }

    var uploader_teacher_avatar = new plupload.Uploader({
        runtimes: 'html5,gears,html4',
        browse_button: 'teacher_avatar_upload',
        max_file_size: '512kb',
        unique_names: true,
        chunk_size: '20kb',
        multi_selection: false,
        url: BASEURL + 'profile/update_image',
        filters: [
            {title: "Image files", extensions: "png"}
        ]
    });

    uploader_teacher_avatar.init();

    uploader_teacher_avatar.bind('Error', function (up, response) {
        var file_filters = up.settings.filters;
        var max_file_size = humanFileSize(up.settings.max_file_size, 'KB');

        if (response.code === -600) {
            $.gritter.add({
                title: 'Error',
                text: response.message + ' Max file size is ' + max_file_size + '.'
            });
        } else if (response.code === -601) {
            $.gritter.add({
                title: 'Error',
                text: response.message + ' Allowed image extension is ' + file_filters[0].extensions + '.'
            });
        } else {
            $.gritter.add({
                title: 'Error',
                text: response.message
            });
        }
    });

    uploader_teacher_avatar.bind('UploadProgress', function (up, files) {
        $('#teacher_avatar').attr('src', ajax_loader_url);
    });


    uploader_teacher_avatar.bind('FilesAdded', function (up, files) {
        while (up.files.length > 1) {
            up.removeFile(up.files[0]);
        }
        up.refresh();
        if (up.state != 2 & files.length > 0) {
            up.start();
        }
    });

    uploader_teacher_avatar.bind('FileUploaded', function (up, file, response) {
        if (response.status === 200 && typeof response.response !== 'undefined') {

            var image_baseurl = BASEURL + 'upload/';
            var image = image_baseurl + response.response;
            $('#teacher_avatar').attr('src', image);
            $('#teacher_avatar_url').val(response.response);
        }
    });

    // add/edit challenge in challenge builder
    // Wizard Progressbar
    $('#inverse').bootstrapWizard({
        'tabClass': 'nav',
        'debug': false,
        onShow: function (tab, navigation, index) {
        },
        onNext: function (tab, navigation, index) {
            if (index == 1) {
                $('.error').removeClass('error');

                var error = false;
                var error_msg;

                var challenge_name = $('#challenge_name').val();
                model.validateChallengeName(challenge_name, function (r) {
                    if (r.unique_name === false) {
                        $('#challenge_name').parents('.control-group').addClass('error');
                        error = true;
                    }

                    if (!$('#dl_subject_id').val()) {
                        $('#dl_subject_id').parents('.control-group').addClass('error');
                        error = true;
                    }
                    if (!$('#dl_skill_id').val()) {
                        $('#dl_skill_id').parents('.control-group').addClass('error');
                        error = true;
                    }
                    if (!$('#dl_topic_id').val()) {
                        $('#dl_topic_id').parents('.control-group').addClass('error');
                        error = true;
                    }
                    if (!$('#level').val()) {
                        $('#level').parents('.control-group').addClass('error');
                        error = true;
                    }
                    if (!$('#dl_game_id').val()) {
                        $('#dl_game_id').parents('.control-group').addClass('error');
                        error = true;
                    }
                    if (error === true) {
                        if (r.unique_name === false) {
                            error_msg = 'Challenge Name must be unique. Please enter new one.';
                        } else {
                            error_msg = 'You need to fill all fields on this page';
                        }
                        $.gritter.add({
                            title: 'Error',
                            text: error_msg
                        });
                    } else {
                        if ($('#is_read_passage').is(':checked')) {
                            $('#inverse').bootstrapWizard('display', 1);
                            $('#inverse').bootstrapWizard('show', 1);
                        } else {
                            $('#inverse').bootstrapWizard('show', 2);
                        }
                    }
                });
                return false;
//
            }
            if (index == 3) {
                $('.question_type').hide();
                // Make sure we entered the name
                if (!$('#question_type_selected').val()) {

                    $.gritter.add({
                        title: 'Error',
                        text: 'You need to choose question type'
                    });
                    return false;
                } else {
                    var selected = $('#question_type_selected').val();
                    //$('#' + selected).show();
                    var selected_index = selected.replace('question_type_', '');
                    question_type(selected_index, true);
                }
            }

//            if (index == 3) {
//
//                var selected_question_type = $('#question_type_selected').val().replace('question_type_', '');
//
//                var data = $('#challenge_form').serialize();
//
//                model.validateQuestionTypeByTypeIndex(selected_question_type, data, function (r) {
//
//                    if (r.validation !== true) {
//                        validate_any_question_type(r);
//
//                    } else {
//
//                        // going to fourth tab
//                        $('#inverse .pager .save').show();
//                        $('#inverse .pager .nextnext').hide();
//
//                        // go to tab 4
//                        $('#inverse').bootstrapWizard('show', 3);
////                        model.getClassesForChallengeBuilder(function (c) {
////                            $.each(c, function (k, v) {
////                                $('#class_id').append("<option value=" + v.class_id + ">" + v.class_name + "</option>");
////                            });
////                        });
//
//                        $('#save_challenge_wizard').unbind('click').click(function (e) {
//                            e.preventDefault();
//                            $('#save_and_add_new_question').empty();
//                            $('#challenge_form').submit();
//                        });
//
//                        $('#save_challenge_add_question_wizard').unbind('click').click(function (e) {
//                            e.preventDefault();
//
//                            $('#save_and_add_new_question').val('true');
//                            $('#challenge_form').submit();
//                        });
//                    }
//
//                });
//                return false;
//            }
        },
        onPrevious: function (tab, navigation, index) {
            $('#inverse .pager .save').hide();
            $('#inverse .pager .nextnext').show();
        },
        onLast: function (tab, navigation, index) {
        },
        onTabClick: function (tab, navigation, index) {
            return false;
        },
        onTabShow: function (tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;
            var $percent = ($current / $total) * 100;
            $('#inverse').find('.bar').css({
                width: $percent + '%'
            });
        }
    });
    $('#inverse').bootstrapWizard('hide', 1);

    // if save and add new question is selected
    if (url_segments[0] === 'question' && url_segments[1] === 'challenge' && url_segments[3] === 'add_new') {
        $('#addEditQuestion2').modal('show');
    }

//    $('#inverse').bootstrapWizard({
//        'tabClass': 'nav',
//        'debug': false,
//        onShow: function (tab, navigation, index) {
//        },
//        onNext: function (tab, navigation, index) {
//            if (index == 1) {
//                $('.error').removeClass('error');
//
//                var error = false;
//                if (!$('#challenge_name').val()) {
//                    $('#challenge_name').parents('.control-group').addClass('error');
//                    error = true;
//                }
//
//                //$('#dl_subject_id').val() === null
//                if (!$('#dl_subject_id').val()) {
//                    $('#dl_subject_id').parents('.control-group').addClass('error');
//                    error = true;
//                }
//                if (!$('#dl_skill_id').val()) {
//                    $('#dl_skill_id').parents('.control-group').addClass('error');
//                    error = true;
//                }
//                if (!$('#dl_topic_id').val()) {
//                    $('#dl_topic_id').parents('.control-group').addClass('error');
//                    error = true;
//                }
//                if (!$('#level').val()) {
//                    $('#level').parents('.control-group').addClass('error');
//                    error = true;
//                }
//                if (!$('#dl_game_id').val()) {
//                    $('#dl_game_id').parents('.control-group').addClass('error');
//                    error = true;
//                }
//                if (error === true) {
//                    $.gritter.add({
//                        title: 'Error',
//                        text: 'You need to fill all fields on this page'
//                    });
//                    return false;
//                } else {
//                    $('#inverse .pager .save').show();
//                    $('#inverse .pager .nextnext').hide();
//
////                    $('#inverse #inverse-tab1').hide();
////                    $('#inverse #inverse-tab2').show();
//
//                    model.getClassesForChallengeBuilder(function (c) {
//                        $.each(c, function (k, v) {
//                            $('#class_id').append("<option value=" + v.class_id + ">" + v.class_name + "</option>");
//                        });
//                    });
//
//                    $('#save_challenge_wizard').unbind('click').click(function (e) {
//                        e.preventDefault();
//
//                        // if save & close -> add_question = 0, if save & add question -> add_question = 1
//                        $('#add_question').val('0');
//
//                        var data = $('#challenge_form').serialize();
//                        model.saveChallengeWizard(data, function (r) {
//
//                            if (r.save_and_close === true) {
//                                window.location.reload();
//                            }
//                        });
//                    });
//
//                    $('#save_challenge_add_question_wizard').unbind('click').click(function (e) {
//                        e.preventDefault();
//
//                        // if save & close -> add_question = 0, if save & add question -> add_question = 1
//                        $('#add_question').val('1');
//
//                        var data = $('#challenge_form').serialize();
//                        model.saveChallengeWizard(data, function (r) {
//
//                            if (typeof r.challenge_id !== 'undefined') {
//
//                                $('#addEditChallenge').modal('hide');
//
//                                $('#addQuestion').modal('show');
//                                $('#inverse2 #inverse-tab1').show();
//                                $('#challenge_id').val(r.challenge_id);
//                            }
//                        });
//                    });
//                }
//            }
////            if (index == 2) {
////                $('.question_type').hide();
////                // Make sure we entered the name
////                if (!$('#question_type_selected').val()) {
////
////                    $.gritter.add({
////                        title: 'Error',
////                        text: 'You need to choose question type'
////                    });
////                    return false;
////                } else {
////                    var selected = $('#question_type_selected').val();
////                    //$('#' + selected).show();
////                    var selected_index = selected.replace('question_type_', '');
////                    question_type(selected_index, true);
////                }
////            }
//
////            if (index == 3) {
////
////                var selected_question_type = $('#question_type_selected').val().replace('question_type_', '');
////
////                var data = $('#challenge_form').serialize();
////
////                model.validateQuestionTypeByTypeIndex(selected_question_type, data, function (r) {
////
////                    if (r.validation !== true) {
////
////                        switch (parseInt(selected_question_type)) {
////                            case 1:
////                                question_type_1_validation(r);
////                                break;
////                            case 2:
////                                question_type_2_validation(r);
////                                break;
////                            case 3:
////                                question_type_3_validation(r);
////                                break;
////                            case 4:
////                                question_type_4_validation(r);
////                                break;
////                            case 5:
////                                question_type_5_validation(r);
////                                break;
////                            case 6:
////                                question_type_6_validation(r);
////                                break;
////                            case 7:
////                                question_type_7_validation(r);
////                                break;
////                            case 8:
////                                question_type_8_validation(r);
////                                break;
////                            case 9:
////                                question_type_9_validation(r);
////                                // TODO: this
////                                break;
////                        }
////
////                    } else {
////
////                        // going to fourth tab
////                        $('#inverse .pager .save').show();
////                        $('#inverse .pager .nextnext').hide();
////
////                        // go to tab 4
////                        $('#inverse').bootstrapWizard('show', 3);
////                        model.getClassesForChallengeBuilder(function (c) {
////                            $.each(c, function (k, v) {
////                                $('#class_id').append("<option value=" + v.class_id + ">" + v.class_name + "</option>");
////                            });
////                        });
////
////                        $('#save_challenge_wizard').unbind('click').click(function (e) {
////                            e.preventDefault();
////                            $('#challenge_form').submit();
////                        });
////                    }
////
////                });
////                return false;
////            }
//        },
//        onPrevious: function (tab, navigation, index) {
//            $('#inverse .pager .save').hide();
//            $('#inverse .pager .nextnext').show();
//
////            $('#inverse #inverse-tab1').show();
////            $('#inverse #inverse-tab2').hide();
//        },
//        onLast: function (tab, navigation, index) {
//        },
//        onTabClick: function (tab, navigation, index) {
//            return false;
//        },
//        onTabShow: function (tab, navigation, index) {
//            var $total = navigation.find('li').length;
//            var $current = index + 1;
//            var $percent = ($current / $total) * 100;
//            $('#inverse').find('.bar').css({
//                width: $percent + '%'
//            });
//        }
//    });

    $('#inverse .question_thumbs .thumbnail').unbind('click').click(function () {
        var index = $(this).parents('li').index() + 1;
        console.log('Selected type ' + index);

        $('#question_type_selected').val('question_type_' + index);

        $('.selected_question').removeClass('selected_question');
        $(this).addClass('selected_question');

        // go to next page of wizard when question type selected
        $('#inverse').bootstrapWizard('show', 3);
        var selected = $('#question_type_selected').val();

        var selected_index = selected.replace('question_type_', '');
        question_type(selected_index, true);

        $('#inverse .pager .save').show();
        $('#inverse .pager .nextnext').hide();

        $('#save_challenge_wizard, #save_challenge_add_question_wizard').unbind('click').click(function (e) {
            e.preventDefault();

            var data = $('#challenge_form').serialize();

            model.validateQuestionTypeByTypeIndex(selected_index, data, function (r) {
                if (r.validation !== true) {
                    validate_any_question_type(r);

                } else {
                    var clicked = e.currentTarget.id;

                    if (clicked === 'save_challenge_add_question_wizard') {
                        $('#save_and_add_new_question').val('true');
                    } else {
                        $('#save_and_add_new_question').empty();
                    }

                    $('#challenge_form').submit();
                }
            });
        });
    });

    //uninstall my challenge
    $('.uninstallMyChallange').unbind('click').click(function () {

        var id = $(this).data('id');

        $('#challenge_btn_uninstall').unbind('click').click(function (e) {
            e.preventDefault();
            model.uninstallChallengeById(id, function (r) {

                if (r.deleted === true) {
                    $('#uninstallChallenge .modal-header .close').click();
                    $('#my_challenge' + id).fadeOut(300, function () {
                        $(this).remove();
                    });
                } else {

                }
            });
        });
    });


    // delete my challenge
    $('.deleteMyChallenge').unbind('click').click(function () {

        var id = $(this).data('challenge-id');

        $('#challenge_btn_delete').unbind('click').click(function (e) {
            e.preventDefault();
            model.deleteChallengeById(id, function (r) {

                if (r.deleted === true) {
                    $('#uninstallChallenge .modal-header .close').click();
                    $('#my_challenge' + id).fadeOut(300, function () {
                        $(this).remove();
                    });
                    $('#deleteChallenge').modal('hide');
                } else {
                    $.gritter.add({
                        title: 'Error',
                        text: r.message
                    });
                    $('#deleteChallenge').modal('hide');
                }
            });
        });
    });

    function question_type_edit(selected) {

//        $('#question_type_' + selected + '_question_edit').live('keyup', function () {
//            $('#question_type_' + selected + '_question_preview_edit').html($(this).val());
//        });
//
//        // TODO: maybe find better solution for this
//        $('#question_type_' + selected + '_answer_1_edit').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_1_preview_edit').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_2_edit').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_2_preview_edit').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_3_edit').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_3_preview_edit').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_4_edit').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_4_preview_edit').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_5_edit').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_5_preview_edit').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_6_edit').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_6_preview_edit').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_7_edit').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_7_preview_edit').html($(this).val());
//        });
//
//        $('#question_type_' + selected + '_answer_8_edit').live('keyup', function () {
//            $('#question_type_' + selected + '_answer_8_preview_edit').html($(this).val());
//        });
//
//        $('#question_type_7_answer_edit').live('keyup', function () {
//            $('#question_type_7_answer_preview_edit').html($(this).val());
//        });
//
//        $('#question_type_8_answer_edit').live('keyup', function () {
//            $('#question_type_8_answer_preview_edit').html($(this).val());
//        });

        $('.question_type_' + selected + '_correct').change(function () {
            $('#question_type_' + selected + '_edit' + ' .answer').css('border', '1px solid black');

            var correct_index = $(this).val();
            $('#question_type_' + selected + '_answer_' + correct_index + '_preview_edit').css('border', '1px solid orange');
        });

        $('#question_type_7_answer_edit').forceNumericOnly();

        $('#question_type_8_answer_edit').forceNumericOnly();

        if (selected === '9') {
            var order_radio_1 = $('input[name=question_type_9_order_1]:checked').val();
            var order_radio_2 = $('input[name=question_type_9_order_2]:checked').val();
            var order_radio_3 = $('input[name=question_type_9_order_3]:checked').val();
            var order_radio_4 = $('input[name=question_type_9_order_4]:checked').val();
            var order = order_radio_1 + ',' + order_radio_2 + ',' + order_radio_3 + ',' + order_radio_4;
            $('#question_type_9_correct_text_edit').val(order);
        }

        if (selected === '15') {
            var order_radio_1 = $('input[name=question_type_15_order_1]:checked').val();
            var order_radio_2 = $('input[name=question_type_15_order_2]:checked').val();
            var order_radio_3 = $('input[name=question_type_15_order_3]:checked').val();
            var order_radio_4 = $('input[name=question_type_15_order_4]:checked').val();
            var order = order_radio_1 + ',' + order_radio_2 + ',' + order_radio_3 + ',' + order_radio_4;
            $('#question_type_15_correct_text_edit').val(order);
        }
    }

    // question edit
    $('.mod-challenge-question .edit').unbind('click').click(function () {

        var t = $(this);
        var id = t.data('id');
        var question_type_name = t.data('questiontype');
        var type = parseInt(question_type_name.replace('question_type_', ''));
        var base_image_url = BASEURL + 'question/display_question_image/';
        var base_choice_image_url = BASEURL + 'question/display_choice_image/';
        var challenge_choice_image_url = BASEURL + 'challenge/display_choice_image/';

        // because of plupload enter key is disabled for these forms
        $('#question_type_3_edit').disableEnter();
        $('#question_type_4_edit').disableEnter();
        $('#question_type_5_edit').disableEnter();
        $('#question_type_8_edit').disableEnter();
        $('#question_type_10_edit').disableEnter();
        $('#question_type_11_edit').disableEnter();
        $('#question_type_12_edit').disableEnter();

        // scroll to top because modal is not position fixed
        moveToTop();

        question_type_edit(type);

        $('#edit_question_id_' + type + '_edit').val(id);

        //$('#' + question_type_name + '_edit').show();
        $('.question_type').hide();

        model.getQuestionDetailsById(id, function (r) {

            switch (type) {
                case 1:
                    $('#question_type_1_edit').show();
                    $('#question_type_1_question_edit').val(r.question_text);
                    $('#question_type_1_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_1_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_1_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }
                        $('#question_type_1_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_1_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    break;
                case 2:
                    $('#question_type_2_edit').show();
                    $('#question_type_2_question_edit').val(r.question_text);
                    $('#question_type_2_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_2_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_2_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }
                        $('#question_type_2_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_2_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    break;
                case 3:
                    $('#question_type_3_edit').show();
                    $('#question_type_3_question_edit').val(r.question_text);
                    $('#question_type_3_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_3_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_3_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }
                        $('#question_type_3_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_3_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    var image_url = base_image_url + r.question_image;
                    $('#question_type_3_image_preview_edit .image_holder img').attr('src', image_url);
                    break;
                case 4:
                    $('#question_type_4_edit').show();
                    $('#question_type_4_question_edit').val(r.question_text);
                    $('#question_type_4_question_preview_edit').html(r.question_text);

                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_4_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_4_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }

                        var image_url = base_choice_image_url + v.answer_image;

                        $('#question_type_4_answer_' + (k + 1) + '_preview_edit .image_holder_4 img').attr('src', image_url);
                    });
                    break;
                case 5:
                    $('#question_type_5_edit').show();
                    $('#question_type_5_question_edit').val(r.question_text);
                    $('#question_type_5_question_preview_edit').html(r.question_text);

                    var image_question_url = base_image_url + r.question_image;
                    $('#question_type_5_image_preview_edit .image_holder_5_question img').attr('src', image_question_url);

                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_5_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_5_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }

                        var image_url = base_choice_image_url + v.answer_image;

                        $('#question_type_5_answer_' + (k + 1) + '_preview_edit .image_holder_5 img').attr('src', image_url);
                    });
                    break;
                case 6:
                    $('#question_type_6_edit').show();
                    $('#question_type_6_question_edit').val(r.question_text);
                    $('#question_type_6_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_6_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_6_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }
                        $('#question_type_6_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_6_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    break;
                case 7:
                    $('#question_type_7_edit').show();
                    $('#question_type_7_question_edit').val(r.question_text);
                    $('#question_type_7_question_preview_edit').html(r.question_text);

                    $('#question_type_7_answer_edit').val(r.correct_text);
                    $('#question_type_7_answer_preview_edit').html(r.correct_text);
                    break;
                case 8:
                    $('#question_type_8_edit').show();
                    $('#question_type_8_question_edit').val(r.question_text);
                    $('#question_type_8_question_preview_edit').html(r.question_text);

                    var image_question_url = base_image_url + r.question_image;
                    $('#question_type_8_question_image_preview_edit .image_holder_8_question img').attr('src', image_question_url);

                    $('#question_type_8_answer_edit').val(r.correct_text);
                    $('#question_type_8_answer_preview_edit').html(r.correct_text);
                    break;
                case 9:
                    $('#question_type_9_edit').show();
                    $('#question_type_9_question_edit').val(r.question_text);
                    $('#question_type_9_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        $('#question_type_9_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_9_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });

                    var list = r.correct_text.split(',');

                    var min = (Math.min.apply(Math, list) - 1);

                    var order_slider_correct = [];
                    $.each(list, function (k, v) {
                        order_slider_correct.push(v - min);
                    });

                    // set radios
                    $('#question_type_9_form_edit input:radio[name="question_type_9_order_1"]').filter('[value="' + order_slider_correct[0] + '"]').attr('checked', true);
                    $('#question_type_9_form_edit input:radio[name="question_type_9_order_2"]').filter('[value="' + order_slider_correct[1] + '"]').attr('checked', true);
                    $('#question_type_9_form_edit input:radio[name="question_type_9_order_3"]').filter('[value="' + order_slider_correct[2] + '"]').attr('checked', true);
                    $('#question_type_9_form_edit input:radio[name="question_type_9_order_4"]').filter('[value="' + order_slider_correct[3] + '"]').attr('checked', true);

                    var order_radio_1 = $('input[name=question_type_9_order_1]:checked').val();
                    var order_radio_2 = $('input[name=question_type_9_order_2]:checked').val();
                    var order_radio_3 = $('input[name=question_type_9_order_3]:checked').val();
                    var order_radio_4 = $('input[name=question_type_9_order_4]:checked').val();

                    $('#question_type_9_answer_' + order_radio_1 + '_preview_ordered_edit').html($('#question_type_9_answer_1_edit').val());
                    $('#question_type_9_answer_' + order_radio_2 + '_preview_ordered_edit').html($('#question_type_9_answer_2_edit').val());
                    $('#question_type_9_answer_' + order_radio_3 + '_preview_ordered_edit').html($('#question_type_9_answer_3_edit').val());
                    $('#question_type_9_answer_' + order_radio_4 + '_preview_ordered_edit').html($('#question_type_9_answer_4_edit').val());

                    order_slider_correct = order_slider_correct.toString();

                    // set order hidden text field
                    $('#question_type_9_correct_text_edit').val(order_slider_correct);

                    var image_url = base_image_url + r.question_image;
                    $('#question_type_9_image_preview_edit .image_holder img').attr('src', image_url);
                    break;
                case 10:
                    $('#question_type_10_edit').show();
                    $('#question_type_10_question_edit').val(r.question_text);
                    $('#question_type_10_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_10_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_10_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }
                        $('#question_type_10_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_10_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    var image_url = base_image_url + r.question_image;
                    $('#question_type_10_image_preview_edit .image_holder img').attr('src', image_url);
                    break;
                case 11:
                    console.log('preparing modal for QT 11 edit');
                    $('#question_type_11_edit').show();
                    $('#question_type_11_question_edit').val(r.question_text);
                    $('#question_type_11_question_preview_edit').html(r.question_text);

                    var image_question_url = base_image_url + r.question_image;
                    $('#question_type_11_image_preview_edit .image_holder_11_question img').attr('src', image_question_url);

                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_11_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_11_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }

                        var image_url = base_choice_image_url + v.answer_image;

                        $('#question_type_11_answer_' + (k + 1) + '_preview_edit .image_holder_11 img').attr('src', image_url);
                    });
                    break;
                case 12:
                    $('#question_type_12_edit').show();
                    $('#question_type_12_question_edit').val(r.question_text);
                    $('#question_type_12_question_preview_edit').html(r.question_text);

                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_12_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_12_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }

                        var image_url = base_choice_image_url + v.answer_image;

                        $('#question_type_12_answer_' + (k + 1) + '_preview_edit .image_holder_12 img').attr('src', image_url);
                    });
                    break;
                case 13:
                    $('#question_type_13_edit').show();
                    $('#question_type_13_question_edit').val(r.question_text);
                    $('#question_type_13_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_13_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_13_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }
                        $('#question_type_13_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_13_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    break;
                case 14:
                    $('#question_type_14_edit').show();
                    $('#question_type_14_question_edit').val(r.question_text);
                    $('#question_type_14_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_14_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_14_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }
                        $('#question_type_14_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_14_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    break;
                case 15:
                    $('#question_type_15_edit').show();
                    $('#question_type_15_question_edit').val(r.question_text);
                    $('#question_type_15_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        $('#question_type_15_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_15_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });

                    var list = r.correct_text.split(',');

                    var min = (Math.min.apply(Math, list) - 1);

                    var order_slider_correct = [];
                    $.each(list, function (k, v) {
                        p = v - min;
                        p = (p > 4) ? 4 : p;
                        order_slider_correct.push(p);
                    });
                    console.log(order_slider_correct);
                    console.log(r.answers);

                    // set radios
                    $('#question_type_15_form_edit input:radio[name="question_type_15_order_1"]').filter('[value="' + order_slider_correct[0] + '"]').attr('checked', true);
                    $('#question_type_15_form_edit input:radio[name="question_type_15_order_2"]').filter('[value="' + order_slider_correct[1] + '"]').attr('checked', true);
                    $('#question_type_15_form_edit input:radio[name="question_type_15_order_3"]').filter('[value="' + order_slider_correct[2] + '"]').attr('checked', true);
                    $('#question_type_15_form_edit input:radio[name="question_type_15_order_4"]').filter('[value="' + order_slider_correct[3] + '"]').attr('checked', true);

                    var order_radio_1 = $('input[name=question_type_15_order_1]:checked').val();
                    var order_radio_2 = $('input[name=question_type_15_order_2]:checked').val();
                    var order_radio_3 = $('input[name=question_type_15_order_3]:checked').val();
                    var order_radio_4 = $('input[name=question_type_15_order_4]:checked').val();

                    $('#question_type_15_answer_' + order_radio_1 + '_preview_ordered_edit').html($('#question_type_15_answer_1_edit').val());
                    $('#question_type_15_answer_' + order_radio_2 + '_preview_ordered_edit').html($('#question_type_15_answer_2_edit').val());
                    $('#question_type_15_answer_' + order_radio_3 + '_preview_ordered_edit').html($('#question_type_15_answer_3_edit').val());
                    $('#question_type_15_answer_' + order_radio_4 + '_preview_ordered_edit').html($('#question_type_15_answer_4_edit').val());

                    order_slider_correct = order_slider_correct.toString();

                    // set order hidden text field
                    $('#question_type_15_correct_text_edit').val(order_slider_correct);
                    break;
                case 16:
                    $('#question_type_16_edit').show();
                    $('#question_type_16_question_edit').val(r.question_text);
                    $('#question_type_16_question_preview_edit').html(r.question_text);

                    $('#question_type_16_answer_edit').val(r.correct_text);
                    $('#question_type_16_answer_preview_edit').html(r.correct_text);

                    $('#question_type_16_read_text_edit').val(r.read_text);
                    $('#question_type_16_read_text_preview_edit').html(r.read_text);
                    break;
            }
        });

    });

    // tooltips in content builder
    $('.thumbnail_challenge_question').hover(function () {
        var tooltip_content = $(this).siblings('.tooltip_content').html();
        var tooltip_html = $('<div style="width: 450px">' + tooltip_content + '</div>');

        $('.thumbnail_challenge_question').data('powertipjq', tooltip_html);
    });

    $('.thumbnail_challenge_question').powerTip({
        placement: 'e',
        smartPlacement: true,
        mouseOnToPopup: true
    });

    $('.thumbnail_challenge').hover(function () {
        var tooltip_content = $(this).parents().siblings('.tooltip_content').html();
        var tooltip_html = $('<div style="width: 380px">' + tooltip_content + '</div>');
        $('.thumbnail_challenge').data('powertipjq', tooltip_html);
    });

    $('.thumbnail_challenge').powerTip({
        placement: 'e',
        smartPlacement: true,
        mouseOnToPopup: true
    });

    $('.marketplace_thumb').hover(function () {
        var tooltip_content = $(this).parents('.challenge').next().html();
        var tooltip_html = $('<div style="width: 380px">' + tooltip_content + '</div>');
        $('.thumbnail_challenge').data('powertipjq', tooltip_html);
    });

    $('.marketplace_thumb').powerTip({
        placement: 'e',
        smartPlacement: true,
        mouseOnToPopup: true
    });

    $('#addNewQuestion2').unbind('click').click(function () {
//        $('.question_type').hide();
//        $('#question_selector option:first-child').attr('selected', true);

        // scroll to top because modal is not position fixed
        moveToTop();

        // because of plupload enter key is disabled for inputs in this form
        $('#inverse-tab2').disableEnter();

        // make sure you are on first tab of wizard
        $('#inverse2').bootstrapWizard('show', 0);
        $('#inverse2 .pager .previous').hide();
        $('#inverse2 .pager .save').hide();
        $('#inverse2 .pager .nextnext').show();
    });

    // add new question wizard
    $('#inverse2').bootstrapWizard({
        'tabClass': 'nav',
        'debug': false,
        onShow: function (tab, navigation, index) {

        },
        onNext: function (tab, navigation, index) {

            if (index == 1) {
                $('.question_type').hide();
                // Make sure we entered the name
                if (!$('#question_type_selected').val()) {

                    $.gritter.add({
                        title: 'Error',
                        text: 'You need to choose question type'
                    });
                    return false;
                } else {
                    var selected = $('#question_type_selected').val();

                    var form_action_url = BASEURL + 'question/save_' + selected;
                    $("#question_form").attr("action", form_action_url);

                    var selected_index = selected.replace('question_type_', '');
                    question_type(selected_index, true);

                    // going to second tab
                    $('#inverse2 .pager .save').show();
                    $('#inverse2 .pager .nextnext').hide();

                }
            }

        },
        onPrevious: function (tab, navigation, index) {
            $('#inverse2 .pager .save').hide();
            $('#inverse2 .pager .nextnext').show();
            $('#inverse2 .pager .previous').hide();
        },
        onLast: function (tab, navigation, index) {
        },
        onTabClick: function (tab, navigation, index) {
            return false;
        },
        onTabShow: function (tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;
            var $percent = ($current / $total) * 100;
            $('#inverse2').find('.bar').css({
                width: $percent + '%'
            });
        }
    });

    $('#save_question_wizard, #save_add_new_question_wizard').unbind('click').click(function (e) {
        e.preventDefault();

        var selected_question_type = $('#question_type_selected').val().replace('question_type_', '');

        var data = $('#question_form').serialize();

        var order_radio_1 = $('input[name=question_type_9_order_1]:checked').val();
        var order_radio_2 = $('input[name=question_type_9_order_2]:checked').val();
        var order_radio_3 = $('input[name=question_type_9_order_3]:checked').val();
        var order_radio_4 = $('input[name=question_type_9_order_4]:checked').val();

        var order_array = [order_radio_1, order_radio_2, order_radio_3, order_radio_4];

        var order_radio_15_1 = $('input[name=question_type_15_order_1]:checked').val();
        var order_radio_15_2 = $('input[name=question_type_15_order_2]:checked').val();
        var order_radio_15_3 = $('input[name=question_type_15_order_3]:checked').val();
        var order_radio_15_4 = $('input[name=question_type_15_order_4]:checked').val();

        var order_array_15 = [order_radio_15_1, order_radio_15_2, order_radio_15_3, order_radio_15_4];

        reset_crop_image_environment();
        set_zoom_slider_value('#image_zoom_slider', 100);

        if ($.unique(order_array).length !== 4 || $.unique(order_array_15).length !== 4) {
            $.gritter.add({
                title: 'Error',
                text: "Order of answers can't be on the same position"
            });
        } else {
            model.validateQuestionTypeByTypeIndex(selected_question_type, data, function (r) {

                if (r.validation !== true) {
                    validate_any_question_type(r);
                } else {
                    if (parseInt(selected_question_type) === 9) {

                        var unique = order_array.filter(function (itm, i, a) {
                            return i == a.indexOf(itm);
                        });

                        if (unique.length !== 4) {
                            $.gritter.add({
                                title: 'Error',
                                text: "Order of answers can't be on the same position"
                            });
                        } else {
                            if (e.target.id === 'save_question_wizard') {
                                $('#add_new_question').val(0);
                            } else if (e.target.id === 'save_add_new_question_wizard') {
                                $('#add_new_question').val(1);
                            }

                            var order = order_radio_1 + ',' + order_radio_2 + ',' + order_radio_3 + ',' + order_radio_4;
                            $('#question_type_9_correct_text').val(order);
                            var data = $('#question_form').serialize();
                            var challenge_id = $('#challenge_id').val()
                            model.saveQuestionByUrl('save_' + $('#question_type_selected').val(), data, function (r) {
                                if (r.close === true) {
                                    window.location.href = BASEURL + 'question/challenge/' + challenge_id;
                                } else {

                                    clearFormFields('#inverse-tab2');
                                    $('.thumbnail').removeClass('selected_question');

                                    $('#inverse2').bootstrapWizard('show', 0);
                                    $('#inverse2 .pager .save').hide();
                                    $('#inverse2 .pager .nextnext').show();
//                                    clearQuestionPreviews();

                                    // fix because clearQuestionPreviews(); is not in function any more
                                    $('#question_type_9_image img').removeAttr('src');
                                }
                            });
                        }
                    } else if (parseInt(selected_question_type) === 15) {
                        var unique = order_array_15.filter(function (itm, i, a) {
                            return i == a.indexOf(itm);
                        });

                        if (unique.length !== 4) {
                            $.gritter.add({
                                title: 'Error',
                                text: "Order of answers can't be on the same position"
                            });
                        } else {
                            if (e.target.id === 'save_question_wizard') {
                                $('#add_new_question').val(0);
                            } else if (e.target.id === 'save_add_new_question_wizard') {
                                $('#add_new_question').val(1);
                            }

                            var order = order_radio_15_1 + ',' + order_radio_15_2 + ',' + order_radio_15_3 + ',' + order_radio_15_4;
                            $('#question_type_15_correct_text').val(order);
                            var data = $('#question_form').serialize();
                            var challenge_id = $('#challenge_id').val()
                            model.saveQuestionByUrl('save_' + $('#question_type_selected').val(), data, function (r) {
                                if (r.close === true) {
                                    window.location.href = BASEURL + 'question/challenge/' + challenge_id;
                                } else {

                                    clearFormFields('#inverse-tab2');
                                    $('.thumbnail').removeClass('selected_question');

                                    $('#inverse2').bootstrapWizard('show', 0);
                                    $('#inverse2 .pager .save').hide();
                                    $('#inverse2 .pager .nextnext').show();
//                                    clearQuestionPreviews();

                                }
                            });
                        }
                    } else {
                        //$('#question_form').submit();

                        if (e.target.id === 'save_question_wizard') {
                            $('#add_new_question').val(0);
                        } else if (e.target.id === 'save_add_new_question_wizard') {
                            $('#add_new_question').val(1);
                        }

                        var data = $('#question_form').serialize();
                        var challenge_id = $('#challenge_id').val();
                        model.saveQuestionByUrl('save_' + $('#question_type_selected').val(), data, function (r) {

                            if (r.close === true) {
                                window.location.href = BASEURL + 'question/challenge/' + challenge_id;
                            } else {

                                clearFormFields('#inverse-tab2');
                                $('.thumbnail').removeClass('selected_question');

                                $('#inverse2').bootstrapWizard('show', 0);
                                $('#inverse2 .pager .save').hide();
                                $('#inverse2 .pager .nextnext').show();
//                            clearQuestionPreviews();
                            }
                        });

                    }
                }

            });
        }
    });

    $('#addQuestion').on('hide', function (e) {
        e.preventDefault();
        window.location.reload();
    });


    $('#addEditQuestion2').on('hide', function (e) {
        e.preventDefault();
        var url = window.location.href.replace('add_new', '');

//        window.location.reload();
        window.location.href = url;
    });

    $('#inverse2 .question_thumbs .thumbnail').unbind('click').click(function () {
        var index = $(this).parents('li').index() + 1;
        console.log('Selected type when creating question ' + index);

        $('#question_type_selected').val('question_type_' + index);

        $('.selected_question').removeClass('selected_question');
        $(this).addClass('selected_question');

        var selected = $('#question_type_selected').val();

        var form_action_url = BASEURL + 'question/save_' + selected;
        $("#question_form").attr("action", form_action_url);

        var selected_index = selected.replace('question_type_', '');
        question_type(selected_index, true);

        // going to second tab
        $('#inverse2').bootstrapWizard('show', 1);
        $('#inverse2 .pager .save').show();
        $('#inverse2 .pager .nextnext').hide();
        $('#inverse2 .pager .previous').not('.first').show();

        var navigation = $('.container .nav');
        var $total = navigation.find('li').length;
        var $current = index + 1;
        var $percent = ($current / $total) * 100;
        $('#inverse2').find('.bar').css({
            width: $percent + '%'
        });

        $('#inverse2 #inverse-tab2 .question_type .img_to_upload').removeAttr('src');
        $('#cropModal #crop_wrapper #crop_image_wrapper #crop_image').removeAttr('src');

        $('#inverse-tab1').removeClass('active');
        $('#inverse-tab2').addClass('active');
    });

    // marketplace filters
    $('#challenge_filter_grade_selector, #challenge_filter_subject_selector, #challenge_filter_topic_selector, #challenge_filter_my_only').change(function (e) {
        var selected_grade = $('#challenge_filter_grade_selector').val();
        var selected_subject = $('#challenge_filter_subject_selector').val();
        var selected_skill = $('#challenge_filter_topic_selector').val();
        var checked_my_only = $('#challenge_filter_my_only').is(':checked');

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
        var my_only = '';

        if (selected_grade !== 'all') {
            grade = '[data-grade="' + selected_grade + '"]';
        }

        if (selected_subject !== 'all') {
            subject = '[data-subjectid="' + selected_subject + '"]';
        }

        if (selected_skill !== 'all') {
            skill = '[data-skill-id="' + selected_skill + '"]';
        }

        if (checked_my_only) {
            my_only = '[data-user-id="' + CURR_USER_ID + '"]';
        }

        $('#challenge_filter_challenges_list .challenge').fadeOut();
        if (selected_grade === 'all' && selected_subject === 'all' && selected_skill === 'all') {
            $('#challenge_filter_challenges_list .challenge').fadeOut('slow', function(){
                $('#challenge_filter_intro').fadeIn('slow');
            });
        } else {
            if ($('#challenge_filter_intro').css('display') === 'none') {
                $('#challenge_filter_challenges_list .challenge' + grade + subject + skill + my_only).fadeIn('slow');
            } else {
                $('#challenge_filter_intro').fadeOut('slow', function(){
                    $('#challenge_filter_challenges_list .challenge' + grade + subject + skill + my_only).fadeIn('slow');
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

    // because of the plupload in some forms this needs to be called
    function disable_enter_key_for_children(element) {
        $(element).keypress(function (e) {
            if (e.keyCode == 10 || e.keyCode == 13)
                e.preventDefault();
        });
    }

    jQuery.fn.disableEnter = function (element) {
        if (typeof element === 'undefined') {
            element = this;
        }
        $(element).keypress(function (e) {
            if (e.keyCode == 10 || e.keyCode == 13)
                e.preventDefault();
        });
    };

    (function ($) {
        $.fn.extend({
            limiter: function (limit, elem) {
                $(this).on("keyup focus", function () {
                    setCount(this, elem);
                });
                function setCount(src, elem) {
                    var chars = src.value.length;
                    if (chars > limit) {
                        src.value = src.value.substr(0, limit);
                        chars = limit;
                    }
                    elem.html(limit - chars);
                }

                setCount($(this)[0], elem);
            }
        });
    })(jQuery);

    // add new question in admin panel
    $('#addNewQuestionAdmin').unbind('click').click(function () {
        // scroll to top because modal is not position fixed
        moveToTop();

        // because of plupload enter key is disabled for inputs in this form
        $('#inverse-tab2').disableEnter();

        model.getAllChallenges(function (r) {
            $.each(r, function (key, value) {
                $('#challenge_id').append("<option value=" + value.challenge_id + ">" + value.challenge_name + "</option>");
            });
        });

        // make sure you are on first tab of wizard
        $('#inverse2_admin').bootstrapWizard('show', 0);
        $('#inverse2_admin .pager .save').hide();
        $('#inverse2_admin .pager .nextnext').show();
    });

    // add new question wizard
    $('#inverse2_admin').bootstrapWizard({
        'tabClass': 'nav',
        'debug': false,
        onShow: function (tab, navigation, index) {

        },
        onNext: function (tab, navigation, index) {

            if (index == 1) {
                $('.question_type').hide();
                // Make sure we entered the name
                if (!$('#question_type_selected').val()) {

                    $.gritter.add({
                        title: 'Error',
                        text: 'You need to choose question type'
                    });
                    return false;
                } else {
                    var selected = $('#question_type_selected').val();

                    var form_action_url = BASEURL + 'question/save_' + selected;
                    $("#question_form").attr("action", form_action_url);

                    var selected_index = selected.replace('question_type_', '');
                    question_type(selected_index, true);

                    // going to second tab
                    $('#inverse2_admin .pager .save').show();
                    $('#inverse2_admin .pager .nextnext').hide();
                }
            }

        },
        onPrevious: function (tab, navigation, index) {
            $('#inverse2_admin .pager .save').hide();
            $('#inverse2_admin .pager .nextnext').show();
        },
        onLast: function (tab, navigation, index) {
        },
        onTabClick: function (tab, navigation, index) {
            return false;
        },
        onTabShow: function (tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;
            var $percent = ($current / $total) * 100;
            $('#inverse2_admin').find('.bar').css({
                width: $percent + '%'
            });
        }
    });

    $('#inverse2_admin .question_thumbs .thumbnail').unbind('click').click(function () {
        var index = $(this).parents('li').index() + 1;

        $('#question_type_selected').val('question_type_' + index);

        $('.selected_question').removeClass('selected_question');
        $(this).addClass('selected_question');
    });

    $('#save_question_wizard_admin').unbind('click').click(function (e) {
        e.preventDefault();

        var selected_question_type = $('#question_type_selected').val().replace('question_type_', '');

        var data = $('#question_form').serialize();

        model.validateQuestionTypeByTypeIndex(selected_question_type, data, function (r) {

            if (r.validation !== true) {
                validate_any_question_type(r);
//                switch (parseInt(selected_question_type)) {
//                    case 1:
//                        question_type_1_validation(r);
//                        break;
//                    case 2:
//                        question_type_2_validation(r);
//                        break;
//                    case 3:
//                        question_type_3_validation(r);
//                        break;
//                    case 4:
//                        question_type_4_validation(r);
//                        break;
//                    case 5:
//                        question_type_5_validation(r);
//                        break;
//                    case 6:
//                        question_type_6_validation(r);
//                        break;
//                    case 7:
//                        question_type_7_validation(r);
//                        break;
//                    case 8:
//                        question_type_8_validation(r);
//                        break;
//                    case 9:
//                        question_type_9_validation(r);
//                        // TODO: this
//                        break;
//                }

            } else {
                $('#question_form').submit();
            }

        });
    });

    // edit question in admin panel
    $('.mod-question-admin .edit').unbind('click').click(function () {
        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        var base_image_url = BASEURL + 'question/display_question_image/';
        var base_choice_image_url = BASEURL + 'question/display_choice_image/';

        // because of plupload enter key is disabled for these forms
        $('#question_type_3_edit').disableEnter();
        $('#question_type_4_edit').disableEnter();
        $('#question_type_5_edit').disableEnter();
        $('#question_type_8_edit').disableEnter();
        $('#question_type_10_edit').disableEnter();
        $('#question_type_11_edit').disableEnter();
        $('#question_type_12_edit').disableEnter();

        // scroll to top because modal is not position fixed
        //moveToTop();

        $('.question_type').hide();

        model.getQuestionDetailsById(id, function (r) {

            var t = $(this);
            var question_type_name = r.question_type;
            var type = parseInt(question_type_name.replace('question_type_', ''));

            question_type_edit(type);

            $('#edit_question_id_' + type + '_edit').val(id);

            //$('#' + r.question_type + '_edit').slideDown();

            $('#challenge_id_' + type + '_edit').val(r.challenge_id);

            switch (type) {
                case 1:
                    $('#question_type_1_edit').show();
                    $('#question_type_1_question_edit').val(r.question_text);
                    $('#question_type_1_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_1_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_1_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }
                        $('#question_type_1_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_1_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    break;
                case 2:
                    $('#question_type_2_edit').show();
                    $('#question_type_2_question_edit').val(r.question_text);
                    $('#question_type_2_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_2_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_2_answer_' + (k + 1) + '_preview_edit').css('border', '1px solid orange');
                        }
                        $('#question_type_2_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_2_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    break;
                case 3:
                    $('#question_type_3_edit').show();
                    $('#question_type_3_question_edit').val(r.question_text);
                    $('#question_type_3_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_3_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_3_answer_' + (k + 1) + '_preview_edit').css('border', '1px solid orange');
                        }
                        $('#question_type_3_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_3_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    var image_url = base_image_url + r.question_image;
                    $('#question_type_3_image_preview_edit .image_holder img').attr('src', image_url);
                    break;
                case 4:
                    $('#question_type_4_edit').show();
                    $('#question_type_4_question_edit').val(r.question_text);
                    $('#question_type_4_question_preview_edit').html(r.question_text);

                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_4_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_4_answer_' + (k + 1) + '_preview_edit').css('border', '1px solid orange');
                        }

                        var image_url = base_choice_image_url + v.answer_image;

                        $('#question_type_4_answer_' + (k + 1) + '_preview_edit .image_holder_4 img').attr('src', image_url);
                    });
                    break;
                case 5:
                    $('#question_type_5_edit').show();
                    $('#question_type_5_question_edit').val(r.question_text);
                    $('#question_type_5_question_preview_edit').html(r.question_text);

                    var image_question_url = base_image_url + r.question_image;
                    $('#question_type_5_image_preview_edit .image_holder_5_question img').attr('src', image_question_url);

                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_5_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_5_answer_' + (k + 1) + '_preview_edit').css('border', '1px solid orange');
                        }

                        var image_url = base_choice_image_url + v.answer_image;

                        $('#question_type_5_answer_' + (k + 1) + '_preview_edit .image_holder_5 img').attr('src', image_url);
                    });
                    break;
                case 6:
                    $('#question_type_6_edit').show();
                    $('#question_type_6_question_edit').val(r.question_text);
                    $('#question_type_6_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_6_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_6_answer_' + (k + 1) + '_preview_edit').css('border', '1px solid orange');
                        }
                        $('#question_type_6_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_6_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    break;
                case 7:
                    $('#question_type_7_edit').show();
                    $('#question_type_7_question_edit').val(r.question_text);
                    $('#question_type_7_question_preview_edit').html(r.question_text);

                    $('#question_type_7_answer_edit').val(r.correct_text);
                    $('#question_type_7_answer_preview_edit').html(r.correct_text);
                    break;
                case 8:
                    $('#question_type_8_edit').show();
                    $('#question_type_8_question_edit').val(r.question_text);
                    $('#question_type_8_question_preview_edit').html(r.question_text);

                    var image_question_url = base_image_url + r.question_image;
                    $('#question_type_8_image_preview_edit .image_holder img').attr('src', image_question_url);

                    $('#question_type_8_answer_edit').val(r.correct_text);
                    $('#question_type_8_answer_preview_edit').html(r.correct_text);
                    break;
                case 9:
                    // TODO: this
                    break;
                case 10:
                    $('#question_type_10_edit').show();
                    $('#question_type_10_question_edit').val(r.question_text);
                    $('#question_type_10_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_10_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_10_answer_' + (k + 1) + '_preview_edit').css('border', '1px solid orange');
                        }
                        $('#question_type_10_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_10_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    var image_url = base_image_url + r.question_image;
                    $('#question_type_10_image_preview_edit .image_holder img').attr('src', image_url);
                    break;
                case 11:
                    $('#question_type_11_edit').show();
                    $('#question_type_11_question_edit').val(r.question_text);
                    $('#question_type_11_question_preview_edit').html(r.question_text);

                    var image_question_url = base_image_url + r.question_image;
                    $('#question_type_11_image_preview_edit .image_holder_11_question img').attr('src', image_question_url);

                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_11_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_11_answer_' + (k + 1) + '_preview_edit').css('border', '1px solid orange');
                        }

                        var image_url = base_choice_image_url + v.answer_image;

                        $('#question_type_11_answer_' + (k + 1) + '_preview_edit .image_holder_11 img').attr('src', image_url);
                    });
                    break;
                case 12:
                    $('#question_type_12_edit').show();
                    $('#question_type_12_question_edit').val(r.question_text);
                    $('#question_type_12_question_preview_edit').html(r.question_text);

                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_12_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_12_answer_' + (k + 1) + '_preview_edit').css('border', '1px solid orange');
                        }

                        var image_url = base_choice_image_url + v.answer_image;

                        $('#question_type_12_answer_' + (k + 1) + '_preview_edit .image_holder_12 img').attr('src', image_url);
                    });
                    break;
                case 13:
                    $('#question_type_13_edit').show();
                    $('#question_type_13_question_edit').val(r.question_text);
                    $('#question_type_13_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_13_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_13_answer_' + (k + 1) + '_preview_edit').addClass('correct_answer');
                        }
                        $('#question_type_13_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_13_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    break;
                case 14:
                    $('#question_type_14_edit').show();
                    $('#question_type_14_question_edit').val(r.question_text);
                    $('#question_type_14_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_14_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_14_answer_' + (k + 1) + '_preview_edit').css('border', '1px solid orange');
                        }
                        $('#question_type_14_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_14_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    break;
                case 15:
                    $('#question_type_15_edit').show();
                    $('#question_type_15_question_edit').val(r.question_text);
                    $('#question_type_15_question_preview_edit').html(r.question_text);
                    $.each(r.answers, function (k, v) {
                        if (v.correct === true) {
                            $('#question_type_15_correct_' + (k + 1) + '_edit').attr('checked', true);
                            $('#question_type_15_answer_' + (k + 1) + '_preview_edit').css('border', '1px solid orange');
                        }
                        $('#question_type_15_answer_' + (k + 1) + '_edit').val(v.text);
                        $('#question_type_15_answer_' + (k + 1) + '_preview_edit').html(v.text);
                    });
                    break;
                case 16:
                    $('#question_type_16_edit').show();
                    $('#question_type_16_question_edit').val(r.question_text);
                    $('#question_type_16_question_preview_edit').html(r.question_text);

                    $('#question_type_16_answer_edit').val(r.correct_text);
                    $('#question_type_16_answer_preview_edit').html(r.correct_text);

                    $('#question_type_16_read_text_edit').val(r.read_text);
                    $('#question_type_16_read_text_preview_edit').html(r.read_text);
                    break;
            }
        });

        moveToTop();
    });

    // add new challenge in admin panel
    $('#addNewChallengeAdmin').unbind('click').click(function () {
        // description character limit

        var elem = $("#chars_edit");
        $('#description_edit').limiter(description_limter, elem);

        $('#class_id').html('<option value="0" selected="selected" disabled="disabled">Select class...</option>');
        $('#level_edit').html('' +
            '<option value="-2">Pre k</option>' +
            '<option value="-1">K</option>' +
            '<option value="1">1</option>' +
            '<option value="2">2</option>' +
            '<option value="3">3</option>' +
            '<option value="4">4</option>' +
            '<option value="5">5</option>' +
            '<option value="6">6</option>' +
            '<option value="7">7</option>' +
            '<option value="8">8</option>' +
            '<option value="9">High School</option>').val([]);

        // scroll to top because modal is not position fixed
        moveToTop();

        $('#subject_id_edit').append('<option value="" selected="selected" disabled="disabled">Select subject...</option>');
        $('#game_id_edit').append('<option value="" selected="selected" disabled="disabled">Select game...</option>');

        //$('#dl_skill_id').append('<option value="" selected="selected" disabled="disabled">Select skill...</option>');

        model.getSubjectsAdmin(function (r) {
            $.each(r, function (key, value) {
                $('#subject_id_edit').append("<option value=" + value.subject_id + ">" + value.name + "</option>");
            });
        });

        model.getGamesAdmin(function (r) {
            $.each(r, function (key, value) {
                $('#game_id_edit').append("<option value=" + value.game_id + ">" + value.name + "</option>");
            });
        });
    });

    $('#addEditChallengeAdmin #subject_id_edit').change(function (e) {
        e.preventDefault();

        clearDropDownBoxSpec('#skill_id_edit');
        $('#skill_id_edit').append('<option value="" selected="selected" disabled="disabled">Select skill...</option>');
        var skill_id = $(this).find('option:selected').attr('value');

        model.getSkillBySkillIdAdmin(skill_id, function (r) {
            $.each(r, function (key, value) {
                $('#skill_id_edit').append("<option value=" + value.skill_id + ">" + value.name + "</option>");
            });
            $('#skill_id_edit').removeAttr('disabled');
        });
    });

    $('#addEditChallengeAdmin #skill_id_edit').change(function (e) {
        e.preventDefault();
        clearDropDownBoxSpec('#topic_id_edit');
        $('#topic_id_edit').append('<option value="" selected="selected" disabled="disabled">Select subtopic...</option>');
        var skill_id = $(this).find('option:selected').attr('value');
        model.getTopicBySkillIdAdmin(skill_id, function (r) {
            $.each(r, function (key, value) {
                $('#topic_id_edit').append("<option value=" + value.topic_id + ">" + value.name + "</option>");
            });
            $('#topic_id_edit').removeAttr('disabled');
        });
    });


    // edit challenge from admin panel
    $('.mod-challenge-admin .edit').unbind('click').click(function (e) {
        e.preventDefault();

        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        $('#edit_challenge_id_edit').val(id);

        // scroll to top because modal is not position fixed
        moveToTop();

        model.getChallengeById(id, function (r) {

            $('#challenge_name_edit').val(r.name);
            $('#level_edit').val(r.level);

            if (r.is_public === "1") {
                $('#is_public').attr('checked', 'checked');
            } else {
                $('#is_public').removeAttr('checked');
            }

            model.getSubjectsAdmin(function (s) {
                $.each(s, function (k, v) {
                    $('#subject_id_edit').append("<option value=" + v.subject_id + ">" + v.name + "</option>");
                });
                $('#subject_id_edit').val(r.subject_id);
            });

            model.getSkillBySkillIdAdmin(r.subject_id, function (t) {
                $.each(t, function (k, v) {
                    $('#skill_id_edit').append("<option value=" + v.skill_id + ">" + v.name + "</option>");
                });
                $('#skill_id_edit').removeAttr('disabled');
                $('#skill_id_edit').val(r.skill_id);
            });

            model.getTopicBySkillIdAdmin(r.skill_id, function (t) {
                $.each(t, function (k, v) {
                    $('#topic_id_edit').append("<option value=" + v.topic_id + " title='" + v.name + "'>" + v.name + "</option>");
                });
                $('#topic_id_edit').removeAttr('disabled');
                $('#topic_id_edit').val(r.topic_id);
            });


            model.getGamesAdmin(function (g) {
                $.each(g, function (k, v) {
                    $('#game_id_edit').append("<option value=" + v.game_id + ">" + v.name + "</option>");
                });
                $('#game_id_edit').val(r.game_id);
            });

            $('#description_edit').val(r.description);
            var elem = $("#chars_edit");
            $('#description_edit').limiter(description_limter, elem);
        });
    });

    $('#student_stats_table').dataTable(datatable_settings);
    $('#challenge_stats_by_played_time_table').dataTable(datatable_settings);
    $('#challenges_class_table').dataTable(datatable_settings);
    $('#student_class_challenge_table').dataTable(datatable_settings);
    $('#class_student_stats_table').dataTable(datatable_settings);

    $('#stats_class_id').unbind('change').change(function () {
        var t = $(this);
        var data = {class_id: t.val()};
        model.getClassroomStatReportingTable(data, function (r) {

            $('#student_stats_table_wrapper').empty().html(r);
            $('#student_stats_table').dataTable(datatable_settings);

            student_stats_details(data);
        });
    });

    student_stats_details({class_id: $('#stats_class_id').val()});

    function student_stats_details(data) {
        $('#student_stats_table').delegate('tr:not(".thead")', 'click', function (e) {

            var student_id = $(this).data('student');
            var data_details = {class_id: data.class_id, student_id: student_id};
            model.getClassStatsDetailsReport(data_details, function (c) {
                $('#student_stats_details_wrapper').empty().html(c);
                $('#student_stats_details_table').dataTable(datatable_settings);

                $('#studentDetailsModal').modal('show');
                moveToTop();
            });
        });
    }

    $('#student_class_challenge_class_id').unbind('change').change(function () {
        var t = $(this);

        model.getStudentsFromClassByClassId(t.val(), function (r) {

            if (r.students.length > 0) {
                $('#student_class_challenge_student_id').empty().removeAttr('disabled');
                $.each(r.students, function (k, v) {
                    $('#student_class_challenge_student_id').append("<option value=" + v.user_id + ">" + v.first_name + ' ' + v.last_name + "</option>");
                });
            } else {
                $('#student_class_challenge_student_id').html('<option selected="selected">No students in this class</option>').attr('disabled', 'disabled');
            }

        });
    });

    $('#student_class_challenge_student_id').unbind('change').change(function () {
        var t = $(this);

        var class_id = $('#student_class_challenge_class_id').val();
        var data = {class_id: class_id, user_id: t.val()};
        model.getStudentStatReportingTable(data, function (r) {

            $('#class_student_stats_table_wrapper').empty().html(r);
            $('#class_student_stats_table').dataTable(datatable_settings);
        });
    });

    $('#student_challenge_stats_class_id').unbind('change').change(function () {
        var t = $(this);
        var data = {class_id: t.val()};
        model.getClassroomStatReportingTable(data, function (r) {

            $('#student_stats_table_wrapper').empty().html(r);
            $('#student_stats_table').dataTable(datatable_settings);
        });
    });

    $('#challenge_id').change(function (e) {
        var data = {challenge_id: $(this).val()};

        model.getChallengeClassroomReport(data, function (r) {
            var challenge_class_statistic = $.parseJSON(r);
            do_chart(challenge_class_statistic, 'column_chart');
        });
    });

    if (url_segments[0] === 'reporting' && url_segments[1] === 'basic') {

        var data = {challenge_id: $('#challenge_id').val()};

        model.getChallengeClassroomReport(data, function (r) {
            var challenge_class_statistic = $.parseJSON(r);
            do_chart(challenge_class_statistic, 'column_chart');
        });

        var class_id = $('#student_stats_class_id').val();

        model.getReportStudentStatsClassroom(class_id, function (r) {
            if (r.error) {
                $('#students_in_class_stats').html(r.error);
            } else {
                do_chart(r, 'students_in_class_stats');
            }
        });
    }

    $('.reporting #class_id_top_3_students').change(function (e) {
        var class_id = $(this).val();

        model.getTopThreeStudentsByClassId(class_id, function (r) {
            $('#top_3_students_charts').empty();

            $.each(r, function (k, v) {
                var html = '<div class="pie-chart"><div class="chart' + (k + 1) + ' easyPieChart" data-percent="' + v.result + '" ' +
                    'style="width: 140px; height: 140px; line-height: 140px;">' + v.result + '%<canvas width="140" height="140"></canvas>' +
                    '</div><p class="name">' + v.name + '</p></div>';

                $('#top_3_students_charts').append(html);
                pie_chart();
            });
        });
    });

    $('.reporting #class_id_bottom_3_students').change(function (e) {
        var class_id = $(this).val();

        model.getBottomThreeStudentsByClassId(class_id, function (r) {
            $('#bottom_3_students_charts').empty();

            $.each(r, function (k, v) {
                var html = '<div class="pie-chart"><div class="chart' + (k + 1) + ' easyPieChart" data-percent="' + v.result + '" ' +
                    'style="width: 140px; height: 140px; line-height: 140px;">' + v.result + '%<canvas width="140" height="140"></canvas>' +
                    '</div><p class="name">' + v.name + '</p></div>';

                $('#bottom_3_students_charts').append(html);
                pie_chart();
            });
        });
    });

    if (url_segments[0] === 'home' || url_segments[0] === undefined || url_segments[1] === 'basic') {
        pie_chart();
    }

    if (url_segments[1] === 'classroom_stats') {
        //alert('my pie');
        tab_pie_chart();
    }

    $('#report_stats_challenge_datepicker_from').datepicker({
        format: 'mm/dd/yyyy'
    })
    .on('changeDate', function(ev){
        //if (ev.date.valueOf() < startDate.valueOf()){
        //}
        $(this).datepicker('hide');
        apply_report_stats_challenge_filters();
    });

    $('#report_stats_challenge_datepicker_to').datepicker({
        format: 'mm/dd/yyyy'
    })
    .on('changeDate', function(ev){
        $(this).datepicker('hide');
        apply_report_stats_challenge_filters();
    });

    $('#report_stats_challenge_class_select, #report_stats_challenge_period_select').unbind('change').change(function () {
        apply_report_stats_challenge_filters();
    });


    function apply_report_stats_challenge_filters() {
        var class_id = $('#report_stats_challenge_class_select').val(),
            period_type = $('#report_stats_challenge_period_select').val();
        if (period_type == 6) { $('.report-stats-date').show(); }
        else { $('.report-stats-date').hide(); }
        var from_date_input = (period_type == 6) ? $('#report_stats_challenge_datepicker_from').val() : '',
            to_date_input = (period_type == 6) ? $('#report_stats_challenge_datepicker_to').val() : '';
        var from_date_arr = from_date_input.split('/'),
            to_date_arr = to_date_input.split('/');
        var from_date = (from_date_arr.length == 3) ? from_date_arr[2] + '-' + from_date_arr[0] + '-' + from_date_arr[1] : '',
            to_date = (to_date_arr.length == 3) ? to_date_arr[2] + '-' + to_date_arr[0] + '-' + to_date_arr[1] : '';
        //alert('change 1 - class_id: ' + class_id + '; period_type: ' + period_type);

        var newUri = 'class_id/' + class_id;
        newUri += '/period_type/' + period_type;
        if ((period_type == 6) && (from_date) && (to_date)) {
            newUri += '/from/' + from_date + '/to/' + to_date;
        }
        window.history.replaceState({}, null, '/reporting/classroom_stats/' + newUri);

        model.getReportStatsChallengeClass(newUri, function (res) {
            //TODO: Insert table rows with challenge names and score wheels
            //alert('Inserting table data...');

            $('#report_stats_challenge_table tbody').empty();

            $.each(res, function (k, v) {
                var xHtml =
                    '<tr>' +
                    '    <td>' + v.challenge_name + '</td>' +
                    '    <td>' +
                    '        <div class="pie-chart">' +
                    '            <div class="chart-score-class-tab easyPieChart" data-percent="20" style="width: 140px; height: 140px; line-height: 140px;">' +
                    v.class_avg + '%' +
                    '                <canvas width="140" height="140"></canvas>' +
                    '            </div>' +
                    '        </div>' +
                    '    </td>' +
                    '    <td>' +
                    '        <div class="pie-chart">' +
                    '            <div class="chart-score-overall-tab easyPieChart" data-percent="10" style="width: 140px; height: 140px; line-height: 140px;">' +
                    v.overall_avg + '%' +
                    '                <canvas width="140" height="140"></canvas>' +
                    '            </div>' +
                    '        </div>' +
                    '    </td>' +
                    '</tr>';

                $('#report_stats_challenge_table tbody').append(xHtml);
                tab_pie_chart();
            });
        });

        /*model.getReportStudentStatsClassroom(class_id, function (r) {
            if (r.error) {
                $('#students_in_class_stats').html(r.error);
            } else {
                do_chart(r, 'students_in_class_stats');
            }
        });*/
    }

        //Draw pie charts in tabel for classroom statistic
    function tab_pie_chart() {
        $(function () {
            $('.chart-score-class-tab').easyPieChart({
                animate: 2000,
                barColor: '#ffb400',
                trackColor: '#dddddd',
                scaleColor: '#ffb400',
                size: 140,
                lineWidth: 6
            });
        });

        $(function () {
            $('.chart-score-overall-tab').easyPieChart({
                animate: 2000,
                barColor: '#74b749',
                trackColor: '#dddddd',
                scaleColor: '#74b749',
                size: 140,
                lineWidth: 6
            });
        });

    }

    function pie_chart() {
        $(function () {
            //create instance
            $('.chart1').easyPieChart({
                animate: 2000,
                barColor: '#74b749',
                trackColor: '#dddddd',
                scaleColor: '#74b749',
                size: 140,
                lineWidth: 6
            });
        });

        $(function () {
            //create instance
            $('.chart2').easyPieChart({
                animate: 2000,
                barColor: '#ed6d49',
                trackColor: '#dddddd',
                scaleColor: '#ed6d49',
                size: 140,
                lineWidth: 6
            });
        });

        $(function () {
            //create instance
            $('.chart3').easyPieChart({
                animate: 2000,
                barColor: '#0daed3',
                trackColor: '#dddddd',
                scaleColor: '#0daed3',
                size: 140,
                lineWidth: 6
            });
        });

        $(function () {
            //create instance
            $('.chart4').easyPieChart({
                animate: 2000,
                barColor: '#ffb400',
                trackColor: '#dddddd',
                scaleColor: '#ffb400',
                size: 140,
                lineWidth: 6
            });
        });


        $(function () {
            //create instance
            $('.chart5').easyPieChart({
                animate: 3000,
                barColor: '#F63131',
                trackColor: '#dddddd',
                scaleColor: '#F63131',
                size: 140,
                lineWidth: 6
            });
        });
    }

    if (url_segments[0] === 'marketplace' || url_segments[0] === 'challenge_builder') {
        // set subject, topic and grade select in marketplace to default selection
        $('#subject_all_option, #topic_all_option, #grade_all_option').attr('selected', 'selected');
        $('#challenge_filter_topic_selector').removeAttr('disabled');
    }

    $('.add_title').dd_add_title();
    $('.add_title').unbind('change').change(function () {
        //var t = $(this);
        $(this).dd_add_title();
    });

    // SparkLine Graphs-Charts
    $(function () {
        $('#total_challenges_sparkline').sparkline('html', {
            type: 'bar',
            barColor: '#ed6d49',
            barWidth: 6,
            height: 30,
            chartRangeMin: 0
        });
        $('#total_teachers_sparkline').sparkline('html', {
            type: 'bar',
            barColor: '#74b749',
            barWidth: 6,
            height: 30,
            chartRangeMin: 0
        });
        $('#total_students_sparkline').sparkline('html', {
            type: 'bar',
            barColor: '#ffb400',
            barWidth: 6,
            height: 30,
            chartRangeMin: 0
        });
        $('#registrations').sparkline('html', {
            type: 'bar',
            barColor: '#0daed3',
            barWidth: 6,
            height: 30
        });
        $('#site-visits').sparkline('html', {
            type: 'bar',
            barColor: '#f63131',
            barWidth: 6,
            height: 30
        });
    });

    $('#scrollbar').tinyscrollbar();

    $('#assigned_challenge_selector').unbind('change').change(function () {
        var selected_classroom = $(this).val();

        if (selected_classroom === 'all') {
            $('.container-fluid .span5').fadeOut();

            setTimeout(function () {
                $('.container-fluid .span5').fadeIn();
            }, 500);
        } else {
            $('.container-fluid .span5').fadeOut();
            setTimeout(function () {
                $('.container-fluid > div[data-class-id="' + selected_classroom + '"]').fadeIn();
            }, 500);

        }
    });

    $('.installChallenge').unbind('click').click(function () {

        // set class select to default state
        $('#class_id option:first').attr('selected', 'selected');

        var challenge_id = $(this).data('challenge-id');

        $('#add_class_id').html('<option selected="selected" disabled="disabled">Select class...</option>');

        $('#challenge_install_id').val(challenge_id);


        model.getClassesForChallengeBuilderAddChallengeToClass(challenge_id, function (r) {
            if (r.installed === 'all') {
                $('#add_class_id').parents('.control-group').hide();
                $('#challenge_btn_install_to_class').hide();
                $('#no_classes').show();
                $('#challenge_btn_close').show();
            } else {
                $('#no_classes').hide();
                $('#challenge_btn_close').hide();
                $('#add_class_id').parents('.control-group').show();
                $('#challenge_btn_install_to_class').show();

                $.each(r, function (k, v) {
                    $('#add_class_id').append("<option value=" + v.class_id + ">" + v.class_name + "</option>");
                });
            }
        });
    });
    $('#challenge_btn_install_to_class').unbind('click').click(function (e) {
        e.preventDefault();

        var data = $('#install_challenge_form').serialize();

        model.validateInstallChallengeFromChallengeBuilder(data, function (r) {

            if (r.validation === true) {
                $('#install_challenge_form').submit();
            } else {
                if (r.class_id) {
                    $('#class_id').parents('.control-group').addClass('error');
                    $('#class_id').siblings('.help-inline').html(r.class_id);
                }
            }
        });
    });

    if (subdomain_name === 'admin') {
        $('#school_name').autocomplete({
            minLength: 5,
            cache: false,
            focus: function (event, ui) {
                $('#school_id').val(ui.item.id);
                return false;
            },
            select: function (event, ui) {
                this.value = ui.item.label;

                $('#school_id').val(ui.item.id);
            },
            source: function (request, response) {
                var zip_code = $('#zip_code').val();
                var data = {school: request.term, zip_code: zip_code};

                model.getSchoolListByZipCodeAutocompleteAdmin(data, function (r) {
                    response($.map(r, function (item) {
                        return {
                            label: item.name,
                            id: item.school_id
                        }
                    }))
                });
            }
        });

        $('#school_name').keyup(function () {
            var name = $(this).val();

            if (name.length === 0) {
                $('#school_id').val('');
            }
        });

    }

    if (subdomain_name === 'teacher') {
//        $('#school_name_edit').autocomplete({
//            minLength: 5,
//            cache: false,
//            focus: function (event, ui) {
//                return false;
//            },
//            select: function (event, ui) {
//                this.value = ui.item.label;
//                $('#school_id').val(ui.item.id)
//            },
//            source: function (request, response) {
//                var zip_code = $('#zip_code').val();
//                var data = {school: request.term, zip_code: zip_code};
//
//                $.post(BASEURL + 'profile/ajax_school', {school: data}, function (data) {
//                    response($.map(data, function (item) {
//                        return {
//                            label: item.name,
//                            id: item.school_id
//                        }
//                    }))
//                }, 'json');
//            }
//        });

        $('#school_name_edit').autocomplete({
            minLength: 5,
            cache: false,
            focus: function (event, ui) {
                return false;
            },
            select: function (event, ui) {
                this.value = ui.item.label;
                $('#school_id').val(ui.item.id)
            },
            source: function (request, response) {
                var zip_code = $('#zip_code').val();
                var data = {school: request.term, zip_code: zip_code};

                model.getSchoolListByZipCodeAutocomplete(data, function (r) {
                    response($.map(r, function (item) {
                        return {
                            label: item.name,
                            id: item.school_id
                        }
                    }))
                });
            }
        });

    }

    $('#school_name_edit').keyup(function () {
        var name = $(this).val();

        if (name.length === 0) {
            $('#school_id').val('');
        }
    });


//validateTeacherSchool
    $('#teacher_school_form_submit').unbind('click').click(function (e) {
        e.preventDefault();

        $('.control-group').removeClass('error');
        $('.help-inline').empty();

        var data = $('#teacher_school_form').serialize();
        model.validateTeacherSchool(data, function (r) {

            if (r.validation === true) {
                $('#teacher_school_form').submit();
            } else {
                if (r.zip_code) {
                    $('#zip_code').parents('.control-group').addClass('error');
                    $('#zip_code').siblings('.help-inline').html(r.zip_code);
                }
                if (r.school_name) {
                    $('#school_name_edit').parents('.control-group').addClass('error');
                    $('#school_name_edit').siblings('.help-inline').html(r.school_name);
                }
                if (r.not_listed) {
                    $('#not_listed').parents('.control-group').addClass('error');
                    $('#not_listed').siblings('.help-inline').html(r.not_listed);
                }
            }
        });
    });

    $('.mod-challenge-question .delete').unbind('click').click(function (e) {
        e.preventDefault();

        $('#uninstallChallenge').modal('show');



        var challengeId = current_url.split('/');
        challengeId = challengeId[3];

        var id = $(this).data('id');
        var data = {question_id: id, challenge_id: challengeId};

        $('#question_btn_uninstall').unbind('click').click(function (e) {
            e.preventDefault();

            model.deleteQuestion(data, function (r) {
                if (r.deleted === true) {
                    $('#uninstallChallenge').modal('hide');

                    $('#challenge_question' + id).fadeOut(300, function () {
                        $(this).remove();
                    });
                } else {
                    $.gritter.add({
                        title: 'Error',
                        text: r.message
                    });
                    $('#uninstallChallenge').modal('hide');
                }
            });
        });
    });

    $('#save_school_submit').unbind('click').click(function (e) {
        e.preventDefault();

        $('.control-group').removeClass('error');
        $('.help-inline').empty();

        var data = $('#add_edit_school_form').serialize();
        model.validateSchoolSaveAdmin(data, function (r) {
            if (r.validation === true) {
                model.saveSchoolAdmin(data, function (s) {
                    if (s.saved === true) {
                        window.location.reload();
                    } else {
                        $.gritter.add({
                            title: 'Error',
                            text: 'Whoops! Something went wrong, please try again later.'
                        });
                    }
                });
//                $('#add_edit_school_form').submit();
            } else {
                if (r.name) {
                    $('#name').parents('.control-group').addClass('error');
                    $('#name').siblings('.help-inline').html(r.name);
                }
                if (r.country) {
                    $('#country').parents('.control-group').addClass('error');
                    $('#country').siblings('.help-inline').html(r.country);
                }
                if (r.state) {
                    $('#state').parents('.control-group').addClass('error');
                    $('#state').siblings('.help-inline').html(r.state);
                }
                if (r.city) {
                    $('#city').parents('.control-group').addClass('error');
                    $('#city').siblings('.help-inline').html(r.city);
                }
                if (r.county) {
                    $('#county').parents('.control-group').addClass('error');
                    $('#county').siblings('.help-inline').html(r.county);
                }
                if (r.zip_code) {
                    $('#zip_code').parents('.control-group').addClass('error');
                    $('#zip_code').siblings('.help-inline').html(r.zip_code);
                }
                if (r.public) {
                    $('#public').parents('.control-group').addClass('error');
                    $('#public').children('.help-inline').html(r.public);
                }
            }
        });
    });


    $('#addNewSchool').unbind('click').click(function () {
        moveToTop();

        clearFormFields('#add_edit_school_form');
    });

    $('.mod-school .edit').unbind('click').click(function () {
        var t = $(this);
        var url = $(this).attr('href').split('#');
        var id = url[1].split('/');
        id = id[2];

        moveToTop();

        var data = {school_id: id};
        model.getSchoolDataByIdAdmin(data, function (r) {

            $('#name').val(r.name);
            $('#state').val(r.state);
            $('#country').val(r.country);
            $('#city').val(r.city);
            $('#county').val(r.county);
            $('#zip_code').val(r.zip_code);
            $('#edit_school_id').val(r.id);

            if (r.public === 'public') {
                $('#public_school').attr('checked', 'checked');
            } else if (r.public === 'private') {
                $('#private_school').attr('checked', 'checked');
            }

            $('#approved').val('approved');

        });
    });

    /* delete action */
    $('.mod-school .decline').unbind('click').click(function (e) {
        e.preventDefault();
        var t = $(this);
        var url = t.attr('href');

        console.log(url);

        t.parents('.btn-group').removeClass('open');

        if (confirm("Confirm decline.") === false) {
            return false;
        } else {
            window.location = url;
        }
    });

    $('.mod-school .approve').unbind('click').click(function(e){
        e.preventDefault();
        var t = $(this);
        var url = t.attr('href');

        console.log(url);

        t.parents('.btn-group').removeClass('open');

        if (confirm("Confirm approve.") === false) {
            return false;
        } else {
            window.location = url;
        }
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

    /** admin panel student statistics */
    if (url_segments[0] === 'users' && url_segments[1] === 'statistic' && subdomain_name === 'admin') {

        model.getReportStudentStatsAge(function (r) {
            do_chart(r, 'student_age_chart');
        });

        model.getReportStudentTotalDuration(function (d) {
            do_chart(d, 'student_total_duration_chart');
        });

        $('#datepicker_reg_stats_from').datepicker({
            format: 'mm/dd/yyyy'
        });

        $('#datepicker_reg_stats_to').datepicker({
            format: 'mm/dd/yyyy'
        });

        $("#datepicker_reg_stats_from, #datepicker_reg_stats_to").keydown(function (e) {
            e.preventDefault();
        });

        $('#reg_stats_month_submit, #reg_stats_week_submit, #reg_stats_day_submit').unbind('click').click(function (e) {
            e.preventDefault();
            var type = $(this).data('type');

            var data = $('#datepicker_reg_stats_form :input').serialize();
            switch (type) {
                case 'day':
                    data += '&type=day';
                    break;
                case 'week':
                    data += '&type=week';
                    break;
                case 'month':
                    data += '&type=month';
                    break;
            }

            model.getReportRegistrationStats(data, function (m) {
                do_chart(m, 'user_registration_chart', 'line');
            });
        });
    }

})
;

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
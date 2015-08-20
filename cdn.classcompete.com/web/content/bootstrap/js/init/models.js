var model = {
    /**
     * getSubjects - return list of all subject
     * getSkillBySubjectId - return lift of spec skill
     * */
    getSubjects: function (callback) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: BASEURL + 'subject/get_subjects',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getSkillBySubjectId: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'skill/ajax_get_skill_by_subject_id/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getSubjectsFromSkills: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'skill/ajax_subjects',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getSubjectById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'subject/ajax/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getSkillById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'skill/ajax/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getAdminById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'admin/ajax/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getGameById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'games/ajax/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getGamesFromGameLevels: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'gamelevels/ajax_games',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getGameLevelById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'gamelevels/ajax/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getUserById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'users/ajax/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getTeacherProfileData: function(id, callback){
        $.ajax({
            type:'POST',
            dataType:'json',
            data:{teacher_id:+id},
            url: BASEURL + 'users/ajax_teacher_profile_data/',
            success: function(r){
                eval(callback(r));
            }
        });
    },
    getTeachersFromClasses: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'classes/ajax_teachers',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getClassById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'classes/ajax/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getClassFromClassStudent: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'class_student/ajax_get_class',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getStudentsFromClassStudent: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'class_student/ajax_get_students',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getSubjectsFromChallenge: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge_builder/ajax_get_subject',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getSubjectsAdmin: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge/ajax_get_subject',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getGamesFromChallenge: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge_builder/ajax_get_game',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getGamesAdmin: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge/ajax_get_game',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getSkillBySkillIdFromChallenge: function (skill_id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge_builder/ajax_get_skill/' + skill_id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getSkillBySkillIdAdmin: function (skill_id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge/ajax_get_skill/' + skill_id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getTopicBySkillIdFromChallengeBuilder: function (skill_id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge_builder/ajax_get_topic/' + skill_id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getTopicBySkillIdAdmin: function (skill_id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge/ajax_get_topic/' + skill_id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getGameLevelByGameIdFromChallenge: function (game_id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge_builder/ajax_get_game_level/' + game_id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getChallengeById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge/ajax/' + id,
            success: function (r) {
                console.log(r);
                eval(callback(r));
            }
        });
    },
    getSkillByIdFromChallenge: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge_builder/ajax_get_skill/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getGameLevelByIdFromChallenge: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge/ajax_get_game_level/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getChallengesFromChallengeClass: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge_class/ajax_get_challenges/',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getChallengeClassFromChallengeClass: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge_class/ajax_get_challenges_class/',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getChallengeByIdFromChallengeClass: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge_class/ajax_get_challenge/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getQuestionTypeList: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'question/ajax_get_type_list/',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getMultipleChoiceList: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'question/ajax_get_multiple_choice_list/',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getQuestionById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'question/ajax/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getAllUsersConnections: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'connection/ajax_get_all_users/',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getExcludedUsersConnections: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'connection/ajax_get_excluded_users/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getStatusConnections: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'connection/ajax_get_status/',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getConnectionById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'connection/ajax/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getSkillListFromTopic: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'topic/ajax_get_skills/',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getTopicById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'topic/ajax/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getClassStudentById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'class_student/ajax/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getStudentsByClassId: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'class_student/ajax_get_students/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getExcludedStudentsFromClassByClassId: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'class_student/ajax_get_excluded_students/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    validateClass: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'classes/ajax_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateClassStudent: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'class_student/ajax_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateChallenge: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'challenge/ajax_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateChallengeBuilder: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'challenge_builder/ajax_validation_save_challenge/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateChallengeClass: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'challenge_class/ajax_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateTeacherPassword: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'profile/ajax_pass_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateTeacherInfo: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'profile/ajax_info_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    getNewClassCode: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'classes/ajax_class_code/',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    getStudentsFromClassByClassId: function (id, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'classes/ajax_get_students/',
            data: {class_id: id},
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getStudentProfileFromClassByUserId: function (id, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'classes/ajax_get_student_profile/',
            data: {user_id: id},
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getClassesFromClasses: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'classes/ajax_get_class/',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getExcludedStudentsByClassId: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'classes/ajax_get_excluded_students/' + id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    validateClassStudentForm: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'classes/ajax_validation_new_student/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    classStudentSave: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'classes/save_student/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType1: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_1_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType2: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_2_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType3: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_3_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType4: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_4_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType5: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_5_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType6: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_6_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType7: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_7_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType8: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_8_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType9: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_9_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType10: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_10_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType11: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_11_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType12: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_12_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType13: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_13_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType14: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_14_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType15: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_15_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionType16: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_16_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }
            }
        });
    },
    validateQuestionTypeByTypeIndex: function (index, data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_type_' + index + '_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getClassesForChallengeBuilder: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge_builder/ajax_get_classes/',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    saveChallenge: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'challenge_builder/save_challenge/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    uninstallChallengeById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge/ajax_uninstall_challenge/' + id,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    deleteChallengeById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'challenge/ajax_delete_challenge/' + id,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
//                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getQuestionDetailsById: function (id, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'question/ajax_question_details/' + id,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    if (text === 'parsererror') {
                        window.location.reload();
                    } else {
                        error = $.parseJSON(jqXHR.responseText);
                        eval(callback(error));
                    }

                }
            }
        });
    },
    getClassesForMarketplaceAddChallenge: function (id, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'marketplace/ajax_get_class/',
            data: {challenge_id: id},
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getClassesForChallengeBuilderAddChallengeToClass: function (id, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'challenge_builder/ajax_get_class/',
            data: {challenge_id: id},
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    validateInstallChallengeFromMarketplace: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'marketplace/ajax_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    installChallengeFromMarketplace: function(data, callback){
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'marketplace/ajax_install',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
            }
        });
    },
    validateInstallChallengeFromChallengeBuilder: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'challenge_builder/ajax_install_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getAllChallenges: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'question/ajax_get_challenges',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getStudentStatReportingTable: function (data, callback) {
        $.ajax({
            type: 'POST',
            data: data,
            url: BASEURL + 'reporting/ajax_report_students_stats',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getStudentStatIndividuallyChallengeReportingTable: function (data, callback) {
        $.ajax({
            type: 'POST',
            data: data,
            url: BASEURL + 'reporting/ajax_report_student_stats_individually_challenge',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getClassroomStatReportingTable: function (data, callback) {
        $.ajax({
            type: 'POST',
            data: data,
            url: BASEURL + 'reporting/ajax_report_classroom_stats',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getClassStatsDetailsReport: function (data, callback) {
        $.ajax({
            type: 'POST',
            data: data,
            url: BASEURL + 'reporting/ajax_report_classroom_stats_details',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    validateTeacherRegistration: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: data,
            url: BASEURL + 'auth/ajax_validate_registration',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    validateTeacherForgotPassword: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: data,
            url: BASEURL + 'auth/ajax_validate_forgot_password',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    validateTeacherLogin: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: data,
            url: BASEURL + 'auth/ajax_validation_login',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getChallengeClassroomReport: function (data, callback) {
        $.ajax({
            type: 'POST',
            data: data,
            url: BASEURL + 'reporting/ajax_get_challenge_classroom_statistic',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    saveChallengeWizard: function (data, callback) {
        $.ajax({
            type: 'POST',
            data: data,
            dataType: 'json',
            url: BASEURL + 'challenge_builder/ajax_save_challenge',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    saveQuestionByUrl: function (url, data, callback) {
        $.ajax({
            type: 'POST',
            data: data,
            dataType: 'json',
            url: BASEURL + 'question/' + url,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    validateTeacherSchool: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'profile/ajax_validate_school/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    deleteQuestion: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/delete_question/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    validateSchoolSaveAdmin: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'school/ajax_school_validation/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    saveSchoolAdmin: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'school/save_school/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getSchoolDataByIdAdmin: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'school/ajax/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    removeStudentFromClass: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'classes/ajax_delete_student_from_class/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getTopThreeStudentsByClassId: function (class_id, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'reporting/ajax_get_top_3_students/',
            data: {class_id: class_id},
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getBottomThreeStudentsByClassId: function (class_id, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'reporting/ajax_get_bottom_3_students/',
            data: {class_id: class_id},
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getReportStudentGlobalStatsByUserId: function (user_id, class_id, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'reporting/ajax_report_student_global_stats/',
            data: {user_id: user_id, class_id: class_id},
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getSchoolListByZipCodeAutocomplete: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'profile/ajax_school/',
            data: {school: data},
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getSchoolListByZipCodeAutocompleteAdmin: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'school/ajax_get_schools_by_name/',
            data: {school: data},
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    cropImage: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'question/process_image_crop/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getReportStudentStatsClassroom: function (class_id, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'reporting/ajax_report_student_stats_classroom/',
            data: {class_id: class_id},
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
        //Get data for challenge average scores for statistics of classroom
    getReportStatsChallengeClass: function (uri, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'reporting/ajax_report_stats_challenge_class' + uri,
            data: {},
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    changeStudentProfile: function(data, callback){
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'v2/studentApi/profilePut/',
            data: data,
            success: function (r) {
                if (typeof callback === 'function') {
                    callback(r);
                }
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    console.log(jqXHR);
                    console.log(text);
                    console.log(error);
                    alert("Oops. Something went wrong. Please try again.\nIf you keep seeing this error, please contact us using support tab")
                } else {
                    if (typeof callback === 'function') {
                        callback($.parseJSON(jqXHR.responseText));
                    }
                }
            }
        });
    },
    changeUserPassword: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'classes/ajax_reset_password/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getReportStudentStatsAge: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'users/ajax_student_age_statistics/',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getReportStudentTotalDuration: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'users/ajax_get_total_duration_average_stats/',
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getReportRegistrationStats: function (data, callback) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: BASEURL + 'users/ajax_registration_stats/',
            data: data,
            success: function (r) {
                eval(callback(r));
            },
            error: function (jqXHR, text, error) {
                if (text === 'parsererror') {
                    window.location.reload();
                } else {
                    error = $.parseJSON(jqXHR.responseText);
                    eval(callback(error));
                }

            }
        });
    },
    getSkillBySubjectIdMarketplace: function (grade_id, subject, callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'marketplace/ajax_get_skill_by_subject_id/' + subject + '/'+grade_id,
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    getSkillListMarketplace: function (callback) {
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: BASEURL + 'marketplace/ajax_get_skills/',
            success: function (r) {
                eval(callback(r));
            }
        });
    },
    validateChallengeName: function (name, callback){
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {name: name},
            url: BASEURL + 'challenge_builder/ajax_is_challenge_name_unique/',
            success: function (r) {
                eval(callback(r));
            }
        });
    }
};
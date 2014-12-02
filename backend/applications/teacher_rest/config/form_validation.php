<?php
$config = array(
    'classes' => array(
        array(
            'field' => 'name',
            'label' => 'Name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'class_code',
            'label' => 'Class code',
            'rules' => 'alpha_numeric|trim|required'
        )
    ),
    'class_student' => array(
        array(
            'field' => 'class_id',
            'label' => 'Class',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'user_id',
            'label' => 'Student',
            'rules' => 'integer|required|trim'
        )
    ),
    'challenge' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game',
            'label' => 'Game',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        )
    ),
    'edit_challenge' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject_id',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill_id',
            'label' => 'Topic',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'topic_id',
            'label' => 'Sub topic',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade_id',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_id',
            'label' => 'Game',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        )
    ),
    'challenge_builder_class' => array(
        array(
            'field' => 'class_id',
            'label' => 'Class name',
            'rules' => 'integer|required|trim'
        )
    ),
    'challenge_class' => array(
        array(
            'field' => 'challenge_id',
            'label' => 'Challenge name',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'class_id',
            'label' => 'Class name',
            'rules' => 'integer|required|trim'
        )
    ),
    'question_type_1' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game',
            'label' => 'Game',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_1_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_1_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type',
            'label' => 'question_type',
            'rules' => 'required|trim'
        )
    ),
    'question_type_1_edit' => array(
        array(
            'field' => 'challenge',
            'label' => 'Challenge ID',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game',
            'label' => 'Game',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_1_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_1_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type',
            'label' => 'question_type',
            'rules' => 'required|trim'
        )
    ),
    'question_type_1_running_game' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_1_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_1_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type',
            'label' => 'question_type',
            'rules' => 'required|trim'
        )
    ),
    'question_type_1_running_game_question' => array(
        array(
            'field' => 'question_type_1_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_1_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type',
            'label' => 'question_type',
            'rules' => 'required|trim'
        )
    ),
    'question_type_1_brain_runner' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_1_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_1_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type',
            'label' => 'question_type',
            'rules' => 'required|trim'
        )
    ),
    'question_type_1_brain_runner_question' => array(
        array(
            'field' => 'question_type_1_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_1_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_1_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type',
            'label' => 'question_type',
            'rules' => 'required|trim'
        )
    ),
    'question_type_2' => array(
        array(
            'field' => 'question_type_2_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_2_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_2_edit' => array(
        array(
            'field' => 'challenge',
            'label' => 'Challenge ID',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'question_type_2_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_2_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_2_running_game' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_2_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_2_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_2_running_game_question' => array(
        array(
            'field' => 'question_type_2_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_2_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_2_brain_runner' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_2_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_2_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_2_brain_runner_question' => array(
        array(
            'field' => 'question_type_2_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_2_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_2_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_3' => array(
        array(
            'field' => 'question_type_3_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_3_answer[1]',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer[2]',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer[3]',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer[4]',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_3_image',
            'label' => 'Image',
            'rules' => 'required|trim'
        )
    ),
    'question_type_3_running_game' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_3_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_3_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_3_image',
            'label' => 'Image',
            'rules' => 'required|trim'
        )
    ),
    'question_type_3_running_game_question' => array(
        array(
            'field' => 'question_type_3_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_3_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_3_image',
            'label' => 'Image',
            'rules' => 'required|trim'
        )
    ),
    'question_type_3_running_game_question_edit' => array(
        array(
            'field' => 'question_type_3_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_3_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_3_brain_runner' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_3_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_3_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_3_image',
            'label' => 'Image',
            'rules' => 'required|trim'
        )
    ),
    'question_type_3_brain_runner_question' => array(
        array(
            'field' => 'question_type_3_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_3_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_3_image',
            'label' => 'Image',
            'rules' => 'required|trim'
        )
    ),
    'question_type_3_edit' => array(
        array(
            'field' => 'challenge',
            'label' => 'Challenge ID',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'question_type_3_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_3_answer[1]',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer[2]',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer[3]',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_answer[4]',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_3_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_4' => array(
        array(
            'field' => 'question_type_4_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_4_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image[1]',
            'label' => 'Image 1',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image[2]',
            'label' => 'Image 2',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image[3]',
            'label' => 'Image 3',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image[4]',
            'label' => 'Image 4',
            'rules' => 'required|trim'
        )
    ),
    'question_type_4_running_game' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_4_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_4_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_1',
            'label' => 'Image 1',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_2',
            'label' => 'Image 2',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_3',
            'label' => 'Image 3',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_4',
            'label' => 'Image 4',
            'rules' => 'required|trim'
        )
    ),
    'question_type_4_running_game_question' => array(
        array(
            'field' => 'question_type_4_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_4_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_1',
            'label' => 'Image 1',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_2',
            'label' => 'Image 2',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_3',
            'label' => 'Image 3',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_4',
            'label' => 'Image 4',
            'rules' => 'required|trim'
        )
    ),
    'question_type_4_running_game_question_edit' => array(
        array(
            'field' => 'question_type_4_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_4_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_4_brain_runner' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_4_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_4_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_1',
            'label' => 'Image 1',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_2',
            'label' => 'Image 2',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_3',
            'label' => 'Image 3',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_4',
            'label' => 'Image 4',
            'rules' => 'required|trim'
        )
    ),
    'question_type_4_brain_runner_question' => array(
        array(
            'field' => 'question_type_4_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_4_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_1',
            'label' => 'Image 1',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_2',
            'label' => 'Image 2',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_3',
            'label' => 'Image 3',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_4_image_4',
            'label' => 'Image 4',
            'rules' => 'required|trim'
        )
    ),
    'question_type_4_edit' => array(
        array(
            'field' => 'challenge',
            'label' => 'Challenge ID',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'question_type_4_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_4_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_5' => array(
        array(
            'field' => 'question_type_5_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_5_question_image',
            'label' => 'Question image',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image[1]',
            'label' => 'Answer image 1',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image[2]',
            'label' => 'Answer image 2',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image[3]',
            'label' => 'Answer image 3',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image[4]',
            'label' => 'Answer image 4',
            'rules' => 'required|trim'
        ),
    ),
    'question_type_5_running_game' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_5_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_5_question_image',
            'label' => 'Question image',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_1',
            'label' => 'Answer image 1',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_2',
            'label' => 'Answer image 2',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_3',
            'label' => 'Answer image 3',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_4',
            'label' => 'Answer image 4',
            'rules' => 'required|trim'
        ),
    ),
    'question_type_5_running_game_question' => array(
        array(
            'field' => 'question_type_5_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_5_question_image',
            'label' => 'Question image',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_1',
            'label' => 'Answer image 1',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_2',
            'label' => 'Answer image 2',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_3',
            'label' => 'Answer image 3',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_4',
            'label' => 'Answer image 4',
            'rules' => 'required|trim'
        ),
    ),
    'question_type_5_running_game_question_edit' => array(
        array(
            'field' => 'question_type_5_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_5_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_5_brain_runner' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_5_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_5_question_image',
            'label' => 'Question image',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_1',
            'label' => 'Answer image 1',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_2',
            'label' => 'Answer image 2',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_3',
            'label' => 'Answer image 3',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_4',
            'label' => 'Answer image 4',
            'rules' => 'required|trim'
        ),
    ),
    'question_type_5_brain_runner_question' => array(
        array(
            'field' => 'question_type_5_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_5_question_image',
            'label' => 'Question image',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_1',
            'label' => 'Answer image 1',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_2',
            'label' => 'Answer image 2',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_3',
            'label' => 'Answer image 3',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_5_answer_image_4',
            'label' => 'Answer image 4',
            'rules' => 'required|trim'
        ),
    ),
    'question_type_5_edit' => array(
        array(
            'field' => 'challenge',
            'label' => 'Challenge ID',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'question_type_5_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_5_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_6' => array(
        array(
            'field' => 'question_type_6_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_6_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_5',
            'label' => 'Answer 5',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_6',
            'label' => 'Answer 6',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_7',
            'label' => 'Answer 7',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_8',
            'label' => 'Answer 8',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_6_edit' => array(
        array(
            'field' => 'challenge',
            'label' => 'Challenge ID',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'question_type_6_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_6_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_5',
            'label' => 'Answer 5',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_6',
            'label' => 'Answer 6',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_7',
            'label' => 'Answer 7',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_8',
            'label' => 'Answer 8',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_6_running_game' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_6_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_6_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_5',
            'label' => 'Answer 5',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_6',
            'label' => 'Answer 6',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_7',
            'label' => 'Answer 7',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_8',
            'label' => 'Answer 8',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_6_running_game_question' => array(
        array(
            'field' => 'question_type_6_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_6_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_5',
            'label' => 'Answer 5',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_6',
            'label' => 'Answer 6',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_7',
            'label' => 'Answer 7',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_8',
            'label' => 'Answer 8',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_6_brain_runner' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_6_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_6_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_5',
            'label' => 'Answer 5',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_6',
            'label' => 'Answer 6',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_7',
            'label' => 'Answer 7',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_8',
            'label' => 'Answer 8',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_6_brain_runner_question' => array(
        array(
            'field' => 'question_type_6_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_6_answer_1',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_2',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_3',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_4',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_5',
            'label' => 'Answer 5',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_6',
            'label' => 'Answer 6',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_7',
            'label' => 'Answer 7',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_answer_8',
            'label' => 'Answer 8',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_6_correct',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_7' => array(
        array(
            'field' => 'question_type_7_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_7_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        )
    ),
    'question_type_7_edit' => array(
        array(
            'field' => 'challenge',
            'label' => 'Challenge ID',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'question_type_7_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_7_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        )
    ),
    'question_type_7_running_game' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_7_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_7_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        )
    ),
    'question_type_7_running_game_question' => array(
        array(
            'field' => 'question_type_7_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_7_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        )
    ),
    'question_type_7_brain_runner' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_7_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_7_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        )
    ),
    'question_type_7_brain_runner_question' => array(
        array(
            'field' => 'question_type_7_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_7_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        )
    ),
    'question_type_8' => array(
        array(
            'field' => 'question_type_8_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_8_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        ),
        array(
            'field' => 'question_type_8_question_image',
            'label' => 'Question image',
            'rules' => 'required|trim|'
        )
    ),
    'question_type_8_running_game' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_8_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_8_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        ),
        array(
            'field' => 'question_type_8_question_image',
            'label' => 'Question image',
            'rules' => 'required|trim|'
        )
    ),
    'question_type_8_running_game_question' => array(
        array(
            'field' => 'question_type_8_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_8_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        ),
        array(
            'field' => 'question_type_8_question_image',
            'label' => 'Question image',
            'rules' => 'required|trim|'
        )
    ),
    'question_type_8_running_game_question_edit' => array(
        array(
            'field' => 'question_type_8_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_8_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        )
    ),
    'question_type_8_brain_runner' => array(
        array(
            'field' => 'challenge_name',
            'label' => 'Challenge name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'subject',
            'label' => 'Subject',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'skill',
            'label' => 'Skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'grade',
            'label' => 'Grade',
            'rules' => 'integer|required|trim'
        ), array(
            'field' => 'game_code',
            'label' => 'Game',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'topic',
            'label' => 'Sub skill',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'description',
            'label' => 'Description',
            'rules' => 'trim'
        ),
        array(
            'field' => 'question_type_8_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_8_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        ),
        array(
            'field' => 'question_type_8_question_image',
            'label' => 'Question image',
            'rules' => 'required|trim|'
        )
    ),
    'question_type_8_brain_runner_question' => array(
        array(
            'field' => 'question_type_8_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_8_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        ),
        array(
            'field' => 'question_type_8_question_image',
            'label' => 'Question image',
            'rules' => 'required|trim|'
        )
    ),
    'question_type_8_edit' => array(
        array(
            'field' => 'challenge',
            'label' => 'Challenge ID',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'question_type_8_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_8_answer',
            'label' => 'Answer',
            'rules' => 'required|trim|numeric|max_length[9]'
        )
    ),
    'question_type_9' => array(
        array(
            'field' => 'question_type_9_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_9_question_image',
            'label' => 'Question image',
            'rules' => 'required|trim|'
        ),
        array(
            'field' => 'question_type_9_answer[1]',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_9_answer[2]',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_9_answer[3]',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_9_answer[4]',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_9_correct_text',
            'field' => 'question_type_9_correct_text',
            'label' => 'Correct',
            'rules' => 'required|trim'
        )
    ),
    'question_type_9_edit' => array(
        array(
            'field' => 'challenge',
            'label' => 'Challenge ID',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'id',
            'label' => 'Id',
            'rules' => 'required|trim|integer'
        ),
        array(
            'field' => 'question_type_9_question',
            'label' => 'Question',
            'rules' => 'required|trim|max_length[150]'
        ),
        array(
            'field' => 'question_type_9_correct_text',
            'label' => 'Correct',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'question_type_9_answer[1]',
            'label' => 'Answer 1',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_9_answer[2]',
            'label' => 'Answer 2',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_9_answer[3]',
            'label' => 'Answer 3',
            'rules' => 'required|trim|max_length[50]'
        ),
        array(
            'field' => 'question_type_9_answer[4]',
            'label' => 'Answer 4',
            'rules' => 'required|trim|max_length[50]'
        )
    ),
    'marketplace_install' => array(
        array(
            'field' => 'class',
            'label' => 'Class',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'challenge',
            'label' => 'Challenge',
            'rules' => 'integer|required|trim'
        )
    ),
    'challenge_install' => array(
        array(
            'field' => 'class',
            'label' => 'Class',
            'rules' => 'integer|required|trim'
        ),
        array(
            'field' => 'challenge',
            'label' => 'Challenge',
            'rules' => 'integer|required|trim'
        )
    ),
    'teacher_registration' => array(
        array(
            'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'first_name',
            'label' => 'First name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'last_name',
            'label' => 'Last name',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'valid_email|required|trim'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 're_password',
            'label' => 'Repeat password',
            'rules' => 'required|trim|matches[password]'
        ),
        array(
            'field' => 'terms_and_policy',
            'label' => 'Terms and policy',
            'rules' => 'required|trim'
        )
    ),
    'student_change_password' => array(
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|trim'
        ),
        array(
            'field' => 're_password',
            'label' => 'Retype password',
            'rules' => 'required|trim|matches[password]'
        )
    )
);
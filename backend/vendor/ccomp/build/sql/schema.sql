
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- admin
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin`
(
	`username` VARCHAR(255) NOT NULL,
	`first_name` VARCHAR(100),
	`last_name` VARCHAR(100),
	`email` VARCHAR(255) NOT NULL,
	`password` VARCHAR(50) NOT NULL,
	`last_login_time` DATETIME,
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	`slug` VARCHAR(255),
	PRIMARY KEY (`id`),
	UNIQUE INDEX `admin_slug` (`slug`(255))
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- admin_token
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `admin_token`;

CREATE TABLE `admin_token`
(
	`admin_id` INTEGER NOT NULL,
	`token` VARCHAR(100) NOT NULL,
	`ttl` INTEGER(5) NOT NULL,
	`type` TINYINT NOT NULL,
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `admin_token_I_1` (`admin_id`),
	INDEX `admin_token_I_2` (`token`),
	INDEX `admin_token_I_3` (`type`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- games
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `games`;

CREATE TABLE `games`
(
	`game_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(45) NOT NULL,
	`game_code` VARCHAR(45),
	PRIMARY KEY (`game_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- game_levels
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `game_levels`;

CREATE TABLE `game_levels`
(
	`gamelevel_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`game_id` INTEGER(11) NOT NULL,
	`name` VARCHAR(45) NOT NULL,
	PRIMARY KEY (`gamelevel_id`),
	INDEX `game_levels_FI_1` (`game_id`),
	CONSTRAINT `game_levels_FK_1`
		FOREIGN KEY (`game_id`)
		REFERENCES `games` (`game_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- subjects
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects`
(
	`subject_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(45) NOT NULL,
	PRIMARY KEY (`subject_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- skills
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `skills`;

CREATE TABLE `skills`
(
	`skill_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(45) NOT NULL,
	`subject_id` INTEGER(11) NOT NULL,
	PRIMARY KEY (`skill_id`),
	INDEX `skills_FI_1` (`subject_id`),
	CONSTRAINT `skills_FK_1`
		FOREIGN KEY (`subject_id`)
		REFERENCES `subjects` (`subject_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- topics
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `topics`;

CREATE TABLE `topics`
(
	`topic_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(45) NOT NULL,
	`skill_id` INTEGER(11) NOT NULL,
	PRIMARY KEY (`topic_id`),
	INDEX `topics_FI_1` (`skill_id`),
	CONSTRAINT `topics_FK_1`
		FOREIGN KEY (`skill_id`)
		REFERENCES `skills` (`skill_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
	`user_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`created` DATETIME NOT NULL,
	`modified` DATETIME,
	`login` VARCHAR(45) NOT NULL,
	`password` VARCHAR(45) NOT NULL,
	`first_name` VARCHAR(45) NOT NULL,
	`last_name` VARCHAR(45) NOT NULL,
	`email` VARCHAR(45),
	PRIMARY KEY (`user_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- user_activity
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user_activity`;

CREATE TABLE `user_activity`
(
	`user_activity_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER(11) NOT NULL,
	`last_action` VARCHAR(100) NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`user_activity_id`),
	INDEX `user_activity_I_1` (`updated_at`),
	INDEX `user_activity_FI_1` (`user_id`),
	CONSTRAINT `user_activity_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `users` (`user_id`)
		ON DELETE CASCADE
) ENGINE=MyISAM CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- teachers
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `teachers`;

CREATE TABLE `teachers`
(
	`teacher_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER(11) NOT NULL,
	`created` DATETIME NOT NULL,
	`modified` DATETIME,
	`image_thumb` LONGBLOB,
	`school_id` INTEGER(15),
	`school` VARCHAR(150),
	`biography` TEXT,
	`auth_code` VARCHAR(100),
	`time_diff` VARCHAR(3) DEFAULT '0',
	`publisher` TINYINT DEFAULT 0 NOT NULL,
	`country` VARCHAR(2),
	`view_intro` TINYINT DEFAULT 0,
	`twitter_name` VARCHAR(150),
	`facebook_link` VARCHAR(150),
	`import_id` INTEGER(11) DEFAULT 0,
	`last_login_time` DATETIME,
	PRIMARY KEY (`teacher_id`,`user_id`),
	INDEX `teachers_FI_1` (`user_id`),
	INDEX `teachers_FI_2` (`school_id`),
	CONSTRAINT `teachers_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `users` (`user_id`)
		ON DELETE CASCADE,
	CONSTRAINT `teachers_FK_2`
		FOREIGN KEY (`school_id`)
		REFERENCES `school` (`school_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- teacher_grades
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `teacher_grades`;

CREATE TABLE `teacher_grades`
(
	`teacher_grade_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`teacher_id` INTEGER(11) NOT NULL,
	`grade` INTEGER(11) NOT NULL,
	PRIMARY KEY (`teacher_grade_id`),
	INDEX `teacher_grades_FI_1` (`teacher_id`),
	CONSTRAINT `teacher_grades_FK_1`
		FOREIGN KEY (`teacher_id`)
		REFERENCES `teachers` (`teacher_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- teachers_token
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `teachers_token`;

CREATE TABLE `teachers_token`
(
	`teacher_id` INTEGER NOT NULL,
	`token` VARCHAR(100) NOT NULL,
	`ttl` INTEGER(5) NOT NULL,
	`type` TINYINT NOT NULL,
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `teachers_token_I_1` (`teacher_id`),
	INDEX `teachers_token_I_2` (`token`),
	INDEX `teachers_token_I_3` (`type`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- teacher_order
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `teacher_order`;

CREATE TABLE `teacher_order`
(
	`teacher_id` INTEGER(11) NOT NULL,
	`live` TINYINT DEFAULT 0 NOT NULL,
	`payment_id` VARCHAR(50),
	`amount` FLOAT,
	`license_count` INTEGER(11) NOT NULL,
	`status` TINYINT DEFAULT 0,
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `teacher_order_FI_1` (`teacher_id`),
	CONSTRAINT `teacher_order_FK_1`
		FOREIGN KEY (`teacher_id`)
		REFERENCES `teachers` (`teacher_id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- teacher_pay_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `teacher_pay_log`;

CREATE TABLE `teacher_pay_log`
(
	`order_id` INTEGER(11) NOT NULL,
	`teacher_id` INTEGER(11) NOT NULL,
	`status` TINYINT DEFAULT 0,
	`token_id` VARCHAR(50),
	`raw_response` LONGTEXT,
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `teacher_pay_log_FI_1` (`order_id`),
	INDEX `teacher_pay_log_FI_2` (`teacher_id`),
	CONSTRAINT `teacher_pay_log_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `teacher_order` (`id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL,
	CONSTRAINT `teacher_pay_log_FK_2`
		FOREIGN KEY (`teacher_id`)
		REFERENCES `teachers` (`teacher_id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- teacher_license
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `teacher_license`;

CREATE TABLE `teacher_license`
(
	`teacher_id` INTEGER(11) NOT NULL,
	`count` INTEGER(11) NOT NULL,
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `teacher_license_FI_1` (`teacher_id`),
	CONSTRAINT `teacher_license_FK_1`
		FOREIGN KEY (`teacher_id`)
		REFERENCES `teachers` (`teacher_id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- teacher_import
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `teacher_import`;

CREATE TABLE `teacher_import`
(
	`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	`file_ext` VARCHAR(5),
	`file` LONGBLOB,
	`status` TINYINT DEFAULT 0,
	`result_log` LONGTEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- students
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students`
(
	`student_id` INTEGER(11) NOT NULL,
	`created` DATETIME NOT NULL,
	`modified` DATETIME,
	`user_id` INTEGER(11) NOT NULL,
	`avatar_settings` VARCHAR(1000),
	`avatar_image` LONGBLOB,
	`image_thumb` LONGBLOB,
	`avatar_thumbnail` LONGBLOB,
	`parent_email` VARCHAR(45),
	`dob` VARCHAR(45),
	`grade_id` INTEGER(11) DEFAULT 0,
	`gender` TINYINT(2) DEFAULT 0 NOT NULL,
	`import_id` INTEGER(11) DEFAULT 0,
	PRIMARY KEY (`student_id`,`user_id`),
	INDEX `students_FI_1` (`user_id`),
	INDEX `students_FI_2` (`grade_id`),
	CONSTRAINT `students_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `users` (`user_id`),
	CONSTRAINT `students_FK_2`
		FOREIGN KEY (`grade_id`)
		REFERENCES `grades` (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- student_import
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `student_import`;

CREATE TABLE `student_import`
(
	`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`teacher_id` INTEGER(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL,
	`file_ext` VARCHAR(5),
	`file` LONGBLOB,
	`status` TINYINT DEFAULT 0,
	`result_log` LONGTEXT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `student_import_FI_1` (`teacher_id`),
	CONSTRAINT `student_import_FK_1`
		FOREIGN KEY (`teacher_id`)
		REFERENCES `teachers` (`teacher_id`)
		ON DELETE CASCADE
) ENGINE=MyISAM CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- classes
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `classes`;

CREATE TABLE `classes`
(
	`class_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`teacher_id` INTEGER(11) NOT NULL,
	`name` VARCHAR(45) NOT NULL,
	`auth_code` VARCHAR(45) NOT NULL,
	`price` FLOAT DEFAULT 0,
	`limit` INTEGER DEFAULT 0,
	PRIMARY KEY (`class_id`),
	INDEX `classes_FI_1` (`teacher_id`),
	CONSTRAINT `classes_FK_1`
		FOREIGN KEY (`teacher_id`)
		REFERENCES `teachers` (`teacher_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- class_details
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `class_details`;

CREATE TABLE `class_details`
(
	`class_id` INTEGER(11) NOT NULL,
	`class_details_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`description` TEXT,
	`image` LONGBLOB,
	PRIMARY KEY (`class_details_id`),
	INDEX `class_details_FI_1` (`class_id`),
	CONSTRAINT `class_details_FK_1`
		FOREIGN KEY (`class_id`)
		REFERENCES `classes` (`class_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- class_students
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `class_students`;

CREATE TABLE `class_students`
(
	`classstud_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`class_id` INTEGER(11) NOT NULL,
	`student_id` INTEGER(11) NOT NULL,
	`is_deleted` TINYINT(4) DEFAULT 0 NOT NULL,
	`is_active` TINYINT(4) DEFAULT 1 NOT NULL,
	PRIMARY KEY (`classstud_id`,`class_id`,`student_id`),
	INDEX `class_students_FI_1` (`class_id`),
	INDEX `class_students_FI_2` (`student_id`),
	CONSTRAINT `class_students_FK_1`
		FOREIGN KEY (`class_id`)
		REFERENCES `classes` (`class_id`),
	CONSTRAINT `class_students_FK_2`
		FOREIGN KEY (`student_id`)
		REFERENCES `students` (`student_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- challenges
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `challenges`;

CREATE TABLE `challenges`
(
	`challenge_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(45) NOT NULL,
	`subject_id` INTEGER(11) NOT NULL,
	`skill_id` INTEGER(11) NOT NULL,
	`topic_id` INTEGER(11),
	`level` INTEGER(11) NOT NULL,
	`game_id` INTEGER(11),
	`gamelevel_id` INTEGER(11),
	`user_id` INTEGER(11),
	`import_id` INTEGER(11),
	`description` LONGTEXT,
	`is_public` TINYINT DEFAULT 0 NOT NULL,
	`desc` VARCHAR(1024),
	`read_title` VARCHAR(45),
	`read_text` LONGTEXT,
	`read_image` LONGBLOB,
	PRIMARY KEY (`challenge_id`),
	INDEX `challenges_FI_1` (`subject_id`),
	INDEX `challenges_FI_2` (`skill_id`),
	INDEX `challenges_FI_3` (`topic_id`),
	INDEX `challenges_FI_4` (`game_id`),
	INDEX `challenges_FI_5` (`gamelevel_id`),
	CONSTRAINT `challenges_FK_1`
		FOREIGN KEY (`subject_id`)
		REFERENCES `subjects` (`subject_id`),
	CONSTRAINT `challenges_FK_2`
		FOREIGN KEY (`skill_id`)
		REFERENCES `skills` (`skill_id`),
	CONSTRAINT `challenges_FK_3`
		FOREIGN KEY (`topic_id`)
		REFERENCES `topics` (`topic_id`),
	CONSTRAINT `challenges_FK_4`
		FOREIGN KEY (`game_id`)
		REFERENCES `games` (`game_id`),
	CONSTRAINT `challenges_FK_5`
		FOREIGN KEY (`gamelevel_id`)
		REFERENCES `game_levels` (`gamelevel_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- challenge_classes
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `challenge_classes`;

CREATE TABLE `challenge_classes`
(
	`challclass_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`challenge_id` INTEGER(11) NOT NULL,
	`class_id` INTEGER(11) NOT NULL,
	PRIMARY KEY (`challclass_id`),
	INDEX `challenge_classes_FI_1` (`challenge_id`),
	INDEX `challenge_classes_FI_2` (`class_id`),
	CONSTRAINT `challenge_classes_FK_1`
		FOREIGN KEY (`challenge_id`)
		REFERENCES `challenges` (`challenge_id`),
	CONSTRAINT `challenge_classes_FK_2`
		FOREIGN KEY (`class_id`)
		REFERENCES `classes` (`class_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- challenge_questions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `challenge_questions`;

CREATE TABLE `challenge_questions`
(
	`chalquest_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`challenge_id` INTEGER(11) NOT NULL,
	`question_id` INTEGER(11) NOT NULL,
	`seq_num` INTEGER(11) NOT NULL,
	`import_id` INTEGER(11),
	PRIMARY KEY (`chalquest_id`),
	INDEX `challenge_questions_FI_1` (`challenge_id`),
	INDEX `challenge_questions_FI_2` (`question_id`),
	CONSTRAINT `challenge_questions_FK_1`
		FOREIGN KEY (`challenge_id`)
		REFERENCES `challenges` (`challenge_id`),
	CONSTRAINT `challenge_questions_FK_2`
		FOREIGN KEY (`question_id`)
		REFERENCES `questions` (`question_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- questions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions`
(
	`question_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`subject_id` INTEGER(11) NOT NULL,
	`skill_id` INTEGER(11) NOT NULL,
	`topic_id` INTEGER(11) NOT NULL,
	`level` INTEGER(11) NOT NULL,
	`type` VARCHAR(45) NOT NULL,
	`text` VARCHAR(200) NOT NULL,
	`image` LONGBLOB,
	`image_type` VARCHAR(50),
	`correct_choice_id` INTEGER(11),
	`correct_text` VARCHAR(45),
	`is_deleted` TINYINT DEFAULT 0,
	`import_id` INTEGER(11),
	`large_space` TINYINT DEFAULT 0,
	`read_text` LONGTEXT,
	PRIMARY KEY (`question_id`),
	INDEX `questions_FI_1` (`subject_id`),
	INDEX `questions_FI_2` (`skill_id`),
	CONSTRAINT `questions_FK_1`
		FOREIGN KEY (`subject_id`)
		REFERENCES `subjects` (`subject_id`),
	CONSTRAINT `questions_FK_2`
		FOREIGN KEY (`skill_id`)
		REFERENCES `skills` (`skill_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- question_choices
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `question_choices`;

CREATE TABLE `question_choices`
(
	`choice_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`question_id` INTEGER(11) NOT NULL,
	`text` VARCHAR(45),
	`image` LONGBLOB,
	`import_id` INTEGER(11),
	PRIMARY KEY (`choice_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- connections
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `connections`;

CREATE TABLE `connections`
(
	`conn_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`from_user_id` INTEGER(11) NOT NULL,
	`to_user_id` INTEGER(11) NOT NULL,
	`created` DATETIME NOT NULL,
	`modified` DATETIME,
	`status` VARCHAR(100),
	PRIMARY KEY (`conn_id`),
	INDEX `connections_FI_1` (`from_user_id`),
	INDEX `connections_FI_2` (`to_user_id`),
	CONSTRAINT `connections_FK_1`
		FOREIGN KEY (`from_user_id`)
		REFERENCES `users` (`user_id`),
	CONSTRAINT `connections_FK_2`
		FOREIGN KEY (`to_user_id`)
		REFERENCES `users` (`user_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- shop_categories
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `shop_categories`;

CREATE TABLE `shop_categories`
(
	`shopcat_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(256),
	PRIMARY KEY (`shopcat_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- shop_items
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `shop_items`;

CREATE TABLE `shop_items`
(
	`shopitem_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`shopcat_id` INTEGER(11),
	`name` VARCHAR(45),
	`asset_bundle_name` VARCHAR(256),
	`asset_bundle_version` INTEGER(11) NOT NULL,
	`icon` LONGBLOB,
	`icon_url` VARCHAR(1024),
	`num_coins` INTEGER(11),
	`gender` VARCHAR(45),
	PRIMARY KEY (`shopitem_id`),
	INDEX `shop_items_FI_1` (`shopcat_id`),
	CONSTRAINT `shop_items_FK_1`
		FOREIGN KEY (`shopcat_id`)
		REFERENCES `shop_categories` (`shopcat_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- shop_transactions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `shop_transactions`;

CREATE TABLE `shop_transactions`
(
	`shoptran_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`student_id` INTEGER(11) NOT NULL,
	`created` DATETIME NOT NULL,
	`type` TINYINT NOT NULL,
	`shopitem_id` INTEGER(11),
	`num_coins` INTEGER(11) NOT NULL,
	`description` VARCHAR(256),
	`class_id` INTEGER(11),
	`challenge_id` INTEGER(11),
	PRIMARY KEY (`shoptran_id`),
	INDEX `shop_transactions_FI_1` (`shopitem_id`),
	INDEX `shop_transactions_FI_2` (`student_id`),
	CONSTRAINT `shop_transactions_FK_1`
		FOREIGN KEY (`shopitem_id`)
		REFERENCES `shop_items` (`shopitem_id`),
	CONSTRAINT `shop_transactions_FK_2`
		FOREIGN KEY (`student_id`)
		REFERENCES `students` (`student_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- student_tokens
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `student_tokens`;

CREATE TABLE `student_tokens`
(
	`token_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`student_id` INTEGER(11) NOT NULL,
	`created` DATETIME NOT NULL,
	`modified` DATETIME,
	`auth_key` VARCHAR(45) NOT NULL,
	`auth_secret` VARCHAR(45) NOT NULL,
	`status` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`token_id`),
	INDEX `student_tokens_FI_1` (`student_id`),
	CONSTRAINT `student_tokens_FK_1`
		FOREIGN KEY (`student_id`)
		REFERENCES `students` (`student_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- scores
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `scores`;

CREATE TABLE `scores`
(
	`score_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`created` DATETIME,
	`challenge_id` INTEGER(11) NOT NULL,
	`student_id` INTEGER(11) NOT NULL,
	`total_duration` TIME NOT NULL,
	`total_duration_secs` FLOAT NOT NULL,
	`game_event_data` VARCHAR(1024),
	`class_id` INTEGER(11),
	`score_average` FLOAT,
	`num_coins` INTEGER(11),
	`num_total_questions` INTEGER(11),
	`num_correct_questions` INTEGER(11),
	PRIMARY KEY (`score_id`),
	INDEX `scores_FI_1` (`class_id`),
	INDEX `scores_FI_2` (`challenge_id`),
	INDEX `scores_FI_3` (`student_id`),
	CONSTRAINT `scores_FK_1`
		FOREIGN KEY (`class_id`)
		REFERENCES `classes` (`class_id`),
	CONSTRAINT `scores_FK_2`
		FOREIGN KEY (`challenge_id`)
		REFERENCES `challenges` (`challenge_id`),
	CONSTRAINT `scores_FK_3`
		FOREIGN KEY (`student_id`)
		REFERENCES `students` (`student_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- score_answers
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `score_answers`;

CREATE TABLE `score_answers`
(
	`answer_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`score_id` INTEGER(11) NOT NULL,
	`question_id` INTEGER(11) NOT NULL,
	`choice_id` INTEGER(11),
	`text` VARCHAR(45),
	`game_event_data` VARCHAR(100),
	PRIMARY KEY (`answer_id`),
	INDEX `score_answers_FI_1` (`score_id`),
	INDEX `score_answers_FI_2` (`question_id`),
	INDEX `score_answers_FI_3` (`choice_id`),
	CONSTRAINT `score_answers_FK_1`
		FOREIGN KEY (`score_id`)
		REFERENCES `scores` (`score_id`),
	CONSTRAINT `score_answers_FK_2`
		FOREIGN KEY (`question_id`)
		REFERENCES `questions` (`question_id`),
	CONSTRAINT `score_answers_FK_3`
		FOREIGN KEY (`choice_id`)
		REFERENCES `question_choices` (`choice_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- school
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `school`;

CREATE TABLE `school`
(
	`school_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(256) NOT NULL,
	`state` VARCHAR(2),
	`county` VARCHAR(50) DEFAULT 'US',
	`country` VARCHAR(2),
	`city` VARCHAR(50),
	`zip_code` VARCHAR(10),
	`approved` TINYINT(4) DEFAULT 1,
	`is_public` TINYINT(2) DEFAULT 1,
	PRIMARY KEY (`school_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- parents
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parents`;

CREATE TABLE `parents`
(
	`parent_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`user_id` INTEGER(11) NOT NULL,
	`created` DATETIME NOT NULL,
	`modified` DATETIME,
	`image_thumb` LONGBLOB,
	`auth_code` VARCHAR(100),
	`time_diff` VARCHAR(3) DEFAULT '0',
	`country` VARCHAR(20),
	`postal_code` VARCHAR(20),
	`view_intro` TINYINT DEFAULT 0,
	PRIMARY KEY (`parent_id`),
	INDEX `parents_FI_1` (`user_id`),
	CONSTRAINT `parents_FK_1`
		FOREIGN KEY (`user_id`)
		REFERENCES `users` (`user_id`)
		ON DELETE CASCADE
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- parents_social_google
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parents_social_google`;

CREATE TABLE `parents_social_google`
(
	`soc_google_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`parent_id` INTEGER(11) NOT NULL,
	`google_auth_code` VARCHAR(255),
	PRIMARY KEY (`soc_google_id`),
	INDEX `parents_social_google_FI_1` (`parent_id`),
	CONSTRAINT `parents_social_google_FK_1`
		FOREIGN KEY (`parent_id`)
		REFERENCES `parents` (`parent_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- parents_social_facebook
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parents_social_facebook`;

CREATE TABLE `parents_social_facebook`
(
	`soc_facebook_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`parent_id` INTEGER(11) NOT NULL,
	`facebook_auth_code` VARCHAR(255),
	PRIMARY KEY (`soc_facebook_id`),
	INDEX `parents_social_facebook_FI_1` (`parent_id`),
	CONSTRAINT `parents_social_facebook_FK_1`
		FOREIGN KEY (`parent_id`)
		REFERENCES `parents` (`parent_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- parents_social_linkedin
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parents_social_linkedin`;

CREATE TABLE `parents_social_linkedin`
(
	`soc_linkedin_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`parent_id` INTEGER(11) NOT NULL,
	`linkedin_auth_code` VARCHAR(255),
	PRIMARY KEY (`soc_linkedin_id`),
	INDEX `parents_social_linkedin_FI_1` (`parent_id`),
	CONSTRAINT `parents_social_linkedin_FK_1`
		FOREIGN KEY (`parent_id`)
		REFERENCES `parents` (`parent_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- parent_students
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parent_students`;

CREATE TABLE `parent_students`
(
	`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`parent_id` INTEGER(11) NOT NULL,
	`student_id` INTEGER(11) NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `parent_students_FI_1` (`parent_id`),
	INDEX `parent_students_FI_2` (`student_id`),
	CONSTRAINT `parent_students_FK_1`
		FOREIGN KEY (`parent_id`)
		REFERENCES `parents` (`parent_id`)
		ON DELETE CASCADE,
	CONSTRAINT `parent_students_FK_2`
		FOREIGN KEY (`student_id`)
		REFERENCES `students` (`student_id`)
		ON DELETE CASCADE
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- subscriber
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `subscriber`;

CREATE TABLE `subscriber`
(
	`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(45) NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- timezone
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `timezone`;

CREATE TABLE `timezone`
(
	`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	`difference` VARCHAR(3) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- grades
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `grades`;

CREATE TABLE `grades`
(
	`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- parent_activation
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parent_activation`;

CREATE TABLE `parent_activation`
(
	`parent_id` INTEGER(11) NOT NULL,
	`class_id` INTEGER(11) NOT NULL,
	`quantity` INTEGER(11),
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `parent_activation_FI_1` (`parent_id`),
	INDEX `parent_activation_FI_2` (`class_id`),
	CONSTRAINT `parent_activation_FK_1`
		FOREIGN KEY (`parent_id`)
		REFERENCES `parents` (`parent_id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL,
	CONSTRAINT `parent_activation_FK_2`
		FOREIGN KEY (`class_id`)
		REFERENCES `classes` (`class_id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- parent_order
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parent_order`;

CREATE TABLE `parent_order`
(
	`parent_id` INTEGER(11) NOT NULL,
	`live` TINYINT DEFAULT 0 NOT NULL,
	`payment_id` VARCHAR(50),
	`amount` FLOAT,
	`status` TINYINT DEFAULT 0,
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `parent_order_FI_1` (`parent_id`),
	CONSTRAINT `parent_order_FK_1`
		FOREIGN KEY (`parent_id`)
		REFERENCES `parents` (`parent_id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- parent_bucket
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parent_bucket`;

CREATE TABLE `parent_bucket`
(
	`order_id` INTEGER(11) NOT NULL,
	`parent_id` INTEGER(11) NOT NULL,
	`class_id` INTEGER(11) NOT NULL,
	`student_id` INTEGER(11) NOT NULL,
	`price` FLOAT NOT NULL,
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `parent_bucket_FI_1` (`order_id`),
	INDEX `parent_bucket_FI_2` (`class_id`),
	INDEX `parent_bucket_FI_3` (`student_id`),
	INDEX `parent_bucket_FI_4` (`parent_id`),
	CONSTRAINT `parent_bucket_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `parent_order` (`id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL,
	CONSTRAINT `parent_bucket_FK_2`
		FOREIGN KEY (`class_id`)
		REFERENCES `classes` (`class_id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL,
	CONSTRAINT `parent_bucket_FK_3`
		FOREIGN KEY (`student_id`)
		REFERENCES `students` (`student_id`)
		ON DELETE CASCADE,
	CONSTRAINT `parent_bucket_FK_4`
		FOREIGN KEY (`parent_id`)
		REFERENCES `parents` (`parent_id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- parent_pay_log
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `parent_pay_log`;

CREATE TABLE `parent_pay_log`
(
	`order_id` INTEGER(11) NOT NULL,
	`parent_id` INTEGER(11) NOT NULL,
	`status` TINYINT DEFAULT 0,
	`token_id` VARCHAR(50),
	`raw_response` LONGTEXT,
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`),
	INDEX `parent_pay_log_FI_1` (`order_id`),
	INDEX `parent_pay_log_FI_2` (`parent_id`),
	CONSTRAINT `parent_pay_log_FK_1`
		FOREIGN KEY (`order_id`)
		REFERENCES `parent_order` (`id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL,
	CONSTRAINT `parent_pay_log_FK_2`
		FOREIGN KEY (`parent_id`)
		REFERENCES `parents` (`parent_id`)
		ON UPDATE SET NULL
		ON DELETE SET NULL
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- challenge_import
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `challenge_import`;

CREATE TABLE `challenge_import`
(
	`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`teacher_id` INTEGER(11) NOT NULL,
	`name` VARCHAR(100) NOT NULL,
	`file` LONGBLOB NOT NULL,
	`importer` VARCHAR(50) NOT NULL,
	`use_ftp` TINYINT DEFAULT 0 NOT NULL,
	`ftp_username` VARCHAR(100),
	`ftp_password` VARCHAR(100),
	PRIMARY KEY (`id`),
	INDEX `challenge_import_FI_1` (`teacher_id`),
	CONSTRAINT `challenge_import_FK_1`
		FOREIGN KEY (`teacher_id`)
		REFERENCES `teachers` (`teacher_id`)
		ON DELETE CASCADE
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- country
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country`
(
	`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`iso2code` VARCHAR(2) NOT NULL,
	`status` TINYINT DEFAULT 0,
	`name` VARCHAR(100) NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;

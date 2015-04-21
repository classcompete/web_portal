<?php

class Migration_create_student_import extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE `student_import`
				(
					`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
					`teacher_id` INTEGER(11) NOT NULL,
					`name` VARCHAR(100) NOT NULL,
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
				";

        $this->db->query($sql);
    }

    public function down(){}
}
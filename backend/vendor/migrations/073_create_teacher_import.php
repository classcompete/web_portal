<?php

class Migration_create_teacher_import extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE `teacher_import`
				(
					`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
					`name` VARCHAR(100) NOT NULL,
					`file` LONGBLOB,
					`status` TINYINT DEFAULT 0,
					`created_at` DATETIME,
					`updated_at` DATETIME,
					PRIMARY KEY (`id`)
				) ENGINE=MyISAM;";

        $this->db->query($sql);

        $sql = "ALTER TABLE `teachers` ADD
				(
					`import_id` INTEGER(11) DEFAULT 0
				);";

        $this->db->query($sql);
    }

    public function down(){}
}
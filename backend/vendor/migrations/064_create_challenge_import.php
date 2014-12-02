<?php

class Migration_create_challenge_import extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE `challenge_import`
                (
                    `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
                    teacher_id INT NOT NULL,
                    `name` VARCHAR(100),
                    `file` LONGBLOB NOT NULL,
                    `importer` VARCHAR(50) NOT NULL,
                    `use_ftp` TINYINT DEFAULT 0 NOT NULL,
                    `ftp_username` VARCHAR(100),
                    `ftp_password` VARCHAR(100),
                    PRIMARY KEY (`id`),
                    FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
                ) ENGINE=MyISAM;";

        $this->db->query($sql);
    }

    public function down(){}
}
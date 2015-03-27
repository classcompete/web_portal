<?php

class Migration_create_user_activity_table extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE `user_activity`
				(
					`user_activity_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
					`user_id` INTEGER(11) NOT NULL,
					`last_action` VARCHAR(100) NOT NULL,
					`created_at` DATETIME,
					`updated_at` DATETIME,
					PRIMARY KEY (`user_activity_id`),
					INDEX `user_activity_FI_1` (`user_id`),
					CONSTRAINT `user_activity_FK_1`
						FOREIGN KEY (`user_id`)
						REFERENCES `users` (`user_id`)
						ON DELETE CASCADE
				) ENGINE=MyISAM;";

        $this->db->query($sql);
    }

    public function down(){}
}
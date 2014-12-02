<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 8/5/14
 * Time: 4:36 PM
 */
class Migration_Country_table extends Migration {

    public function up(){
        $sql = 'CREATE TABLE `country`
(
	`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`iso2code` VARCHAR(2) NOT NULL,
	`status` TINYINT DEFAULT 0,
	`name` VARCHAR(100) NOT NULL,
	`created_at` DATETIME,
	`updated_at` DATETIME,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;';

        $this->db->query($sql);
    }

    public function down(){}
}
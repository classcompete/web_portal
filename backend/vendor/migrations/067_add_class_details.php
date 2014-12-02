<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 8/5/14
 * Time: 1:51 PM
 */
class Migration_Add_class_details extends Migration {

    public function up(){
        $sql_array = array(
            'ALTER TABLE `classes` ADD
(
	`class_details_id` INTEGER(11)
);',
            'CREATE TABLE `class_details`
(
	`class_details_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`description` TEXT,
	`image` LONGBLOB,
	PRIMARY KEY (`class_details_id`)
) ENGINE=MyISAM;'
        );

        foreach($sql_array as $sql){
            $this->db->query($sql);
        }
    }

}
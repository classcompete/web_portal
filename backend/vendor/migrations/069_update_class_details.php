<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 8/7/14
 * Time: 1:22 PM
 */
class Migration_Update_class_details extends Migration {

    public function up(){

        $sql_array = array(
            'ALTER TABLE `class_details` ADD
(
	`class_id` INTEGER(11) NOT NULL
);',
            'ALTER TABLE `classes` DROP `class_details_id`;'
        );

        foreach($sql_array as $array){
            $this->db->query($array);
        }
    }


    public function down(){

    }
}
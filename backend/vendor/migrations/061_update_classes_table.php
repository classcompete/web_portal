<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 6/5/14
 * Time: 10:03 AM
 */
class Migration_Update_classes_table extends Migration {

    public function up(){
        $sql = 'ALTER TABLE `classes` ADD
(
	`price` FLOAT DEFAULT 0 NOT NULL
);';

        $this->db->query($sql);
    }

    public function down(){}

}
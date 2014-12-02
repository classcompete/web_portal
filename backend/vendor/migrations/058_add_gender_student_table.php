<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/30/14
 * Time: 4:20 PM
 */
class Migration_Add_gender_student_table extends Migration{

    public function up(){

        $sql = 'ALTER TABLE `students` ADD
(
	`gender` TINYINT(2) DEFAULT 0 NOT NULL
);';


        $this->db->query($sql);

    }

    public function down(){

    }

}
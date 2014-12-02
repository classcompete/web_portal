<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 5/13/14
 * Time: 11:11 AM
 */
class Migration_Update_student_tablev2 extends Migration {

    public function up(){
        $sql = 'ALTER TABLE `students` CHANGE `student_id` `student_id` INTEGER(11) NOT NULL;';
        $this->db->query($sql);
    }
    public function down(){}

}
<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 1/29/14
 * Time: 12:59 PM
 */
class Migration_Add_school_column_teachers_table extends Migration{

    public function up(){
        $sql = 'ALTER TABLE `teachers` ADD
                (
                    `school` VARCHAR(150)
                );';

        $this->db->query($sql);
    }

}
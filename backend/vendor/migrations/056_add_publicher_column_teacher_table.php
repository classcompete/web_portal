<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/16/14
 * Time: 3:53 PM
 */
class Migration_Add_publicher_column_teacher_table extends Migration {

    public function up(){
        $sql = "
        ALTER TABLE `teachers` ADD
        (
            `publisher` TINYINT DEFAULT 0 NOT NULL
        );";

        $this->db->query($sql);

    }
    public function down(){}

}
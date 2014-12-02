<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/20/13
 * Time: 2:12 PM
 */
class Migration_added_auth_code_teacher_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE teachers ADD(auth_code VARCHAR(100));";
        $this->db->query($sql);
    }
    public function down(){}
}
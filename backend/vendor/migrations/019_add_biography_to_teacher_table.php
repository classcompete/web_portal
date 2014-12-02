<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/13/13
 * Time: 9:52 AM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_biography_to_teacher_table extends Migration{

    public function up(){
        $sql = "ALTER TABLE teachers ADD
                (
                  biography TEXT
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
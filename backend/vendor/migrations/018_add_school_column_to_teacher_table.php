<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/12/13
 * Time: 6:45 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_school_column_to_teacher_table extends Migration{

    public function up(){
        $sql = "ALTER TABLE teachers ADD
                (
                  school VARCHAR(150)
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
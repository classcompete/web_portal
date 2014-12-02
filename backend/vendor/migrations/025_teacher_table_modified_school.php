<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/23/13
 * Time: 3:58 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_teacher_table_modified_school extends Migration{
    public function up(){
        $sql = "ALTER TABLE teachers ADD(
                        school_id INTEGER(15)
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
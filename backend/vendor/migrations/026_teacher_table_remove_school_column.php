<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/23/13
 * Time: 4:01 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_teacher_table_remove_school_column extends Migration{
    public function up(){
        $sql = "ALTER TABLE teachers DROP school;";
        $this->db->query($sql);
    }
    public function down(){}
}
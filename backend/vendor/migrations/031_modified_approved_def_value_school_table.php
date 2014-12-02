<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/26/13
 * Time: 7:07 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_modified_approved_def_value_school_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE school CHANGE approved approved TINYINT(4) DEFAULT 1;";
        $this->db->query($sql);
    }
    public function down(){}
}
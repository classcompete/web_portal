<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/26/13
 * Time: 7:25 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_add_is_public_column_school_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE school ADD(
                  is_public TINYINT(2) DEFAULT 1
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
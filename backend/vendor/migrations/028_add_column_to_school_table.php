<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/26/13
 * Time: 4:59 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_add_column_to_school_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE school ADD(
                    county VARCHAR(50),
                    zip_code VARCHAR(10),
                    approved TINYINT(4) DEFAULT 0
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
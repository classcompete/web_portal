<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/26/13
 * Time: 7:05 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_add_default_value_to_country_school_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE school CHANGE county county VARCHAR(50) DEFAULT 'US'";
        $this->db->query($sql);
    }
    public function down(){}
}
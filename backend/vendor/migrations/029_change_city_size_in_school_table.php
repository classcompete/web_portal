
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/26/13
 * Time: 5:01 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_change_city_size_in_school_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE school CHANGE city city VARCHAR(50);";
        $this->db->query($sql);
    }
    public function down(){}
}
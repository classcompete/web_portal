<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 7/16/14
 * Time: 12:34 PM
 */
class Migration_Parent_update_intro extends Migration {

    public function up(){
        $sql = "ALTER TABLE `parents` ADD ( `view_intro` TINYINT DEFAULT 0 );";

        $this->db->query($sql);
    }

    public function down(){}

}
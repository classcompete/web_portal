<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/18/13
 * Time: 11:35 AM
 */
class Migration_created_environment_code extends Migration{
    public function up(){
        $sql = "ALTER TABLE games ADD(game_code VARCHAR(45));";
        $this->db->query($sql);
    }
    public function down(){}
}
<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/4/13
 * Time: 1:07 PM
 */
class Migration_changed_is_public_column_challenges_table extends MIgration{
    public function up(){
        $sql = "ALTER TABLE challenges CHANGE is_public is_public TINYINT DEFAULT 0 NOT NULL;";
        $this->db->query($sql);
    }
    public function down(){}
}
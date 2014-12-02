<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 1/29/14
 * Time: 12:11 PM
 */
class Migration_Added_column_desc_challenges_table extends Migration{

    public function up(){
        $sql = 'ALTER TABLE `challenges` ADD
                (
                    `desc` VARCHAR(1024)
                );';
        $this->db->query($sql);
    }

    public function down(){}

}
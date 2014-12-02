<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 2/5/14
 * Time: 4:06 PM
 */
class Migration_Add_time_zone_diff_parents extends Migration{

    public function up(){

        $sql = 'ALTER TABLE `parents` ADD
                (
                    `time_diff` VARCHAR(3) DEFAULT \'0\'
                );';
        $this->db->query($sql);
    }

    public function down(){}

}
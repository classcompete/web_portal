<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 2/4/14
 * Time: 2:59 PM
 */
class Migration_Add_timezone_diff_column extends Migration{

    public function up(){
        $sql = array(
            'ALTER TABLE `teachers` ADD ( `time_diff` VARCHAR(3));',
           'ALTER TABLE `teachers` CHANGE `time_diff` `time_diff` VARCHAR(3) DEFAULT \'0\';'
        );

        foreach($sql as $query){
            $this->db->query($query);
        }
    }

    public function down(){}
}
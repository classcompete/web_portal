<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 5/5/14
 * Time: 11:58 AM
 */
class Migration_Update_parent_table extends Migration{

    public function up(){
        $sql = 'ALTER TABLE `parents` ADD
            (
                `country` VARCHAR(10),
                `postal_code` VARCHAR(10)
          );';
        $this->db->query($sql);
    }

    public function down(){}
}
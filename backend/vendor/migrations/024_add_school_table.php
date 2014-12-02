<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/23/13
 * Time: 3:53 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_add_school_table extends Migration{
    public function up(){
        $sql = "CREATE TABLE school(
                    `school_id` INTEGER(11) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(255) NOT NULL,
                    `state` VARCHAR(2),
                    `country` VARCHAR(2),
                    `city` VARCHAR(50),
                    PRIMARY KEY (`school_id`)
                    ) ENGINE=InnoDB;";
        $this->db->query($sql);
    }
    public function down(){}
}
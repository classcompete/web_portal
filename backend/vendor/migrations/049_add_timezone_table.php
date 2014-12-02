<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 2/4/14
 * Time: 2:50 PM
 */
class Migration_Add_timezone_table extends Migration{

    public function up(){
        $sql = 'CREATE TABLE `timezone`
                (
                    `id` INTEGER(11) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(10) NOT NULL,
                    `difference` VARCHAR(3) NOT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=MyISAM;';
        $this->db->query($sql);
    }

    public function down(){}

}
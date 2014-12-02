<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 2/10/14
 * Time: 1:55 PM
 */
class Migration_Add_num_coins_score_table extends Migration{

    public function up(){
        $sql = 'ALTER TABLE `scores` ADD
                (
                    `num_coins` INTEGER(11)
                );';
        $this->db->query($sql);
    }

    public function down(){}
}
<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 2/5/14
 * Time: 1:06 PM
 */
class Migration_Add_class_id_challenge_id_shop_transactions extends Migration{

    public function up(){
        $sql = 'ALTER TABLE `shop_transactions` ADD
                (
                    `class_id` INTEGER(11),
                    `challenge_id` INTEGER(11)
                );';
        $this->db->query($sql);
    }

    public function down(){}

}
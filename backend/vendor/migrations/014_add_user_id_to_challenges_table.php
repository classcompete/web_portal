<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/19/13
 * Time: 1:02 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_user_id_to_challenges_table extends Migration{

    public function up(){
        $sql = "ALTER TABLE challenges ADD(
                  user_id INTEGER(11)
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
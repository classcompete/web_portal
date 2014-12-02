<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/30/13
 * Time: 3:06 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_descritpion_column_to_challenge_table extends Migration{

    public function up(){
        $sql = "ALTER TABLE challenges ADD  (
                  description LONGTEXT
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
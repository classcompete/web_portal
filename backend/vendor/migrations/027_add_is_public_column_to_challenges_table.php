<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/25/13
 * Time: 7:44 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_add_is_public_column_to_challenges_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE challenges ADD(
                  is_public TINYINT DEFAULT 0 NOT NULL
                  );";
        $this->db->query($sql);
    }
    public function down(){}
}
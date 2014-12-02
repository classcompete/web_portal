<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/3/13
 * Time: 1:13 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_columns_to_admin_token_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE admin_token ADD
            (
                created_at DATETIME,
                updated_at DATETIME
            );";
        $this->db->query($sql);
    }
    public function down(){}
}
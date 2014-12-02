<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 10/3/13
 * Time: 6:04 PM
 * To change this template use File | Settings | File Templates.
 */

class Migration_add_column_is_deleted_question_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE questions ADD(
                    is_deleted TINYINT DEFAULT 0
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
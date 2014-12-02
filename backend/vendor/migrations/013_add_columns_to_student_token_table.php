<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/16/13
 * Time: 5:04 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_columns_to_student_token_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE students ADD
(
	avatar_thumb LONGBLOB,
	parent_email VARCHAR(45)
);";
        $this->db->query($sql);
    }
    public function down(){}
}
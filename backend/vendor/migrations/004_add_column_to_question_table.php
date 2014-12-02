<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/18/13
 * Time: 3:57 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_column_to_question_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE questions ADD
            (
                image_type VARCHAR(50)
            );";
        $this->db->query($sql);
    }
    public function down(){}
}
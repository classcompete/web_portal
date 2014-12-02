<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/16/13
 * Time: 4:26 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_topic_id_column_to_questions_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE questions ADD(
                  topic_id INTEGER(11) NOT NULL
                );";
        $this->db->query($sql);
    }
    public function down(){}
}

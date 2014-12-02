
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/16/13
 * Time: 4:05 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_column_topic_id_to_challenges extends Migration{
    public function up(){
        $sql = "ALTER TABLE challenges ADD (
                  topic_id INTEGER(11)
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
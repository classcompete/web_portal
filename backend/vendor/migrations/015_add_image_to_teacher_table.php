<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/21/13
 * Time: 10:01 AM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_image_to_teacher_table extends Migration{

    public function up(){
        $sql = "ALTER TABLE teachers ADD
                (
	            image_thumb LONGBLOB
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/26/13
 * Time: 1:37 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_column_to_students_table extends Migration{
    public function up(){
        $sql = "ALTER TABLE students ADD
                  (
	                image_thumb LONGBLOB
                  );";
        $this->db->query($sql);
    }
    public function down(){}
}
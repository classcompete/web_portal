<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/23/13
 * Time: 3:41 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Add_bob_column_students_table extends Migration{

    public function up(){
        $sql = "ALTER TABLE students ADD
                (
	            dob VARCHAR(45)
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
<?php
class Migration_update_parent_students_table_rename_id extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE parent_students
                CHANGE parstud_id id INT(11) NOT NULL AUTO_INCREMENT";
        $this->db->query($sql);
    }

    public function down()
    {

    }
}
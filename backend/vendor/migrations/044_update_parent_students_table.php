<?php
class Migration_update_parent_students_table extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE parent_students
                ADD COLUMN created_at DATETIME AFTER student_id,
                ADD COLUMN updated_at DATETIME AFTER created_at";
        $this->db->query($sql);
    }

    public function down()
    {

    }
}
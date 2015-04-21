<?php

class Migration_add_file_ext_to_teacher_and_student_import extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `teacher_import` ADD
				(
					`file_ext` VARCHAR(5)
				);
				";

        $this->db->query($sql);

        $sql = "ALTER TABLE `student_import` ADD
				(
					`file_ext` VARCHAR(5)
				);
				";

        $this->db->query($sql);
    }

    public function down(){}
}
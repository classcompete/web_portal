<?php

class Migration_add_class_id_to_student_import extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `student_import` ADD
				(
					`class_id` INTEGER(11) DEFAULT 0
				);";

        $this->db->query($sql);
    }

    public function down(){}
}
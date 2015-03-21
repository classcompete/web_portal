<?php

class Migration_add_result_log_to_teacher_import extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `teacher_import` ADD
				(
					`result_log` LONGTEXT
				);";

        $this->db->query($sql);
    }

    public function down(){}
}
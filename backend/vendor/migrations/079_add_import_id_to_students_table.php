<?php

class Migration_add_import_id_to_students_table extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `students` ADD
				(
					`import_id` INTEGER(11) DEFAULT 0
				);
				";

        $this->db->query($sql);
    }

    public function down(){}
}
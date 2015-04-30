<?php

class Migration_add_classes_foreign_key_to_student_import extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `student_import` ADD CONSTRAINT `student_import_FK_2`
				FOREIGN KEY (`class_id`)
				REFERENCES `classes` (`class_id`)
				ON UPDATE SET NULL
				ON DELETE SET NULL;";

        $this->db->query($sql);
    }

    public function down(){}
}
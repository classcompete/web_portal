<?php

class Migration_teacher_add_country extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `teachers` ADD `country` VARCHAR(2)  NULL  DEFAULT NULL  AFTER `publisher`;";
        $this->db->query($sql);
    }

    public function down(){}
}
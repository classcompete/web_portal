<?php

class Migration_add_classroom_limit extends Migration
{
    public function up()
    {
        $sql = 'ALTER TABLE `classes` ADD
                (
                    `limit` INTEGER(11) DEFAULT 0
                );';
        $this->db->query($sql);
    }

    public function down(){}
}
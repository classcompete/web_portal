<?php

class Migration_add_login_time_to_teachers_table extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `teachers` ADD
				(
					`last_login_time` DATETIME
				);";

        $this->db->query($sql);
    }

    public function down(){}
}
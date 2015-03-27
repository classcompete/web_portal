<?php

class Migration_add_index_updated_at_to_activity_table extends Migration
{
    public function up()
    {
        $sql = "CREATE INDEX `user_activity_I_1` ON `user_activity` (`updated_at`);";

        $this->db->query($sql);
    }

    public function down(){}
}
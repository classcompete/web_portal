<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/20/13
 * Time: 1:00 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_updating_scores_table extends Migration{

    public function up(){
        $sql = "ALTER TABLE scores ADD
                (
	            total_duration_secs FLOAT NOT NULL,
	            game_event_data VARCHAR(1024)
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
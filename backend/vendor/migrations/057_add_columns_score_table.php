<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/22/14
 * Time: 2:05 PM
 */
class Migration_Add_columns_score_table extends Migration{

    public function up(){
        $sql = "ALTER TABLE `scores` ADD
                (
                    `num_total_questions` INTEGER(11),
                    `num_correct_questions` INTEGER(11)
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
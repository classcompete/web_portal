<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 1/29/14
 * Time: 11:56 AM
 */
class Migration_Add_columns_score_table extends Migration{

    public function up(){
        $sql_query = array(
            'ALTER TABLE `scores` ADD ( `class_id` INTEGER(11), `score_average` FLOAT );',
            'CREATE INDEX `scores_FI_1` ON `scores` (`class_id`);',
            'ALTER TABLE `scores` ADD CONSTRAINT `scores_FK_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);'
        );

        foreach ($sql_query as $sql) {
            $this->db->query($sql);
        }
    }

    public function down(){}


}
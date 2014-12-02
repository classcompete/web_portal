<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/23/13
 * Time: 1:30 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Create_teacher_token_table extends Migration{
    public function up(){
        $sql = "CREATE TABLE teachers_token
                (
                    teacher_id INTEGER NOT NULL,
                    token VARCHAR(100) NOT NULL,
                    ttl INTEGER(5) NOT NULL,
                    type TINYINT NOT NULL,
                    id INTEGER NOT NULL AUTO_INCREMENT,
                    created_at DATETIME,
                    updated_at DATETIME,
                    PRIMARY KEY (id),
                    INDEX teachers_token_I_1 (teacher_id),
                    INDEX teachers_token_I_2 (token),
                    INDEX teachers_token_I_3 (type)
                ) ENGINE=MyISAM;";
        $this->db->query($sql);
    }
    public function down(){}
}
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/3/13
 * Time: 1:13 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Create_admin_token_table extends Migration{
    public function up(){
        $sql = "CREATE TABLE admin_token
                (
                    id INTEGER NOT NULL,
                    admin_id INTEGER NOT NULL,
                    token VARCHAR(100) NOT NULL,
                    ttl INTEGER(5) NOT NULL,
                    type TINYINT NOT NULL,
                    PRIMARY KEY (id),
                    INDEX admin_token_I_1 (admin_id),
                    INDEX admin_token_I_2 (token),
                    INDEX admin_token_I_3 (type)
                ) ENGINE=MyISAM;";
        $this->db->query($sql);
    }
    public function down(){}
}
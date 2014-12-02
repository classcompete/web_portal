<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 12/25/13
 * Time: 12:26 PM
 */
class Migration_create_parents_linkedin_table extends Migration{
    public function up(){
        $sql = "CREATE TABLE parents_social_linkedin(
                  soc_linkedin_id INTEGER(11) NOT NULL AUTO_INCREMENT,
                  parent_id INTEGER(11) NOT NULL,
                  linkedin_auth_code VARCHAR(255),
                  PRIMARY KEY (soc_linkedin_id),
                  INDEX (parent_id),
                  FOREIGN KEY (parent_id) REFERENCES parents (parent_id)
                ) ENGINE=InnoDB;";
        $this->db->query($sql);
    }
    public function down(){}
}
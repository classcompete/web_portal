<?php
class Migration_create_parents_table extends Migration{
    public function up(){
        $sql = "CREATE TABLE parents(
                  parent_id INTEGER(11) NOT NULL AUTO_INCREMENT,
                  user_id INTEGER(11) NOT NULL,
                  created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  modified TIMESTAMP,
                  image_thumb BLOB,
                  auth_code VARCHAR(100),
                  PRIMARY KEY (parent_id),
                  INDEX (user_id),
                  FOREIGN KEY (user_id) REFERENCES users (user_id)
                ) ENGINE=InnoDB;";
        $this->db->query($sql);
    }
    public function down(){}
}
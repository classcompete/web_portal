<?php
class Migration_create_subscriber_table extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE subscriber(
                id INT NOT NULL AUTO_INCREMENT,
                email VARCHAR(45) NOT NULL,
                created_at DATETIME,
                updated_at DATETIME,
                PRIMARY KEY (id)
                ) ENGINE=InnoDB;";
        $this->db->query($sql);
    }

    public function down()
    {

    }
}
<?php

class Migration_Create_admin_table extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE admin
                (
                    username VARCHAR(255) NOT NULL,
                    first_name VARCHAR(100),
                    last_name VARCHAR(100),
                    email VARCHAR(255) NOT NULL,
                    password VARCHAR(50) NOT NULL,
                    last_login_time DATETIME,
                    slug VARCHAR(255),
                    id INTEGER NOT NULL AUTO_INCREMENT,
                    created_at DATETIME,
                    updated_at DATETIME,
                    PRIMARY KEY (id),
                    UNIQUE INDEX admin_slug (slug(255))
                ) ENGINE=MyISAM;";
        $this->db->query($sql);
    }

    public function down(){}
}
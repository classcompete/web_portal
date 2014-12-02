<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Darko
 * Date: 10/16/13
 * Time: 7:04 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_add_is_deleted_class_students extends MIgration{
    public function up(){
        $sql = "ALTER TABLE class_students ADD(
                  is_deleted TINYINT(4) DEFAULT 0 NOT NULL
                );";
        $this->db->query($sql);
    }
    public function down(){}
}
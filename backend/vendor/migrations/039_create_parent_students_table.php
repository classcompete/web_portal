<?php
class Migration_create_parent_students_table extends Migration{
    public function up(){
        $sql = "CREATE TABLE parent_students(
                parstud_id INT NOT NULL AUTO_INCREMENT,
                parent_id INT NOT NULL,
                student_id INT NOT NULL,
                PRIMARY KEY (parstud_id),
                FOREIGN KEY (parent_id) REFERENCES parents(parent_id),
                FOREIGN KEY (student_id) REFERENCES students(student_id)
                ) ENGINE=InnoDB;";
        $this->db->query($sql);
    }
    public function down(){}
}
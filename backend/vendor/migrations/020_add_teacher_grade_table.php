<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/16/13
 * Time: 11:53 AM
 * To change this template use File | Settings | File Templates.
 */
class Migration_add_teacher_grade_table extends Migration{

    public function up(){
        $sql = "CREATE TABLE teacher_grades
                  (
                  teacher_grade_id INTEGER(11) NOT NULL AUTO_INCREMENT,
                  teacher_id INTEGER(11) NOT NULL,
                  grade INTEGER(11) NOT NULL,
                  PRIMARY KEY (teacher_grade_id),
                    INDEX teacher_grades_FI_1 (teacher_id),
                    CONSTRAINT teacher_grades_FK_1
                  FOREIGN KEY (teacher_id)
                  REFERENCES teachers (teacher_id)
                  ) ENGINE=InnoDB;";
        $this->db->query($sql);
    }
    public function down(){}
}
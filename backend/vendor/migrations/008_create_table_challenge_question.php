<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/16/13
 * Time: 4:14 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Create_table_challenge_question extends Migration{

    public function up(){
        $sql = "CREATE TABLE challenge_questions(
                  chalquest_id INTEGER(11) NOT NULL AUTO_INCREMENT,
	              challenge_id INTEGER(11) NOT NULL,
	              question_id INTEGER(11) NOT NULL,
	              seq_num INTEGER(11) NOT NULL,
	              PRIMARY KEY (chalquest_id)
                  ) ENGINE=MyISAM;";
        $this->db->query($sql);
    }
    public function down(){}
}
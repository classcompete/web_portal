<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/16/13
 * Time: 4:46 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Create_shop_categories extends Migration{
    public function up(){
        $sql = "CREATE TABLE shop_categories
(
	shopcat_id INTEGER(11) NOT NULL AUTO_INCREMENT,
	name VARCHAR(256),
	PRIMARY KEY (shopcat_id)
) ENGINE=MyISAM;
";
        $this->db->query($sql);
    }
    public function down(){}
}

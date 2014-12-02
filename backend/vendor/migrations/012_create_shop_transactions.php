<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/16/13
 * Time: 4:52 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Create_shop_transactions extends Migration{
    public function up(){
        $sql = "CREATE TABLE shop_transactions
(
shoptran_id INTEGER(11) NOT NULL AUTO_INCREMENT,
student_id INTEGER(11) NOT NULL,
created DATETIME NOT NULL,
type TINYINT NOT NULL,
shopitem_id INTEGER(11),
num_coins INTEGER(11) NOT NULL,
description VARCHAR(256),
PRIMARY KEY (shoptran_id),
INDEX shop_transactions_FI_1 (shopitem_id),
INDEX shop_transactions_FI_2 (student_id),
CONSTRAINT shop_transactions_FK_1
FOREIGN KEY (shopitem_id)
REFERENCES shop_items (shopitem_id),
CONSTRAINT shop_transactions_FK_2
FOREIGN KEY (student_id)
REFERENCES students (student_id)
) ENGINE=MyISAM;";
        $this->db->query($sql);
    }
    public function down(){}
}
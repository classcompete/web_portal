<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 8/16/13
 * Time: 4:51 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_Create_shop_items extends Migration{
    public function up(){
        $sql = "CREATE TABLE shop_items
(
shopitem_id INTEGER(11) NOT NULL AUTO_INCREMENT,
shopcat_id INTEGER(11),
name VARCHAR(45),
asset_bundle_name VARCHAR(256),
sset_bundle_version INTEGER(11) NOT NULL,
icon LONGBLOB,
icon_url VARCHAR(1024),
num_coins INTEGER(11),
gender VARCHAR(45),
PRIMARY KEY (shopitem_id),
INDEX shop_items_FI_1 (shopcat_id),
CONSTRAINT shop_items_FK_1
FOREIGN KEY (shopcat_id)
REFERENCES shop_categories (shopcat_id)
) ENGINE=MyISAM;";
        $this->db->query($sql);
    }
    public function down(){}
}
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/20/13
 * Time: 1:15 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_updating_shop_items extends  Migration{

    public function up(){
        $sql = "ALTER TABLE shop_items ADD
                (
	            asset_bundle_version INTEGER(11) NOT NULL
                );
                ";
        $this->db->query($sql);
    }
    public function down(){
    }

}
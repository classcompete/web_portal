<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/20/13
 * Time: 1:23 PM
 * To change this template use File | Settings | File Templates.
 */
class Migration_delete_column_from_shop_items extends Migration{

    public function up(){
        $sql = "ALTER TABLE shop_items DROP sset_bundle_version;";
        $this->db->query($sql);
    }
    public function down(){}
}
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/23/13
 * Time: 4:12 PM
 * To change this template use File | Settings | File Templates.
 */
class School_model extends CI_Model{


    public function insert_to_table($schools){
        $rows_before = $this->db->count_all('school');

        $this->db->insert_batch('school', $schools);

        $rows_after = $this->db->count_all('school');

        return $rows_after - $rows_before;
    }


}
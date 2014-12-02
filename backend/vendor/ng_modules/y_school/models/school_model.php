<?php
/**
 * Created by PhpStorm.
 * User: FenjeR
 * Date: 11/12/13
 * Time: 1:54 PM
 */
class School_model extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    /**
     * Function for filtering school for auto complete
     * $params: string
     * $out:    array
     * */
    public function find_school($school_name, $zip_code){
        $query = $this->db->select('school_id, name')
            ->limit(50)
            ->where('zip_code',intval($zip_code))
            ->where('approved',1)
            ->like('name',$school_name)
            ->get('school')->result_array();

        return $query;
    }
}
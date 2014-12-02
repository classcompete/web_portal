<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 9/23/13
 * Time: 4:07 PM
 * To change this template use File | Settings | File Templates.
 */
class School extends CI_Controller{

    public function __construct(){
        parent:: __construct();
        $this->load->model('school_model');
        ini_set("memory_limit","512M");
    }

    public function import_public_school(){
        $public_school_csv_file = file_get_contents(BASEPATH . '../teacher.classcompete.com/web/content/data/public_school.csv');

        $rows   = str_getcsv($public_school_csv_file, "\n");
        $keys   = $this->parse_row(array_shift($rows));
        $result = array();

        $this->debug('READING FROM FILE','');
        foreach ($rows as $row) {
            $row = $this->parse_row($row);

            $result[] = array_combine($keys, $row);
        }
        $this->debug('UN SETTING UNNECESSARILY DATA','');

        foreach($result as $res=>$val){
            $result[$res]['country'] = 'US';
            unset($result[$res]['phone']);
            unset($result[$res]['state_name']);
        }

        $this->debug('INSERTING DATA','');

        $inserted_rows = $this->school_model->insert_to_table($result);

        $this->debug('INSERTED DATA',$inserted_rows);
    }

    public function import_private_school(){
        $public_school_csv_file = file_get_contents(BASEPATH . '../teacher.classcompete.com/web/content/data/private_school.csv');

        $rows   = str_getcsv($public_school_csv_file, "\n");
        $keys   = $this->parse_row(array_shift($rows));
        $result = array();

        $this->debug('READING FROM FILE','');
        foreach ($rows as $row) {
            $row = $this->parse_row($row);

            $result[] = array_combine($keys, $row);
        }
        $this->debug('UN SETTING AND SETTING ADITIONAL DATA','');

        foreach($result as $res=>$val){
            $result[$res]['is_public'] = 0;
            $result[$res]['country'] = 'US';
            unset($result[$res]['phone']);
            unset($result[$res]['state_name']);
        }

        $this->debug('INSERTING DATA','');

        $inserted_rows = $this->school_model->insert_to_table($result);

        $this->debug('INSERTED DATA',$inserted_rows);
    }

    private function parse_row($row) {
        return array_map('trim', explode(',', $row));
    }

    private function debug($text,$rows)
    {
        echo date("Y-m-d H:i:s") . ' | ' .$text.' > ' . $rows . "\n";
    }

    public function test(){
        echo 'asd';
    }

}
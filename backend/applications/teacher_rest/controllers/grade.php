<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 07/11/13
 * Time: 00:30
 */
class Grade extends REST_Controller{

    public function __construct(){
        parent:: __construct();
    }

    public function index_get(){
        $out = array();

        $out[0] = new stdClass();
        $out[0]->grade_id = -2;
        $out[0]->grade_name = 'Pre K';

        $out[1] = new stdClass();
        $out[1]->grade_id = -1;
        $out[1]->grade_name = 'K';

        $out[2] = new stdClass();
        $out[2]->grade_id = 1;
        $out[2]->grade_name = '1';

        $out[3] = new stdClass();
        $out[3]->grade_id = 2;
        $out[3]->grade_name = '2';

        $out[4] = new stdClass();
        $out[4]->grade_id = 3;
        $out[4]->grade_name = '3';

        $out[5] = new stdClass();
        $out[5]->grade_id = 4;
        $out[5]->grade_name = '4';

        $out[6] = new stdClass();
        $out[6]->grade_id = 5;
        $out[6]->grade_name = '5';

        $out[7] = new stdClass();
        $out[7]->grade_id = 6;
        $out[7]->grade_name = '6';

        $out[8] = new stdClass();
        $out[8]->grade_id = 7;
        $out[8]->grade_name = '7';

        $out[9] = new stdClass();
        $out[9]->grade_id = 8;
        $out[9]->grade_name = '8';

        $this->response($out);
    }
}
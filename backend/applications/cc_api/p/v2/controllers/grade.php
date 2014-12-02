<?php
/**
 * Created by PhpStorm.
 * User: darko
 * Date: 4/7/14
 * Time: 1:17 PM
 */
class Grade extends REST_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->library('x_grade/gradelib');

        if(ParentHelper::isParent() === false){
            $this->response(null,401);
        }
    }

    public function index_get(){
        $response = array();
        $grades = $this->grade_model->getList();
        $gradesLength = $this->grade_model->getFoundRows();

        for($i = 0; $i < $gradesLength; $i ++){
            $tmpGrade = $grades[$i];
            $response[$i]['id'] =   $tmpGrade->getId();
            $response[$i]['name'] = $tmpGrade->getName();
        }

        $this->response($response);
    }
}
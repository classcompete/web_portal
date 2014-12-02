<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 6/16/14
 * Time: 1:05 PM
 */
class Classes extends REST_Controller {


    public function __construct(){
        parent:: __construct();

        $this->load->library('x_class/classlib');

        if(ParentHelper::isParent() === false){
            $this->response(null,401);
        }
    }

    public function index_get(){
        $this->class_model->filterByExcludeFreeClasses(true);
        $classes = $this->class_model->getList();

        $respond = array();

        foreach($classes as $class) {
            $single = new stdClass();
            $single->classId = $class->getClassId();
            $single->price = $class->getPrice();
            $single->name = $class->getName();
            $single->details = array();
            $single->details['description'] = $class->getPropClassDetails()->getFirst()->getDescription();
            // try to get quantity of activations
            $parentActivations = PropParentActivationQuery::create()->filterByParentId(ParentHelper::getId())->filterByClassId($class->getClassId())->findOne();
            if (empty($parentActivations) === true) {
                $single->quantity = 0;
            } else {
                $single->quantity = $parentActivations->getQuantity();
            }

            array_push($respond, $single);
        }

        $this->response($respond, 200);
    }

}
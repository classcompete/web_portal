<?php

/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 6/16/14
 * Time: 1:05 PM
 */
class Classes_grouped extends REST_Controller
{


    public function __construct()
    {
        parent:: __construct();

        $this->load->library('x_class/classlib');

        if (ParentHelper::isParent() === false) {
            $this->response(null, 401);
        }
    }

    public function index_get()
    {
        $this->class_model->filterByExcludeFreeClasses(true);
        $classes = $this->class_model->getList();

        $groups = array(
            array(
                'group_id' => 1,
                'id_from' => 10, //include this ID
                'id_to' => 20, //exclude this ID
                'group_name' => 'Summer Math Challenge',
                'group_description' => '',
                'classes' => array(),
                'background' => '#677B9D',
            ),
            array(
                'group_id' => 2,
                'id_from' => 20, //include this ID
                'id_to' => 30, //exclude this ID
                'group_name' => 'Math Games',
                'group_description' => '',
                'classes' => array(),
                'background' => '#9E5B88',
            ),
            array(
                'group_id' => 3,
                'id_from' => 30,
                'id_to' => 40,
                'group_name' => 'English Language Arts Games',
                'group_description' => '',
                'classes' => array(),
                'background' => '#B7D064',
            ),
        );

        foreach ($groups as &$group) {
            $tmpRespond = array();

            foreach ($classes as $class) {
                $detailsId = $class->getPropClassDetails()->getFirst()->getClassDetailsId();

                if ($detailsId >= $group['id_from'] && $detailsId < $group['id_to']) {
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

                    $tmpRespond[$class->getPropClassDetails()->getFirst()->getClassDetailsId()] = $single;
                }
            }
            ksort($tmpRespond);

            foreach ($tmpRespond as $row) {
                array_push($group['classes'], $row);
            }
        }

        $this->response($groups, 200);
    }

}
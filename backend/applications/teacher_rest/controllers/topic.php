<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/11/13
 * Time: 23:04
 */
class Topic extends REST_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->library('y_topic/topiclib');
    }

    /**
     * Get topics by skill id
     */
    public function index_get(){

        $skill_id = intval($this->get('skill'));
        $topics = $this->topic_model->get_topic_by_skill_id($skill_id);
        $out = array();

        foreach($topics as $topic=>$val){
            $out[$topic] = new stdClass();
            $out[$topic]->topic_id = $val->getTopicId();
            $out[$topic]->topic_name = $val->getName();
        }

        $this->response($out);
    }

}
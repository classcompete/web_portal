<?php
class Subscriber_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_subscribers()
    {
        return PropSubscriberQuery::create()->find();
    }
}
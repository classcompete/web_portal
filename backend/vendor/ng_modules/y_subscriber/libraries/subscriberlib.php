<?php

class Subscriberlib
{
    private $ci;

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->model('y_subscriber/subscriber_model');
        $this->ci->load->helper('y_subscriber/subscriber');
    }

    public function subscriber_exists($email)
    {
        $subscriber = $this->ci->subscriber_model->get_subscriber_by_email($email);

        if (empty($subscriber) === false){
            $out = true;
        } else {
            $out = false;
        }

        return $out;
    }
}
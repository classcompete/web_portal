<?php
class Subscriber extends MY_Controller
{
    public function __construct()
    {
        $this->load->library('x_subscriber/subscriberlib');
    }

    public function csv()
    {
        $subscribers = $this->subscriber_model->get_subscribers();

        $subscribers_array = array();

        foreach ($subscribers as $k => $subscriber) {
            $subscribers_array[$k]['id'] = $subscriber->getId();
            $subscribers_array[$k]['email'] = $subscriber->getEmail();
            $subscribers_array[$k]['created_at'] = $subscriber->getCreatedAt();
            $subscribers_array[$k]['updated_at'] = $subscriber->getUpdatedAt();
        }

        $this->subscriberlib->download_send_headers("subscribers_export_" . date("Y-m-d") . ".csv");
        echo $this->subscriberlib->array2csv($subscribers_array);
        die(0);
    }
}
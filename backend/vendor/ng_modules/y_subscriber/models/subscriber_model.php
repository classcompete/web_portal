<?php
class Subscriber_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save($data, $id = null)
    {
        if (empty($id) === true) {
            $subscriber = new PropSubscriber();
        } else {
            $subscriber = PropSubscriberQuery::create()->findOneById($id);
        }

        if (isset($data->email) === true && empty($data->email) === false) {
            $subscriber->setEmail($data->email);
        }

        $subscriber->save();

        return $subscriber;
    }

    public function get_subscriber_by_email($email)
    {
        return PropSubscriberQuery::create()->findOneByEmail($email);
    }
}
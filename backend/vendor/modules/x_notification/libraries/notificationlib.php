<?php

class Notificationlib
{
    private $_ci;

    const NOTIFICATION_TYPE_WARNING = 'warning';
    const NOTIFICATION_TYPE_INFORMATION = 'information';
    const NOTIFICATION_TYPE_SUCCESS = 'success';
    const NOTIFICATION_TYPE_FAILURE = 'failure';

    public function __construct()
    {

        $this->_ci = &get_instance();
        $this->_ci->load->library('session');
    }

    public function get()
    {
        $notification = $this->_ci->session->flashdata('nnote_notification');
        if (empty($notification) === true) {
            $notification = null;
        } else {
            $notification = (object)$notification;
        }
        return $notification;
    }

    /**
     *
     * @param type $text
     * @param type $type Notification type (warning, information, success, failure)
     */
    public function set($text, $type = null)
    {
        if (empty($type) === true) {
            $type = Notificationlib::NOTIFICATION_TYPE_WARNING;
        }
        $notification = array(
            'text' => $text,
            'type' => $type,
        );
        $this->_ci->session->set_flashdata('nnote_notification', $notification);
    }

    public function setWarning($text)
    {
        $this->set($text, Notificationlib::NOTIFICATION_TYPE_WARNING);
    }

    public function setInfo($text)
    {
        $this->set($text, Notificationlib::NOTIFICATION_TYPE_INFORMATION);
    }

    public function setSuccess($text)
    {
        $this->set($text, Notificationlib::NOTIFICATION_TYPE_SUCCESS);
    }

    public function setFailure($text)
    {
        $this->set($text, Notificationlib::NOTIFICATION_TYPE_FAILURE);
    }

}
<?php

class Notification extends MX_Controller
{
    public function __construct()
    {
        $this->load->library('x_notification/notificationlib');
    }
    public function adminShow()
    {
        $notification = $this->notificationlib->get();
        if (empty($notification->text) !== true) {
            $content = $this->load->view('x_notification/' . config_item('admin_template') . '/notification', $notification, true);
        } else {
            $content = null;
        }
        echo $content;
    }
    public function show()
    {
        $this->adminShow();
    }

    public function siteShow()
    {
        $notification = $this->notificationlib->get();
        if (empty($notification->text) !== true) {
            $this->load->view('common/notification', $notification);
        }

    }
}

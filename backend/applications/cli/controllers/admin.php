<?php

class Admin extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('x_admin/adminlib');
    }

    public function add($username, $password, $email)
    {
        $this->debug('Add admin ' . $username);
        if ($this->admin_model->is_unique_username_and_email($username, $email) !== true) {
            $this->debug('Username and/or email already existists');
            exit(1);
        }
        $encodedPassword = $this->adminlib->encodePassword($password);
        $this->debug('Password encoded');

        $data = new stdClass();
        $data->username = $username;
        $data->password = $encodedPassword;
        $data->email = $email;

        $user = $this->admin_model->save($data);
        $this->debug('New admin account created');
        $this->debug('Process FINISHED!');
    }

    private function debug($text)
    {
        echo date("Y-m-d H:i:s") . ' | User > ' . $text . "\n";
    }

}

<?php

class User extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('x_user/userlib');
    }

    public function add($username, $password, $email, $role)
    {
        $this->debug('Add user ' . $username);
        if ($this->user_model->is_unique_username_and_email($username, $email) !== true) {
            $this->debug('Username and/or email already existists');
            exit(1);
        }
        $encodedPassword = $this->userlib->encodePassword($password);
        $this->debug('Password encoded');

        $userdata = new stdClass();
        $userdata->username = $username;
        $userdata->password = $encodedPassword;
        $userdata->email = $email;
        $userdata->role = $role;

        $user = $this->user_model->save($userdata);
        $this->debug('New user account created');
        $this->debug('User assigned to rule group \'' . $role . '\'');
        $this->user_model->save_user_status($user->getId(), PropUserPeer::STATUS_ENABLED);
        $this->debug('Process FINISHED!');
    }

    private function debug($text)
    {
        echo date("Y-m-d H:i:s") . ' | User > ' . $text . "\n";
    }

}

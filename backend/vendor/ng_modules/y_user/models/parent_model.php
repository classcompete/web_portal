<?php
class Parent_model extends CI_Model
{

    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterUsername = null;
    private $filterEmail = null;
    private $filterFirstName = null;
    private $filterLastName = null;
    private $excludeId = null;
    private $joinTable = null;


    public function __construct()
    {
        parent::__construct();
    }

    public function save($data, $id = null)
    {
        if (empty($id) === true) {
            $user = new PropUser();
        } else {
            $user = PropUserQuery::create()->findOneByUserId(intval($id));
            $user->setModified(date("Y-m-d H:i:s"));
        }
        if (isset($data->username) === true && empty($data->username) === false) {
            $user->setLogin($data->username);
        }
        if (isset($data->email) === true && empty($data->email) === false) {
            $user->setEmail($data->email);
        }
        if (isset($data->password) === true && empty($data->password) === false) {
            $user->setPassword($data->password);
        }
        if (isset($data->first_name) === true && empty($data->first_name) === false) {
            $user->setFirstName($data->first_name);
        }
        if (isset($data->last_name) === true && empty($data->last_name) === false) {
            $user->setLastName($data->last_name);
        }
        $user->save();

        if (empty($id) === true) {
            $parent = new PropParent();
            $parent->setPropUser($user);
            if (isset($data->avatar) === true && empty($data->avatar) === false) {
                $parent->setImageThumb($data->avatar);
            }
            $parent->save();

        } else {

            $parent = PropParentQuery::create()->findOneByUserId(intval($id));
            $parent->setPropUser($user);
            $parent->setModified(date("Y-m-d H:i:s"));

            if (isset($data->avatar) === true && empty($data->avatar) === false) {
                $parent->setImageThumb($data->avatar);
            }
            if (isset($data->auth_code) === true && empty($data->auth_code) === false) {
                $parent->setAuthCode($data->auth_code);
            }
            if(isset($data->time_diff) === true && empty($data->time_diff) === false){
                $parent->setTimeDiff($data->time_diff);
            }
            $parent->save();
        }
        return $user;
    }

    public function get_parent_image($user_id)
    {
        $img = PropParentQuery::create()->findOneByUserId($user_id);
        if ($img != null) {
            $imageBaseCode = stream_get_contents($img->getImageThumb());
        } else {
            $imageBaseCode = null;
        }
        return $imageBaseCode;
    }

    public function get_parent_info($id)
    {
        return PropParentQuery::create()->findOneByUserId($id);
    }

    public function get_parent_info_by_auth_code($auth_code)
    {
        return PropParentQuery::create()->findOneByAuthCode($auth_code);
    }

    public function get_parent_by_email_or_username($string)
    {
        $user = $this->get_parent_by_username($string);

        if (empty($user) === true) {
            $user = $this->get_parent_by_email($string);
        }

        /**
         * Check if user is parent
         * */
        if (empty($user) === false) {
            $parent = PropParentQuery::create()->findOneByUserId($user->getUserId());

            if (empty($parent) === false) {
                return $user;
            } else {
                $user = null;
                return $user;
            }
        } else {
            return null;
        }
    }

    public function get_parent_by_username($username)
    {
        return PropUserQuery::create()->findOneByLogin($username);
    }

    public function get_parent_by_email($email)
    {
        $user = PropUserQuery::create()->findOneByEmail($email);
        if (empty($user) === false) {
            $parent = PropParentQuery::create()->findOneByUserId($user->getId());
            if (empty($parent) === false) {
                return $user;
            } else {
                return null;
            }
        } else {
            return null;
        }

    }

    public function get_user_by_id($id)
    {
        return PropUserQuery::create()->findOneByUserId($id);
    }

    public function get_parent_id_by_user_id($user_id)
    {
        return PropParentQuery::create()->findOneByUserId($user_id);
    }
    public function check_data_for_registration($data){
        $out = new stdClass();

        $username = PropUserQuery::create()->filterByLogin($data['username'], Criteria::EQUAL)->findOne();
        if(isset($username) === false && empty($username) === true){
            $out->username = true;
        }else{
            $out->username = false;
        }

        $email = PropUserQuery::create()->filterByEmail($data['email'], Criteria::EQUAL)->findOne();
        if(isset($email) === false && empty($email) === true){
            $out->email = true;
        }else{
            $out->email = false;
        }

        return $out;
    }
}
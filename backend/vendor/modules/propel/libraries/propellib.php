<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 7/30/12
 * Time: 7:31 PM
 * To change this template use File | Settings | File Templates.
 */

class Propellib
{
    public $prefix = 'Prop';
    public $table = null;
    public $object = null;
    public $peer = null;
    public $query = null;

    public function __construct()
    {

    }

    public function load_object($object)
    {
        $name = $this->prefix . $object;
        if (class_exists($name)) {
            $this->object = $name;
            $this->peer = $name . 'Peer';
            $this->query = $name . 'Query';
        } else {
            show_error('Unknown Propel object ' . $name);
        }
    }

    public function get_query_name()
    {
        return $this->query;
    }

    public function get_peer_name()
    {
        return $this->peer;
    }

    public function get_object_name()
    {
        return $this->object;
    }

    /**
     * Gets current object database name
     *
     * @return varchar database name
     */
    public function get_database_name()
    {
        return call_user_func(array($this->peer, 'DATABASE_NAME'));
    }

    /**
     * Change global propel prefix been used on all classes to avoid name collisions.
     *
     * @param $prefix varchar new prefix to set
     */
    public function set_prefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Verify that everything is functional
     */
    private function verify_object()
    {

    }

    public function get_col_method($name)
    {
        $name = strtolower($name);
        $name = str_replace('_', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);
        $name = 'get' . $name;
        return $name;
    }
}
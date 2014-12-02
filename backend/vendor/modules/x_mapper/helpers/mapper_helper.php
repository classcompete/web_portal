<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 7/31/12
 * Time: 11:34 PM
 * To change this template use File | Settings | File Templates.
 */
class Mapper_Helper
{
    public static $_ci;

    public static function init()
    {
        self::$_ci = &get_instance();
    }

    public static function create_uri_segments()
    {
        $uri_data = array();
        if (empty($_POST) === false) {
            $cols = self::$_ci->mapperlib->get_cols();
            foreach ($cols as $col => $params)
            {
                if (isset($params->searchable) === true && $params->searchable === true) {
                    $uri_data[$col] = self::$_ci->input->post($col, true);
                    if (empty($uri_data[$col]) === true) {
                        $uri_data[$col] = 'null';
                    }
                }
            }
            $order = self::$_ci->input->post('order');
            if (empty($order) === true) {
                $uri_data['order'] = 'null';
            } else {
                $uri_data['order'] = $order;
            }
        }
        $uri = self::$_ci->uri->assoc_to_uri($uri_data);
        if (empty($uri) === true) {
            $uri = null;
        }
        return $uri;
    }

}

Mapper_Helper::init();
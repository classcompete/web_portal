<?php

class AssetHelper
{

    static $_ci;

    public static function init()
    {
        self::$_ci = &get_instance();
        self::$_ci->load->library('x_asset/assetlib');
    }

    public static function cssUrl($uri = '')
    {
        return self::$_ci->assetlib->get_asset_css_url($uri);
    }

    public static function jqueryUrl($uri = '')
    {
        return self::$_ci->assetlib->get_asset_jquery_url($uri);
    }

    public static function jsUrl($uri = '')
    {
        return self::$_ci->assetlib->get_asset_js_url($uri);
    }

    public static function angularJsUrl($uri=''){
        return self::$_ci->assetlib->get_asset_angular_js_url($uri);
    }

    public static function imageUrl($uri = '')
    {
        return self::$_ci->assetlib->get_asset_image_url($uri);
    }

    public static function heroImageUrl($uri = '')
    {
        self::$_ci->config->load('x_company/config');
        $hero_uri = self::$_ci->config->item('hero_base_uri');
        return site_url($hero_uri . $uri);
    }

    public static function commonUrl($uri = '')
    {
        return self::$_ci->assetlib->get_asset_icommon_url($uri);
    }

}

AssetHelper::init();
<?php

class Assetlib
{

    private $_ci;
    protected $asset_url;

    public function __construct()
    {
        $this->_ci = &get_instance();
        $this->_ci->load->helper('x_asset/asset');
        $this->asset_url = $this->_ci->config->item('asset_url');
    }

    public function get_asset_css_url($uri = '')
    {
        return $this->asset_url('css/' . $uri);
    }

    public function get_asset_jquery_url($uri = '')
    {
        return $this->asset_url('jquery/' . $uri);
    }

    public function get_asset_js_url($uri = '')
    {
        return $this->asset_url('js/' . $uri);
    }

    public function get_asset_angular_js_url($uri=''){
        return $this->asset_url('angular/' . $uri);
    }

    public function get_asset_image_url($uri = '')
    {
        return $this->asset_url('images/' . $uri);
    }

    public function get_asset_icommon_url($uri = '')
    {
        return $this->asset_url('icomoon/' . $uri);
    }

    public function asset_url($uri = '')
    {
        if ($uri == '') {
            return $this->_ci->config->slash_item('asset_url');
        }

        if ($this->_ci->config->item('enable_query_strings') == FALSE) {
            $suffix = ($this->_ci->config->item('url_suffix') == FALSE) ? '' : $this->_ci->config->item('url_suffix');
            return $this->_ci->config->slash_item('asset_url') . $this->_ci->config->slash_item('index_page') . $this->_uri_string($uri) . $suffix;
        } else {
            return $this->_ci->config->slash_item('asset_url') . '?' . $this->_uri_string($uri);
        }
    }

    /**
     * Build URI string for use in Config::site_url() and Config::base_url()
     *
     * @access protected
     * @param  $uri
     * @return string
     */
    protected function _uri_string($uri)
    {
        if ($this->_ci->config->item('enable_query_strings') == FALSE) {
            if (is_array($uri)) {
                $uri = implode('/', $uri);
            }
            $uri = trim($uri, '/');
        } else {
            if (is_array($uri)) {
                $i = 0;
                $str = '';
                foreach ($uri as $key => $val) {
                    $prefix = ($i == 0) ? '' : '&';
                    $str .= $prefix . $key . '=' . $val;
                    $i++;
                }
                $uri = $str;
            }
        }
        return $uri;
    }

}
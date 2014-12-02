<?php

class Mapperlib
{
    private $ci;

    protected $header_data = array();
    protected $option_data = array();
    protected $data;
    protected $paging_data;
    protected $order_data = array();
    protected $order_use_peer = array();
    protected $propel_object;
    protected $breaking_segment = 3;
    protected $default_order = 'created_at';
    protected $default_order_dir = 'DESC';
    protected $model;

    public function __construct()
    {
        $this->ci = &get_instance();

        $this->ci->load->library('propel/propellib');
        $this->ci->load->helper('x_mapper/mapper');

        $this->paging_data = new stdClass();
    }

    public function generate_header()
    {
        $data = new stdClass();

        $html_header = null;
        if (isset($this->header_data) === true && empty($this->header_data) === false) {
            $data->headers = $this->header_data;
            $data->order = $this->order_data;
            $html_header = $this->ci->load->view('x_mapper/table_header', $data, true);
        }

        if (empty($html_header) === true) {
            show_error('Headers are empty');
        }

        return $html_header;
    }

    public function generate_footer()
    {

        $data = new stdClass();

        $html_footer = null;
        if (isset($this->header_data) === true && empty($this->header_data) === false) {
            $data->headers = $this->header_data;
            $data->paging = $this->paging_data;
            $data->paging->first = 1;
            $data->paging->last = $this->paging_data->total_pages;
            $data->paging->previous = ($this->paging_data->default_page - 1 < 1) ? 1 : $this->paging_data->default_page - 1;
            $data->paging->next = ($this->paging_data->default_page + 1 > $data->paging->last) ? $data->paging->last : $this->paging_data->default_page + 1;
            $data->paging->current = $this->paging_data->default_page;
            $data->paging->base = $this->paging_data->default_page_base;
            $data->order = $this->order_data;
            $html_footer = $this->ci->load->view('x_mapper/table_footer', $data, true);
        }

        if (empty($html_footer) === true) {
            show_error('Footer is empty');
        }

        return $html_footer;
    }

    public function generate_body()
    {
        $data = new stdClass();

        $this->model->set_order_by($this->default_order);
        $this->model->set_order_by_direction($this->default_order_dir);
        $this->model->set_limit($this->paging_data->limit);
        $this->model->set_offset($this->paging_data->offset);

        $records = $this->model->getList();

        $this->paging_data->total_items = $this->model->getFoundRows();
        $this->paging_data->total_pages = ceil($this->paging_data->total_items/$this->paging_data->default_per_page);

        $formated_data = array();
        foreach ($records as $record) {
            $tmp_data = new stdClass();
            foreach ($this->header_data as $name => $col) {
                if (is_null($col->prop_object) === true) {
                    $pcm = $this->ci->propellib->get_col_method($name);
                    $tmp_data->$name = call_user_func(array($record, $pcm));
                } else {
                    $submethod = 'get' . $col->prop_object;
                    $pcm = $this->ci->propellib->get_col_method($name);
                    $subobject = call_user_func(array($record, $submethod));
                    $tmp_data->$name = call_user_func(array($subobject, $pcm));
                }
            }

            $tmp_data->options = array();

            foreach ($this->option_data as $name => $option) {
                $tmp_option = new stdClass();

                $uri_segments_array = array();
                foreach ($option['params'] as $param) {
                    $pcm = $this->ci->propellib->get_col_method($param);
                    $uri_segments_array[] = call_user_func(array($record, $pcm));
                }
                $uri_segments = implode('/', $uri_segments_array);

                if (isset($option['title']['field'])) {
                    $pcm = $this->ci->propellib->get_col_method($option['title']['field']);
                    $title = sprintf("%s %s", $option['title']['base'], call_user_func(array($record, $pcm)));
                } else {
                    $title = $option['title']['base'];
                }

                $string = $option['title']['base'];
                $link = site_url(sprintf("%s/%s", $option['uri'], $uri_segments));
                $data_target = @$option['data-target'];
                $data_toggle = @$option['data-toggle'];
                //$onclick = @$option['onclick'];

                $tmp_option->name = $name;
                $tmp_option->title = $title;
                $tmp_option->string = $string;
                $tmp_option->link = $link;
                $tmp_option->data_target = $data_target;
                $tmp_option->data_toggle = $data_toggle;
                //$tmp_option->onclick = $onclick;

                $tmp_data->options[$name] = $tmp_option;
            }


            $formated_data[] = $tmp_data;
        }

        $data->records = $formated_data;
        $data->cols = $this->header_data;

        return $this->ci->load->view('x_mapper/table_content', $data, true);
    }

    public function generate_table($read_uri = false)
    {
        if ($read_uri === true) {
            // run default checks and filters
            $this->set_offset_from_uri();
            $this->set_page_from_uri();
            $this->set_order_from_uri();
            $this->set_filters_from_uri();
        }
        $html = $this->generate_header();
        $html .= $this->generate_body();
        $html .= $this->generate_footer();

        $data = new stdClass();
        $data->html = $html;

        return $this->ci->load->view('x_mapper/table_body', $data, true);
    }

    public function add_column($name, $title, $searchable = false, $search_type = 'text', $options = null, $object = null)
    {
        $col = new stdClass();
        $col->title = $title;
        $col->searchable = $searchable;
        $col->search_type = $search_type;
        $col->options = $options;
        $col->prop_object = $object;

        $this->header_data[$name] = $col;

    }

    public function remove_column($name)
    {
        unset($this->header_data[$name]);
    }

    public function get_cols()
    {
        return $this->header_data;
    }

    public function add_order_by($col, $title, $peer_lib = null)
    {
        $this->order_data[$col] = $title;
        $this->order_use_peer[$col] = $peer_lib;
    }

    public function add_option($name, $option)
    {
        $this->option_data[$name] = $option;
    }

    public function set_model(&$model)
    {
        $this->model = $model;
    }

    public function set_default_page($val)
    {
        $this->paging_data->default_page = $val;
    }

    public function set_default_per_page($val)
    {
        $this->paging_data->default_per_page = $val;
    }

    public function set_total_records($val)
    {
        $this->paging_data->total_records = $val;
    }

    public function set_breaking_segment($val)
    {
        $this->breaking_segment = $val;
    }

    public function set_default_order($col, $order)
    {
        $this->default_order = $col;
        $this->default_order_dir = $order;
    }

    public function set_header_data($data)
    {
        $this->header_data = $data;
    }

    public function set_data($data)
    {
        $this->data = $data;
    }

    public function set_paging_data($data)
    {
        $this->paging_data = $data;
    }

    public function set_default_base_page($string)
    {
        $this->paging_data->default_page_base  = $string;
    }

    public function set_page_from_uri()
    {
        $params = $this->ci->uri->uri_to_assoc($this->breaking_segment);
        if (isset($params['page'])) {
            $this->paging_data->default_page = (int)$params['page'];
        }
        $this->paging_data->offset = ((int)$this->paging_data->default_page - 1) * $this->paging_data->default_per_page;
        $this->paging_data->limit = $this->paging_data->default_per_page;
    }

    public function set_offset_from_uri()
    {
        $params = $this->ci->uri->uri_to_assoc($this->breaking_segment);
        if (isset($params['per_page']) && is_numeric($params['per_page']) === false) {
            $this->paging_data->default_per_page = $params['per_page'];
            $this->paging_data->offset = ((int)$this->paging_data->default_page - 1) * $this->paging_data->default_per_page;
            $this->paging_data->limit = $this->paging_data->default_per_page;
        }
    }

    public function set_order_from_uri()
    {
        $params = $this->ci->uri->uri_to_assoc($this->breaking_segment);
        if (isset($params['order'])) {
            $order_segment = $params['order'];
            $_POST['order'] = $params['order'];
            $order = explode('+', $order_segment);
            if (count($order) === 2) {
                $order_col = trim($order[0]);
                //$order_col = str_replace('_', ' ', $order[0]);
                $order_col = ucwords($order_col);
                $order_col = str_replace(' ', '', $order_col);
                $order_col = strtoupper($order_col);
                if (empty($this->order_use_peer[$order[0]]) === false) {
                    $peer = new ReflectionClass($this->order_use_peer[$order[0]]);
                } else {
                    $peer = new ReflectionClass($this->ci->propellib->get_peer_name());
                }

                $this->default_order = $peer->getConstant($order_col);
                $crit = new ReflectionClass('Criteria');
                $this->default_order_dir = $crit->getConstant(strtoupper($order[1]));
            }
        }
    }

    public function set_filters_from_uri()
    {
        $params = $this->ci->uri->uri_to_assoc($this->breaking_segment);
        unset($params['page'], $params['per_page'], $params['order']);
        foreach ($params as $col_name => $value) {
            if ($value !== 'null') {
                $_POST[$col_name] = $value;
                $col_name = str_replace(' ','',ucwords(strtolower(str_replace('_', '', $col_name))));
                $filter_method = 'filterBy' . $col_name;
                if (method_exists($this->model, $filter_method) === true) {
                    $value = urldecode($value);
                    $this->model->$filter_method($value);
                }
            }
        }

    }

    public function get_total_records()
    {
        return $this->paging_data->total_items;
    }
}
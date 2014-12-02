<?php

class Games extends MY_Controller
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->library('x_games/gameslib');
        $this->load->library('propellib');
        $this->load->library('form_validation');


        $this->propellib->load_object('Games');
        $this->mapperlib->set_model($this->games_model);

        $this->mapperlib->add_column('name', 'Name', true);

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'name'
            ),
            'uri' => '#games/edit',
            'params' => array(
                'game_id'
            ),
            'data-target' => '#addEditGame',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_order_by('name', 'Name');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('games/index');

        $this->mapperlib->set_default_order(PropGamesPeer::NAME, Criteria::ASC);
    }

    public function index()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('games/index/' . $uri);
        }
        $data = new stdClass();

        $data->table = $this->mapperlib->generate_table(true);

        $data->count_games = $this->games_model->getFoundRows();


        $data->content = $this->prepareView('x_games', 'home', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function add_new()
    {
        $this->games_form(null, true);
    }

    public function edit($id)
    {
        $games = $this->games_model->get_game_by_id($id);
        $this->games_form($games);
    }

    public function ajax($id)
    {
        $game = $this->games_model->get_game_by_id($id);

        if (empty($game) === false) {
            $output = new stdClass();
            $output->id = $game->getGameId();
            $output->name = $game->getName();

            $this->output->set_output(json_encode($output));
        }
    }

    public function games_form(PropGames $games = null, $add_new = false)
    {

        $data = new stdClass();

        if (is_object($games)) {
            $_POST = array(
                'name' => $games->getName()
            );
            $flashdata = $this->session->flashdata('admin-' . $games->getGameId());
            if (empty($flashdata) === false) {
                $_POST = array_merge($_POST, $flashdata);
            }
        } else {
            $_POST = $this->session->flashdata('admin-');
        }

        $data->games = $games;
        $data->add_new = $add_new;
        $data->content = $this->prepareView('x_games', 'form', $data);
        $this->load->view('form', $data);
    }

    public function save(){

        $game_id = $this->input->post('id');

        if ($this->form_validation->run('games') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $game_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }

        $game_data = new stdClass();

        $game_data->name = $this->input->post('name');

        $game = $this->games_model->save($game_data, $game_id);
        redirect('games');
    }

    /*
    * validation function for save function
    * */

    public function ajax_validation(){

        $error = array();

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('games') === false){
            if(form_error('name') != '')
                $error['name'] = form_error('name');

            $this->output->set_status_header('400');
        }else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));

    }
}
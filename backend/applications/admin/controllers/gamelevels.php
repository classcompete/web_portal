<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/4/13
 * Time: 6:06 PM
 * To change this template use File | Settings | File Templates.
 */
class Gamelevels extends MY_Controller
{

    public function __construct()
    {
        parent:: __construct();

        $this->load->library('x_games/game_levelslib');
        $this->load->library('x_games/gameslib');
        $this->load->library('propellib');
        $this->load->library('form_validation');

        $this->propellib->load_object("GameLevels");
        $this->mapperlib->set_model($this->game_levels_model);

        $this->mapperlib->add_column('name', "Name", true);

        $this->mapperlib->add_option('edit', array(
            'title' => array(
                'base' => 'Edit',
                'field' => 'name'
            ),
            'uri' => '#gamelevels/edit',
            'params' => array(
                'gamelevel_id'
            ),
            'data-target' => '#addEditGamelevel',
            'data-toggle' => 'modal'
        ));

        $this->mapperlib->add_order_by('name', 'Name');

        $this->mapperlib->set_default_per_page(20);
        $this->mapperlib->set_default_page(1);
        $this->mapperlib->set_default_base_page('gamelevels/index');

        $this->mapperlib->set_default_order(PropGameLevelsPeer::NAME, Criteria::ASC);
    }

    public function index()
    {
        $uri = Mapper_Helper::create_uri_segments();
        if ($uri !== null) {
            redirect('gamelevels/index/' . $uri);
        }
        $data = new stdClass();

        $data->table = $this->mapperlib->generate_table(true);


        $data->content = $this->prepareView('x_games', 'home_levels', $data);
        $this->load->view(config_item('admin_template'), $data);
    }

    public function add_new()
    {
        $this->gamelevel_form(null, true);
    }

    public function edit($id)
    {
        $game_levels = $this->game_levels_model->get_game_levels_by_id($id);
        $this->gamelevel_form($game_levels);
    }

    public function ajax($id)
    {
        $game_level = $this->game_levels_model->get_game_levels_by_id($id);

        if (empty($game_level) === false) {
            $output = new stdClass();
            $output->id = $game_level->getGamelevelId();
            $output->game_id = $game_level->getGameId();
            $output->name = $game_level->getName();

            $this->output->set_output(json_encode($output));
        }
    }

    public function ajax_games()
    {
        $games = $this->games_model->getList();
        $games_array = array();
        foreach ($games as $k => $game) {
            $games_array[$k]['game_id'] = $game->getGameId();
            $games_array[$k]['name'] = $game->getName();
        }

        $this->output->set_output(json_encode($games_array));
    }

    public function save(){

        $game_level_id = $this->input->post('id');

        if ($this->form_validation->run('gamelevels') === false) {
            $this->notificationlib->set($this->form_validation->error_string('<span>', '<span>'), Notificationlib::NOTIFICATION_TYPE_FAILURE);
            $this->session->set_flashdata('admin-' . $game_level_id, $_POST);
            redirect($_SERVER['HTTP_REFERER']);
        }


        $game_level_data = new stdClass();

        $game_level_data->name = $this->input->post('name');
        $game_level_data->game_id = intval($this->input->post('game_id'));

        $game = $this->game_levels_model->save($game_level_data, $game_level_id);
        redirect('gamelevels');
    }

    /*
    * validation function for save function
    * */

    public function ajax_validation(){

        $error = array();

        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run('gamelevels') === false){
            if(form_error('name') != '')
                $error['name'] = form_error('name');
            if(form_error('game_id') != '')
                $error['game_id'] = form_error('game_id');

            $this->output->set_status_header('400');
        }else {
            $error['validation'] = true;
            $this->output->set_status_header('200');
        }

        $this->output->set_output(json_encode($error));

    }

    public function gamelevel_form(PropGameLevels $game_levels = null, $add_new = false)
    {

        $data = new stdClass();

        if (is_object($game_levels)) {
            $_POST = array(
                'name' => $game_levels->getName()
            );
            $flashdata = $this->session->flashdata('admin-' . $game_levels->getGameLevelId());
            if (empty($flashdata) === false) {
                $_POST = array_merge($_POST, $flashdata);
            }
        } else {
            $_POST = $this->session->flashdata('admin-');
        }

        // get games
        $games = $this->games_model->getList();
        $games_array = array();
        foreach ($games as $k => $game) {
            $games_array[$k]['game_id'] = $game->getGameId();
            $games_array[$k]['name'] = $game->getName();
        }
        $data->games = $games_array;
        $data->game_levels = $game_levels;
        $data->add_new = $add_new;

        $data->content = $this->prepareView('x_games', 'form_levels', $data);
        $this->load->view('form_levels', $data);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/11/13
 * Time: 23:19
 */
class Game extends REST_Controller{

    public function __construct(){
        parent:: __construct();

        $this->load->library('y_game/gamelib');
    }

    public function index_get(){
        $games = $this->game_model->getList();

        $out = array();

        foreach($games as $game=>$val){
            $out[$game] = new stdClass();
            $out[$game]->game_id = $val->getGameId();
            $out[$game]->game_name = $val->getName();
            $out[$game]->game_code = $val->getGameCode();
        }

        $this->response($out);
    }

}
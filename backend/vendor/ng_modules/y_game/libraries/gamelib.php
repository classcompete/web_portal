<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/11/13
 * Time: 21:38
 */
class Gamelib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('y_game/game_model');
        $this->ci->load->helper('y_game/game');
    }

    public function get_game_id_by_code($code){
        $game = $this->ci->game_model->get_game_by_code($code);
        return $game->getGameId();
    }
}
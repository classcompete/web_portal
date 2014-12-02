<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/4/13
 * Time: 6:18 PM
 * To change this template use File | Settings | File Templates.
 */
class Game_levelslib{
    private $ci;

    public function __construct(){
        $this->ci = &get_instance();
        $this->ci->load->model('x_games/game_levels_model');
        $this->ci->load->helper('x_games/game_levels');
    }
}
class Geme_levels_Exception extends Exception
{

    public function __construct($message, $code = null, $previous = null)
    {
        if ($code === null && $previous === null) {
            parent::__construct($message);
        } elseif ($previous === null && empty($code) === false) {
            parent::__construct($message, $code);
        } else {
            parent::__construct($message, $code, $previous);
        }

    }

}
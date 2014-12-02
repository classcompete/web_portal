<?php
/**
 * Created by PhpStorm.
 * User: Darko Lazic
 * Date: 06/11/13
 * Time: 21:38
 */
class Game_model extends CI_Model{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterName = null;

    public function __construct(){parent::__construct();}


    public function resetFilters(){
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterName = null;


        $this->total_rows = null;
    }
    public function getFoundRows(){
        return (int)$this->total_rows;
    }

    private function prepareListQuery(){
        $query = PropGamesQuery::create();
        if (empty($this->filterName) === false) {
            $query->filterByName('%' . $this->filterName . '%', Criteria::LIKE);
        }

        return $query;
    }

    public function getList(){
        $this->total_rows = $this->prepareListQuery()->count();

        $query = $this->prepareListQuery();
        if (empty($this->orderBy) === false) {
            $query->orderBy($this->orderBy, $this->orderByDirection);
        }
        $query->limit($this->limit);
        $query->offset($this->offset);

        return $query->find();
    }
    public function set_order_by($field)
    {
        $this->orderBy = $field;
    }

    public function set_order_by_direction($direction)
    {
        $this->orderByDirection = $direction;
    }

    public function set_limit($limit)
    {
        $this->limit = $limit;
    }

    public function set_offset($offset)
    {
        $this->offset = $offset;
    }

    public function filterByName($string)
    {
        $this->filterName = $string;
    }

    public function get_game_by_id($id){
        return PropGamesQuery::create()->findOneByGameId($id);
    }

    public function get_game_name_by_game_id($id){
        $g = PropGamesQuery::create()->findOneByGameId($id);

        return $g->getName();
    }

    public function get_game_by_code($code){
        return PropGamesQuery::create()->findOneByGameCode($code);
    }

    public function get_game_code($game_id){
        $game = PropGamesQuery::create()->findOneByGameId($game_id);

        return $game->getGameCode();
    }
}
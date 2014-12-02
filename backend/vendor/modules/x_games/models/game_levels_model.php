<?php
/**
 * Created by JetBrains PhpStorm.
 * User: FenjeR
 * Date: 7/4/13
 * Time: 6:19 PM
 * To change this template use File | Settings | File Templates.
 */
class Game_levels_model extends CI_Model{
    private $orderBy = null;
    private $orderByDirection = null;
    private $limit = null;
    private $offset = null;

    private $filterName = null;

    public function __construct()
    {
        parent::__construct();
    }
    public function save($game_level_data, $game_level_id){
        if(empty($game_level_id) === true){
            $game_level = new PropGameLevels();
        }else{
            $game_level = PropGameLevelsQuery::create()->findOneByGamelevelId($game_level_id);
        }
        if(isset($game_level_data->name) === true && empty($game_level_data->name) === false){
            $game_level->setName($game_level_data->name);
        }
        if(isset($game_level_data->game_id) === true && empty($game_level_data->game_id) === false){
            $game_level->setGameId($game_level_data->game_id);
        }
        $game_level->save();
        return $game_level;
    }
    public function resetFilters()
    {
        $this->orderBy = null;
        $this->orderByDirection = null;
        $this->limit = 10;
        $this->offset = 0;

        $this->filterName = null;


        $this->total_rows = null;
    }
    public function getFoundRows()
    {
        return (int)$this->total_rows;
    }

    private function prepareListQuery()
    {
        $query = PropGameLevelsQuery::create();
        if (empty($this->filterName) === false) {
            $query->filterByName('%' . $this->filterName . '%', Criteria::LIKE);
        }

        return $query;
    }

    public function getList()
    {
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

    public function get_game_levels_by_id($id){
        return PropGameLevelsQuery::create()->findOneByGamelevelId($id);
    }
}
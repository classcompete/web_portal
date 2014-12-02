<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 8/5/14
 * Time: 4:40 PM
 */

class Country extends REST_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('x_country/countrylib');
    }

    public function index_get(){


        $this->country_model->filterByStatus(PropCountryPeer::STATUS_ACTIVE);
        $this->country_model->setOrderBy(PropCountryPeer::NAME);
        $this->country_model->setOrderByDirection('ASC');
        $countries = $this->country_model->getList();

        $response = array();

        foreach($countries as $key=>$val){
            $response[$key]['name'] = $val->getName();
            $response[$key]['iso2code'] = $val->getIso2Code();
        }

        $this->response($response, 200);

    }

}
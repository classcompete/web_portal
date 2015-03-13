<?php

/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 8/5/14
 * Time: 4:40 PM
 */
class Country extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('x_country/countrylib');
    }

    public function index_get()
    {

        $countries = PropCountryQuery::create()
            ->filterByIso2code(array('US', 'CA', 'IN'), Criteria::NOT_IN)
            ->filterByStatus(PropCountryPeer::STATUS_ACTIVE)
            ->orderByName()
            ->find();

        /*$this->country_model->filterByStatus(PropCountryPeer::STATUS_ACTIVE);
        $this->country_model->setOrderBy(PropCountryPeer::NAME);
        $this->country_model->setOrderByDirection('ASC');
        $countries = $this->country_model->getList();*/

        $response = array(
            array(
                'name' => 'United States',
                'iso2code' => 'US',
            ),
            array(
                'name' => 'Canada',
                'iso2code' => 'CA',
            ),
            array(
                'name' => 'India',
                'iso2code' => 'IN',
            )
        );

        foreach ($countries as $val) {
            $item = array(
                'name' => $val->getName(),
                'iso2code' => $val->getIso2Code(),
            );
            array_push($response, $item);
        }

        $this->response($response, 200);

    }

}
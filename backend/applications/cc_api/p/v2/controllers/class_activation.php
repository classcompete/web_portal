<?php

class Class_activation extends REST_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function wp_post()
    {
        $parentId = $this->post('parent_id');
        $classes = $this->post('classes');

        $responseData = array();

        foreach ($classes as $c) {
            // get class by code
            $class = PropClasQuery::create()->findOneByAuthCode($c['code']);
            //is there class for this code?
            if (empty($class) === false) {
            	//try to find existing activation for this class and parent
            	$activation = PropParentActivationQuery::create()->filterByParentId($parentId)->filterByClassId($class->getClassId())->findOne();
            	if (empty($activation) === false) {
                    $initialQuantity = $activation->getQuantity();
            		//we have previous activation record - just increase it
            		$activation->setQuantity($activation->getQuantity() + intval($c['quantity']));
            		$activation->save();
            	} else {
                    $initialQuantity = 0;
            		//create new activation record
            		$activation = new PropParentActivation();
            		$activation->setClassId($class->getClassId());
            		$activation->setParentId($parentId);
            		$activation->setQuantity($c['quantity']);
            		$activation->save();
            	}

                $responseData[] = array(
                    'c' => $class->getName(),
                    'p' => $activation->getParentId(),
                    'oq' => $initialQuantity,
                    'nq' => $activation->getQuantity(),
                );
            }
            
        }

        // get parent by id
        $parent = PropParentQuery::create()->findOneByParentId($parentId);
        $parentUser = $parent->getPropUser();

        $emailData = new stdClass();
        $emailData->email = $parentUser->getEmail();

        $this->load->library('mailer/mailerlib');
        $this->mailerlib->sendParentOrderCompletedExistingAccount($emailData);

        $this->response($responseData, 200);
    }
}
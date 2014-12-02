<?php
/**
 * Created by PhpStorm.
 * User: Darko
 * Date: 6/18/14
 * Time: 6:33 PM
 */

require_once APPPATH . '/third_party/Stripe.php';

class Checkout extends REST_Controller {

    public function __construct(){
        parent::__construct();

        if(!ParentHelper::getId()){
            $this->response(null, 401);
        }
    }


    public function index_post(){
        $respond = new stdClass();

        $tokenObject = $this->post('token');
        $cartObject = $this->post('cart');
        $argsObject = $this->post('args');

        $tokenId = $tokenObject['id'];
        $liveMode = (bool)$tokenObject['livemode'];

        $this->load->config('stripe', true, true);
        $stripeConfig = $this->config->item('stripe');

        if ($liveMode === true) {
            Stripe::setApiKey($stripeConfig['live_secret']);
        } else {
            Stripe::setApiKey($stripeConfig['test_secret']);
        }

        try {
            $token = Stripe_Token::retrieve($tokenId);
        } catch (Stripe_InvalidRequestError $error) {
            $token  = new stdClass();
        }


        if (isset($token->id) === true) {
            // seems we have valid response - lets to our stuff here
            $payLog = $this->createOrderAndPayLog($argsObject, $cartObject, $tokenId, $liveMode);
            $order = PropParentOrderQuery::create()->findOneById($payLog->getOrderId());
            // now we have paylog and we need to create actual payment request
            try {
                $charge = Stripe_Charge::create(array(
                    "amount" => $order->getAmount(),
                    "currency" => "usd",
                    "card" => $payLog->getTokenId(), // obtained with Stripe.js
                    "description" => "Charge for " . $token->email,
                ));
            } catch (Stripe_CardError $e) {
                $charge = new stdClass();
                $charge->paid = false;
            }

            if ((bool)$charge->paid === true) {
                // set object and paylog as paid
                $payLog->setStatus(PropParentPayLogPeer::STATUS_SUCCESS);
                $payLog->setRawResponse(var_export($charge, true));
                $payLog->save();
                $order->setStatus(PropParentOrderPeer::STATUS_SUCCESS);
                $order->setPaymentId($charge->id);
                $order->save();
                // here we also need to assign students from order bucket to classroom
                $buckets = PropParentBucketQuery::create()->findByOrderId($order->getId());
                foreach ($buckets as $bucket) {
                    $studentInClass = new PropClass_student();
                    $studentInClass->setClassId($bucket->getClassId());
                    $studentInClass->setStudentId($bucket->getStudentId());
                    $studentInClass->save();
                }
                $this->response('Thank you for your order', 200);
            } else {
                $payLog->setStatus(PropParentPayLogPeer::STATUS_ERROR);
                $payLog->save();
                $order->setStatus(PropParentOrderPeer::STATUS_ERROR);
                $order->save();
                $this->response('Payment failed - please try again', 401);
            }
        } else {
            $this->response('Invalid token value - please try again', 400);
        }
    }

    protected function createOrderAndPayLog($argsObject, $cartObject, $tokenId, $liveMode)
    {
        // calculate total order amount
        $totalAmount = 0;
        foreach ($cartObject as $item) {
            $totalAmount += ($item['quantity'] * $item['price']);
        }

        //first we need to create order object
        $parentId = ParentHelper::getId();

        $order = new PropParentOrder();
        $order->setParentId($parentId);
        if ($liveMode === true) {
            $order->setLive(PropParentOrderPeer::LIVE_TRUE);
        } else {
            $order->setLive(PropParentOrderPeer::LIVE_FALSE);
        }
        $order->setAmount($totalAmount * 100);
        $order->setStatus(PropParentOrderPeer::STATUS_PENDING);
        $order->save();

        $orderId = $order->getId();

        // create buckets
        foreach ($cartObject as $item) {
            foreach ($item['student'] as $studentId){
                $bucket = new PropParentBucket();
                $bucket->setParentId(ParentHelper::getId());
                $bucket->setOrderId($orderId);
                $bucket->setClassId($item['classId']);
                $bucket->setStudentId($studentId);
                $bucket->setPrice($item['price']);
                $bucket->save();
            }
        }

        // and create pay log record
        $payLog = new PropParentPayLog();
        $payLog->setOrderId($orderId);
        $payLog->setParentId($parentId);
        $payLog->setStatus(PropParentPayLogPeer::STATUS_UNDEFINED);
        $payLog->setTokenId($tokenId);
        $payLog->save();

        return $payLog;
    }
}
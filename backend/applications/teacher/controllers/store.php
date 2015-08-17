<?php

require_once APPPATH . '/third_party/Stripe.php';

class Store extends MY_Controller
{
    public function index()
    {
        $data = new stdClass();

        $classes = PropClasQuery::create()->filterByTeacherId(TeacherHelper::getId())->orderByLimit(Criteria::DESC)->find();
        $data->classes = $classes;

        $data->content = $this->load->view('store/home', $data, true);
        $this->load->view('compete', $data);
    }

    public function process_token()
    {
        $tokenString = $this->input->post('stripeToken');
        $licenseCount = $this->input->post('license_count');
        $this->load->config('stripe', true, true);
        $stripeConfig = $this->config->item('stripe');
        $liveMode = $stripeConfig['live_mode'];

        if ($liveMode === true) {
            Stripe::setApiKey($stripeConfig['live_secret']);
        } else {
            Stripe::setApiKey($stripeConfig['test_secret']);
        }


        $token = Stripe_Token::retrieve($tokenString);

        if (isset($token->id) === true) {
            // seems we have valid response - lets to our stuff here
            $payLog = $this->createOrderAndPayLog($licenseCount, $tokenString, $liveMode);
            $order = PropTeacherOrderQuery::create()->findOneById($payLog->getOrderId());
            // now we have paylog and we need to create actual payment request
            try {
                $charge = Stripe_Charge::create(array(
                    "amount" => $order->getAmount(),
                    "currency" => "usd",
                    "card" => $payLog->getTokenId(), // obtained with Stripe.js
                    "description" => "Charge for " . $order->getLicenseCount() . ' licenses',
                ));
            } catch(Stripe_CardError $e) {
                $charge = new stdClass();
                $charge->paid = false;
            }

            if ((bool)$charge->paid === true) {
                // set object and paylog as paid
                $payLog->setStatus(PropTeacherPayLogPeer::STATUS_SUCCESS);
                $payLog->setRawResponse(var_export($charge, true));
                $payLog->save();
                $order->setStatus(PropTeacherOrderPeer::STATUS_SUCCESS);
                $order->setPaymentId($charge->id);
                $order->save();

                // increase total number of licenses for teacher
                $teacherLicense = PropTeacherLicenseQuery::create()->findOneByTeacherId($order->getTeacherId());
                if (empty($teacherLicense) === true) {
                    $teacherLicense = new PropTeacherLicense();
                }

                $newLicenseCount = $teacherLicense->getCount() + $licenseCount;
                $teacherLicense->setTeacherId($order->getTeacherId());
                $teacherLicense->setCount($newLicenseCount);
                $teacherLicense->save();

                $teacher = PropTeacherQuery::create()->findOneByTeacherId($order->getTeacherId());
                $user = $teacher->getPropUser();

                $mailerData = new stdClass();
                $mailerData->email = $user->getEmail();

                $this->load->library('mailer/mailerlib');
                $this->mailerlib->sendOrderSuccessful($mailerData);

                redirect('store?success=' . base64_encode("Thank you for your order"));
            } else {
                $payLog->setStatus(PropTeacherPayLogPeer::STATUS_ERROR);
                $payLog->save();
                $order->setStatus(PropTeacherOrderPeer::STATUS_ERROR);
                $order->save();
                redirect('store?error=' . base64_encode("Payment failed - please try again"));
            }
        } else {
            redirect('store?error=' . base64_encode("Invalid token value - please try again"));
        }
    }

    protected function createOrderAndPayLog($licenseCount, $tokenString, $liveMode)
    {
        // calculate total order amount
        $totalAmount = $licenseCount * LICENSE_PRICE_USD;

        //first we need to create order object
        $teacherId = TeacherHelper::getId();

        $order = new PropTeacherOrder();
        $order->setTeacherId($teacherId);
        if ($liveMode === true) {
            $order->setLive(PropTeacherOrderPeer::LIVE_TRUE);
        } else {
            $order->setLive(PropTeacherOrderPeer::LIVE_FALSE);
        }
        $order->setAmount($totalAmount * 100);
        $order->setLicenseCount($licenseCount);
        $order->setStatus(PropTeacherOrderPeer::STATUS_PENDING);
        $order->save();

        $orderId = $order->getId();

        // and create pay log record
        $payLog = new PropTeacherPayLog();
        $payLog->setOrderId($orderId);
        $payLog->setTeacherId($teacherId);
        $payLog->setStatus(PropParentPayLogPeer::STATUS_UNDEFINED);
        $payLog->setTokenId($tokenString);
        $payLog->save();

        return $payLog;
    }
}
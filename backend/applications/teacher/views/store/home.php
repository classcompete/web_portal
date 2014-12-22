<?php

$this->load->config('stripe', true, true);
$stripeConfig = $this->config->item('stripe');

if ($stripeConfig['live_mode'] === true) {
    $publicKey = $stripeConfig['live_publish'];
} else {
    $publicKey = $stripeConfig['test_publish'];
}

?>
<!-- The required Stripe lib -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    // This identifies your website in the createToken call below
    Stripe.setPublishableKey('<?php echo $publicKey ?>');

    var stripeResponseHandler = function(status, response) {
        var $form = $('#payment-form');

        if (response.error) {
            // Show the errors on the form
            $form.find('.payment-errors').text(response.error.message);
            $form.find('.payment-errors').css('display', 'block');
            $form.find('.payment-success').css('display', 'none');
            $form.find('button').prop('disabled', false);
        } else {
            // token contains id, last4, and card type
            var token = response.id;
            // Insert the token into the form so it gets submitted to the server
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));
            // and re-submit
            $form.get(0).submit();
        }
    };

    jQuery(function($) {
        $('#payment-form').submit(function(e) {
            var $form = $(this);

            // Disable the submit button to prevent repeated clicks
            $form.find('button').prop('disabled', true);

            Stripe.card.createToken($form, stripeResponseHandler);

            // Prevent the form from submitting with the default action
            return false;
        });
        var $form = $('#payment-form');
        if ($form.find('.payment-errors').text().length > 0) {
            $form.find('.payment-errors').css('display', 'block');
        }
        if ($form.find('.payment-success').text().length > 0) {
            $form.find('.payment-success').css('display', 'block');
        }
    });
</script>
<style type="text/css">
    .payment-errors {
        border: 1px solid #dd2222;
        color: #dd2222;
        display: block;
        font-size: 14px;
        margin-bottom: 10px;
        padding: 10px;
        text-align: center;
        display: none;
    }
    .payment-success {
        border: 1px solid #22dd22;
        color: #22dd22;
        display: block;
        font-size: 14px;
        margin-bottom: 10px;
        padding: 10px;
        text-align: center;
        display: none;
    }
    #licenses option[disabled] { background-color: #e8e8e8; }
</style>
<div class="dashboard-wrapper store-page">
    <div class="left-sidebar margin_right_0">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">How it Works?</div>
                    </div>
                    <div class="widget-body clearfix">
                        <p style="font-size: 14px">
                            <span style="font-size: 16px;">
                                <strong>Class Compete</strong> is always free for teachers.
                            </span>
                            <br/>
                            We offer teachers <strong>2 licenses as a trial</strong> in a classroom to test <strong>ANY</strong>
                            challenge you would like.
                            <br/>
                            If a teacher needs more licenses then you can purchase extra licenses and allocate them to any classroom.
                            <br/><br/>
                            When a teacher buys licenses the account becomes a paid account and the 2 free trial licenses will be removed.
                            <em>For example if you need 5 licenses in a classroom you must buy 5 licenses.</em>
                            <br/><br/>
                            If you require bulk purchase pricing or need to purchase with a school Purchase Order,
                            its no problem, please <a href="<?php echo site_url('support')?>">contact us for assistance</a>.
                        </p>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Manage / Buy More Licenses</div>
                    </div>
                    <div class="widget-body clearfix" style="font-size: 14px">
                        <div class="span6 mod-classes">
                            <div class="row-fluid">
                                <span class="span8">
                                    <strong>Class Name</strong>
                                </span>
                                <span class="span2">
                                    <strong>Limits</strong>
                                </span>
                                <span class="span2"><strong>Modify</strong></span>
                            </div>
                            <?php foreach ($classes as $class): ?>
                            <div class="row-fluid">
                                <span class="span8">
                                    <?php echo $class->getName()?>
                                </span>
                                <span class="span2" style="text-align: center">
                                    <?php if ($class->getLimit() === 2): ?>
                                        <strong>2 Free</strong>
                                    <?php else: ?>
                                        <strong><?php echo $class->getLimit()?></strong>
                                    <?php endif ?>
                                </span>
                                <span class="span2" style="text-align: center">
                                    <a data-toggle="modal" data-target="#addEditClassTeacher"
                                       data-original-title="" data-icon="&#xe023" aria-hidden="true" class="fs1 edit"
                                       title="Modify <?php echo $class->getName() ?>" data-backdrop="static"
                                       href="<?php echo site_url('#classes/edit') . '/' . $class->getId() ?>"></a>
                                </span>
                            </div>
                            <?php endforeach ?>
                            <div class="row-fluid">
                                <h5 style="color: #0daed3; font-size: 14px;">
                                    You have <span style="font-size: 16px;"><?php echo TeacherHelper::getTotalLicenses() ?></span> paid licenses
                                    <br/>
                                    <span style="font-size: 13px;">
                                        * To use a paid license select "Modify" and adjust per classroom
                                    </span>
                                </h5>
                            </div>
                            <div class="modal hide fade classmodal" id="addEditClassTeacher" tabindex="-1" role="dialog"
                                 aria-labelledby="addClassLabel"
                                 aria-hidden="true">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">&times;</button>
                                    <h3>Add/Edit Class</h3>
                                </div>

                                <?php $this->load->view('x_class/compete/form'); ?>

                            </div>
                        </div>
                        <div class="span6">
                            <form action="<?php echo site_url('store/process_token')?>" method="POST" id="payment-form">
                                <span class="payment-errors"><?php echo base64_decode(@$_GET['error'])?></span>
                                <span class="payment-success"><?php echo base64_decode(@$_GET['success'])?></span>
                                <div class="form-row control-group">
                                    <label class="control-label">
                                        <span><strong>Licenses to Buy</strong></span>
                                    </label>
                                    <div class="controlls">
                                        <select name="license_count">
                                            <option value="5">5 ($<?php echo 5*LICENSE_PRICE_USD?>)</option>
                                            <option value="10">10 ($<?php echo 10*LICENSE_PRICE_USD?>)</option>
                                            <option value="15">15 ($<?php echo 15*LICENSE_PRICE_USD?>)</option>
                                            <option value="20">20 ($<?php echo 20*LICENSE_PRICE_USD?>)</option>
                                            <option value="25">25 ($<?php echo 25*LICENSE_PRICE_USD?>)</option>
                                            <option value="50">50 ($<?php echo 50*LICENSE_PRICE_USD?>)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row control-group">
                                    <label class="control-label">
                                        <span>Name on Card</span>
                                    </label>
                                    <div class="controlls">
                                        <input type="text" size="20" maxlength="100" data-stripe="name"/>
                                    </div>
                                </div>

                                <div class="form-row control-group">
                                    <label class="control-label">
                                        <span>Card Number</span>
                                    </label>
                                    <div class="controlls">
                                        <input type="text" size="20" maxlength="20" data-stripe="number" style="width: 150px"/>
                                    </div>
                                </div>

                                <div class="form-row control-group">
                                    <label class="control-label">
                                        <span>CVC</span>
                                    </label>
                                    <div class="controlls">
                                        <input type="text" size="4" maxlength="5" data-stripe="cvc" style="width: 50px"/>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <label class="control-label">
                                        <span>Expiration (MM/YYYY)</span>
                                    </label>
                                    <div class="controlls">
                                        <input type="text" size="2" maxlength="2" data-stripe="exp-month" style="width: 20px"/>
                                        <span> / </span>
                                        <input type="text" size="4" maxlength="4" data-stripe="exp-year" style="width: 45px"/>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary" style="margin-top: 10px; margin-right: 5%; float: left">Pay now</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal hide fade classmodal" id="addEditClassTeacher" tabindex="-1" role="dialog"
     aria-labelledby="addClassLabel"
     aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"
                aria-hidden="true">&times;</button>
        <h3>Add/Edit Class</h3>
    </div>

    <?php $this->load->view('x_class/compete/form'); ?>

</div>
<?php

function cc_form_subscriber_shortcode()
{

    ob_start(); ?>

    <div class="form-holder clearfix">

        <form name="ajax_form_subscribe" class="ajax_form_subscribe" action="" method="POST">

            <p>Get your FREE Class Code Today</p>

            <input type="email" name="email" placeholder="Enter your Email"/>
            <div id="wrapper_subscribe"></div>
            <input class="btn btn-default" type="submit" name="cc_submit_subscribe" value="Submit"/>

        </form>

    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('form_subscriber', 'cc_form_subscriber_shortcode');


function cc_form_connection_shortcode()
{
    return '';

    ob_start(); ?>

    <div class="form-holder clearfix">

        <form name="ajax_form_connection" class="ajax_form_connection" action="" method="POST">

            <p>Connect your account to your student(s) to have access to real-time statistics</p>

            <input type="email" name="email" placeholder="Enter your email"/>

            <input type="text" name="username" placeholder="Enter student username"/>

            <input type="password" name="password" placeholder="Enter student password" autocomplete="off" />
            <div id="wrapper_connection"></div>

            <input class="btn btn-default" type="submit" name="cc_submit" value="Submit"/>

        </form>

    </div>

    <?php
    return ob_get_clean();
}

add_shortcode('form_connection', 'cc_form_connection_shortcode');
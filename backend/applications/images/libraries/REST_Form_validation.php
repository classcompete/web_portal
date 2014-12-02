<?php

class REST_Form_validation extends CI_Form_validation
{
    public function getErrorArray()
    {
        return $this->_error_array;
    }
}
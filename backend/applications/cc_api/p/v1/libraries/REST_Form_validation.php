<?php

class REST_Form_validation extends CI_Form_validation{

    public function __construct($config = array()){
        parent::__construct($config);
    }
    public function getErrorArray(){
        return $this->_error_array;
    }

    public static function validation_errors_array(){
        if (FALSE === ($OBJ =& _get_validation_object()))
        {
            return '';
        }
        if (count($OBJ->_error_array) === 0)
        {
            return '';
        }
        $array = '';
        foreach ($OBJ->_error_array as $key => $val)
        {
            if ($val != '')
            {
                $array[$key]= $val;
            }
        }
        return $array;
    }
}
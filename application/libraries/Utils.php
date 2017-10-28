<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
 
class Utils {

    public static function convertCurrencyToFloat($currency)
    {
        if(trim($currency) == '')
        {
            return 0;
        }

        $float = str_replace('R$ ', '', $currency);

        $float = str_replace('.', '', $float);

        $float = str_replace(',', '.', $float);

        if(is_numeric($float) AND $float > 0)
        {
            return $float;
        }else{

            return 0;
        }
    }
}

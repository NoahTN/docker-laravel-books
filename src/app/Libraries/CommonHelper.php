<?php 

// Code from: https://github.com/Nirav-webs-99/hotel_review_api_test/blob/master/app/Libraries/CommonHelper.php

namespace App\Libraries;

class CommonHelper
{
    /**
     * Used to set validation related error messages.
     * 
     * @param Array $errors 
     * @return string 
     */
    public static function customErrorResponse(Array $errors): string
    {
        $error_str = '';
        foreach($errors as $error) 
        {
            $error_str .= str_replace('.', ',', $error[0]);
        }
        return rtrim($error_str, ',');
    }
}
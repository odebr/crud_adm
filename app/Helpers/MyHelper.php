<?php

if (!function_exists('my_date_format')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function my_date_format($dat_str=null, $format='Y-m-d')
    {
        if ($dat_str == null) {
            return date($format);
        } else {
            return date($format, strtotime($dat_str));
        }
    }
}

if (!function_exists('my_date_compare')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function my_date_compare($dat1, $dat2=null)
    {
        if ($dat2 == null) {
            $dat2 = time();
        } else {
            $dat2 = strtotime($dat2);
        }
        $dat1 = strtotime($dat1);

        return $dat1>$dat2? 1 : ($dat1 < $dat2 ? -1 : 0);
    }
}

if (!function_exists('is_user_plan_active')) {
    /**
     * Returns a human readable file size
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function is_user_plan_active($planCode, $user=null)
    {
        if (!$user) $user = Auth::user();

        return intval($user->plan_code) >= $planCode && $user->plan_status == 'active';
    }
}

function convert_date_time_for_db($input) {
    $input = str_replace('-', '/', $input);
    $date = strtotime($input);
    return date('Y-m-d H:i', $date);
}

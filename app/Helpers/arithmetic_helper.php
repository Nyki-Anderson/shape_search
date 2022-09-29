<?php

use CodeIgniter\I18n\Time;

/** 
* Round percentage to nearest whole number
* @param float value of percentage
* @param integer value of precision desired
* @return string percentage %
*/
if (! function_exists('round_percentage')) {
    function round_percentage(float $percentage, int $precision) 
    {
        return round($percentage, $precision) . '%';
    }
}

/** 
* Calculate percentage by adding values together to find
* total, then dividing by key value. Then calls round
* percentage
* @param array of values from table to include in 
* calculation
* @param integer of key value in percentage 
* @return float of calculated percentage to desired precision
*/   
if (! function_exists('get_percentage')) {    
    function get_percentage(int $total, int $key_value, int $precision) 
    {
        // Can't divide by zero
        if ($total == 0) {
            return round_percentage(0,0);
        }
        else {
            $percentage = ($key_value / $total) * 100;
            $roundPercent = round_percentage($percentage, $precision);
            return $roundPercent;
        }
    }
}

/**
 * Convert numbers into nearest thousand format to one decimal place
 * (i.e. ---.- k, m, b, t)
 * @param int number to be formatted
 * @return string number formatted in nearest thousand format with trailing decimal place 
 */
if (! function_exists('get_num_words')) {
    function get_num_words(float $num) 
    {
        if ($num > 999) {
                $num_round = round($num);
                $num_separated = number_format($num_round);
                $num_array = explode(',', $num_separated);
                $num_parts = array('k', 'm', 'b', 't');
                $num_count_parts = count($num_array) - 1;

                $num_display = $num_round;
                // First part of thousand separated format (up to 3 digits). If the first digit of the second part of thousand separated format (the decimal in this case) does not equal 0, add decimal place and digit. Otherwise do not display 0 after decimal.
                $num_display = $num_array[0] . ((int) $num_array[1][0] !== 0 ? '.' . $num_array[1][0] : '');
                // Based on number of thousand separations -1 (for array starting at [0]) select k,m,b,t
                $num_display .= $num_parts[$num_count_parts - 1];

                return $num_display;
        } else {
            return $num;
        }
    }
}

if (! function_exists('get_date_words')) {
    function get_date_words(string $date)
    {
        $current = Time::parse('now');
        $test = Time::parse($date);
        
        $diff = $current->difference($test);

        return $diff->humanize();
    }
}
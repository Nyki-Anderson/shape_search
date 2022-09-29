<?php

if (! function_exists('myEach')) {
    function myEach(&$arr) 
    {
        $key = key($arr);
        
        $result = ($key === null) ? false : [$key, current($arr), 'key' => $key, 'value' => current($arr)];

        next($arr);

        return $result;
    }
}
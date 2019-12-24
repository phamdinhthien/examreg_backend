<?php
     function validateValue($code, $year_start, $year_end){
        $regexCode = '/^\w/';
        $regexYear = '/^[0-9]{4}$/';
        if(preg_match($regexCode, $code) && preg_match($regexYear, $year_start)
        && preg_match($regexYear, $year_end) && $year_end - $year_start >= 4){
            return true;
        } 
        return false;
    }


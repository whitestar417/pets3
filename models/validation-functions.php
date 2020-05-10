<?php

/*
 * Validate a color
 *
 * @param String color
 * @return boolean true if parameter is in the array of colors, false otherwise
 */
function validColor($color)
{
    global $f3;
    return in_array($color, $f3->get('colors'));
}

/*
 * Validate a pet type
 *
 * @param String pet
 * @return boolean true if not empty and all alphabetic, false otherwise
 */
function validString($string)
{
    if(empty($string) || !ctype_alpha($string)){
        return false;
    }
    return true;
}
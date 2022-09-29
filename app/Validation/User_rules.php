<?php

namespace App\Validation;

use App\Models\UserModel;

class User_rules 
{
    /**
     * Checks if input username exists in database and then checks whether the input password matches the hash for that username
     * @param string $str is the input password
     * @param string $fields are the associated form fields that are being used
     * @param array $data is an array containing the values for the fields indexed by field names
     * @return boolean true or false depending on if the user exists and the password matches the hashed password stored in the database
     */
    public function validateUser(string $str, string $fields, array $data)
    {
        $userModel = new UserModel();

        $user = $userModel->getUser($data['username']);

        if(! $user) {

            return FALSE;
        }

        return password_verify($data['password'], $user->password);
    }

    /**
     * Checks if string contains any instances of specified bad words.
     * @param string $str is the input string from the form to check
     * @param string $fields are the field names to be checked
     * @param array $data is an array indexed by field name that contains their respective values.
     * @return boolean true if no bad words are found, false if one or more bad words are found in the string.
     */
    public function badWordsFilter(string $str, string $fields, array $data)
    {
        $badWords = [
            "arse",
            "ass",
            "booty",
            "butt",
            "damn",
            "goddamn",
            "arsehole",
            "bitch",
            "bullshit",
            "pissed",
            "shit",
            "poop",
            "tits",
            "boobs",
            "bastard",
            "cock",
            "dick",
            "penis",
            "dickhead",
            "pussy",
            "vagina",
            "twat",
            "cunt",
            "fuck",
            "motherfucker",
        ];

        $matches = [];
        
        // If csv is passed to rule, commas are replaced with spaces to delineate beginning and endings of words
        $stringToCheck = str_replace(",", " ", $data[$fields]);

        // If title is passed to rule, hyphens and underscores are replaced with spaces to delineate beginning and endings of words
        $stringToCheck = str_replace("-", " ", $stringToCheck);
        $stringToCheck = str_replace("_", " ", $stringToCheck);

        if (is_string($stringToCheck) && ! empty($stringToCheck)) {
            $regex = "/\b(" . implode('|', $badWords) . ")\b/i";

            $matchFound = preg_match_all($regex, $stringToCheck);

            if ($matchFound) {

                return false;
            
            } else {

                return true;
            }
        } else {

            return true;
        }
    }

    public function validateDate($str, string $fields, array $data)
    {
        if (checkdate((int) $data['bday_month'], (int) $data['bday_day'], (int) $data['bday_year'])) {
        
            return TRUE;
    
        } else {

            return FALSE;
        }

    }
}
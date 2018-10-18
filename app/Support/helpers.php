<?php

if (!function_exists('acronym')) {
    /**
     * Extra acronym from phrase
     * @param $phrase
     * @param int $max
     * @param bool $toUpper
     * @return null|string
     */
    function acronym($phrase, $max = 2, $toUpper = true)
    {
        $words = explode(" ", $phrase);

        $initials = null;

        foreach ($words as $idx => $word) {
            if($idx == $max)
                break;

            $initials .= $word[0];
        }

        if (!$toUpper)
            return $initials;

        return strtoupper($initials);
    }
}
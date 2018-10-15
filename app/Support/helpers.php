<?php

if (!function_exists('acronym')) {
    /**
     * Extra acronym from phrase
     * @param $phrase
     * @param bool $toUpper
     * @return null|string
     */
    function acronym($phrase, $toUpper = true)
    {
        $words = explode(" ", $phrase);

        $initials = null;

        foreach ($words as $w) {
            $initials .= $w[0];
        }

        if (!$toUpper)
            return $initials;

        return strtoupper($initials);
    }
}
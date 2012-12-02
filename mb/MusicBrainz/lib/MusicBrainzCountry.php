<?php

class MusicBrainzCountry
{
    private static $countries = array(
        'GB' => 'Great Britain',
        //add the rest #todo
    );

    /**
     * Get the country name for a MusicBrainz country code
     *
     * @static
     * @param $country_code
     * @return bool
     */
    public static function getName($country_code)
    {
        if ( isset(self::$countries[$country_code]) )
        {
            return self::$countries[$country_code];
        }
        else
            return false;
    }
}

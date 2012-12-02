<?php
/**
 * Represents a release object.
 * 
 */
class MusicBrainzRelease {
    
    public $id;
    public $title;
    public $status;
    public $quality;
    public $language;
    public $script;
    public $date;
    public $country;
    public $barcode;

    function __construct(SimpleXMLElement $xml ){

        $this->id        = (string) $xml['id'];
        $this->title     = (string) $xml->title;
        $this->status    = (string) $xml->status;
        $this->quality   = (string) $xml->quality;
        $this->language  = (string) $xml->{'text-representation'}->language;
        $this->script    = (string) $xml->{'text-representation'}->script;
        $this->date      = (string) $xml->date;
        $this->country   = (string) $xml->country;
        $this->barcode   = (string) $xml->barcode;

    }

    /**
     * Get included releases from the XML of another entity
     *
     * @static
     * @param SimpleXMLElement $result
     * @param $entity string
     * @return array
     */
    public static function getIncluded(SimpleXMLElement $result, $entity)
    {
        $releases = array();
        
        if (isset($result->$entity->{'release-list'}))
        {
            foreach ( $result->$entity->{'release-list'}->release as $release)
            {
                $releases[] = new self($release);
            }
        }
        
        return $releases;
    }
}

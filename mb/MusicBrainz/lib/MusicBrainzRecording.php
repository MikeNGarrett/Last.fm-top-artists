<?php
/**
 * Represents a MusicBrainz Recording
 * 
 */
class MusicBrainzRecording {
    
    private $id;
    private $title;

    function __construct(SimpleXMLElement $xml ){

        $this->id        = (string) $xml['id'];
        $this->title     = (string) $xml->title;

    }

    /**
     * Get included recordings from the XML of another entity
     *
     * @static
     * @param SimpleXMLElement $result
     * @param $entity string
     * @return array
     */
    public static function getIncluded(SimpleXMLElement $result, $entity)
    {
        $recordings = array();
        
        if (isset($result->$entity->{'recording-list'}))
        {
            foreach ( $result->$entity->{'recording-list'}->recording as $recording)
            {
                $recordings[] = new self($recording);
            }
        }
        
        return $recordings;
    }
}

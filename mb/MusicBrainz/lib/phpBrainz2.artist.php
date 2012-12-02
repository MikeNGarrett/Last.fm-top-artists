<?php

/**
 * Represents a MusicBrainz artist.
 * 
 */
class phpBrainz2_Artist {
    
    private $id;
    private $type;
    private $name;
    private $sortName;
    private $gender;
    private $country;
    private $beginDate;
    private $endDate;
    private $disambiguation;
    private $releasesCount;
    private $releasesOffset;
    
    function __construct( SimpleXMLElement $artist_data )
    {
        $this->id        = (string) $artist_data->artist['id'];
        $this->type      = (string) $artist_data->artist['type'];
        $this->name      = (string) $artist_data->artist->name;
        $this->sortName  = (string) $artist_data->artist->{'sort-name'};
        $this->gender    = (string) $artist_data->artist->gender;
        $this->country   = (string) $artist_data->artist->country;
        $this->beginDate = (string) $artist_data->artist->{'life-span'}->begin;
        $this->endDate   = (string) $artist_data->artist->{'life-span'}->end;
    }

    /**
     *  Magic __get method
     */
    public function __get($name) {
       return isset($this->$name) ? $this->$name : null;
    }
        
}
<?php

/**
 * Represents a MusicBrainz artist.
 * 
 */
class MusicBrainzArtist {
    
    private $id;
    private $type;
    private $name;
    private $sortName;
    private $gender;
    private $country;
    private $beginDate;
    private $endDate;

    private $xml;

    public $releases = array();

    function __construct( SimpleXMLElement $artist_data )
    {
        $this->xml = $artist_data;

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
     *  Magic getter
     */
    public function __get($var) {
       return isset($this->$var) ? $this->$var : null;
    }

    /**
     *  The following methods are the getters for includes
     */

    public function getReleases()
    {
        return MusicBrainzRelease::getIncluded($this->xml, 'artist');
    }

    public function getRecordings()
    {
        return MusicBrainzRecording::getIncluded($this->xml, 'artist');
    }

    public function getReleaseGroups()
    {
        return MusicBrainzReleaseGroup::getIncluded($this->xml, 'artist');
    }

}

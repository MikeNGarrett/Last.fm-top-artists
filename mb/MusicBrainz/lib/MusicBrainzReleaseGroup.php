<?php
/**
 * MusicBrainz release-group
 */

/**
 * Represents a MusicBrainz release-group object.
 *
 * Can be filtered by type.
 */
class MusicBrainzReleaseGroup {
    
    private $id;

    private $type;

    private $title;

    private $first_release_date;

    /* @var string */
    private $primary_type;

    /* @var array */
    private $secondary_types;

    /**
     * @todo
     */
    public function __construct(SimpleXMLElement $xml )
    {
        if ( isset($xml->{'release-group'}) )
        {
            $xml = $xml->{'release-group'};
        }

        $this->id                 = (string) $xml['id'];
        $this->type               = (string) $xml['type'];
        $this->title              = (string) $xml->title;
        $this->first_release_date = (string) $xml->{'first-release-date'};
        $this->primary_type       = (string) $xml->{'primary-type'};

        if ( isset($xml->{'secondary-type-list'}) )
        {
            foreach ( $xml->{'secondary-type-list'}->{'secondary-type'} as $type)
            {
               $this->secondary_types[] = (string) $type[0];
            }
        }
    }

    /**
     *  Magic getter
     */
    public function __get($var) {
        return isset($this->$var) ? $this->$var : null;
    }

    /**
     * Get included release-groups from the XML of another entity
     *
     * @static
     * @param SimpleXMLElement $result
     * @param $entity string
     * @return array
     */
    public static function getIncluded(SimpleXMLElement $result, $entity)
    {
        $release_groups = array();

        if (isset($result->$entity->{'release-group-list'}))
        {
            foreach ( $result->$entity->{'release-group-list'}->{'release-group'} as $release_group)
            {
                $release_groups[] = new self($release_group);
            }
        }
        
        return $release_groups;
    }
}

<?php

require_once("../phpBrainz2.php");

$phpBrainz2 = new phpBrainz2();

$args = array( 
    "title"  => "Learn",
    "artist" => "Foo Fighters"
);

$releaseFilter = new phpBrainz2_ReleaseFilter($args);

$releaseResults = $phpBrainz->lookup($releaseFilter);

print_r($releaseResults);

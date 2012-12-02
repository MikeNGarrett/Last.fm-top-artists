<?php
require_once '../MusicBrainz/MusicBrainz.php';

// release-group lookup

$mb = new MusicBrainz();

try
{
    //born this way: the remix
    $release_group = $mb->lookup('release-group', 'e4307c5f-1959-4163-b4b1-ded4f9d786b0');
    print_r($release_group);
}
catch (MusicBrainzException $e)
{
    echo $e->getMessage();
}


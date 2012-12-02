<?php
require_once '../MusicBrainz/MusicBrainz.php';

// Artist lookup

$mb = new MusicBrainz();

try
{
    $artist = $mb->lookup('artist', '4dbf5678-7a31-406a-abbe-232f8ac2cd63');  //bryan adams
    print_r($artist);
}
catch (MusicBrainzException $e)
{
    echo $e->getMessage();
}


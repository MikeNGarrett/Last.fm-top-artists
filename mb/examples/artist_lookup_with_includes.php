<?php
require_once '../MusicBrainz/MusicBrainz.php';

// Artist lookup with includes

$mb = new MusicBrainz();

try
{
    $includes = array('releases', 'recordings', 'release-groups');
    $artist = $mb->lookup('artist', '4dbf5678-7a31-406a-abbe-232f8ac2cd63', $includes);  //bryan adams

    $releases = $artist->getReleases();

    echo '<h1>Releases</h1>';
    print_r($releases);

    $release_groups = $artist->getReleaseGroups();

    echo '<h1>Release Groups</h1>';
    print_r($release_groups);

    $recordings = $artist->getRecordings();

    echo '<h1>Recordings</h1>';
    print_r($recordings);

}
catch (MusicBrainzException $e)
{
    echo $e->getMessage();
}

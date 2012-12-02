<?php

require 'lastfm.php';

$topArtists = getTopArtists();
print_r($topArtists);
/*
echo "<b>".$topArtists['username']."'s</b> most played artists<br /><br />\n";

foreach($topArtists['artists'] as $artist)
{
  echo "<image src=\"".$artist['image']."\" /><br />\n";
  echo "<a href=\"".$artist['link']."\"><b>".$artist['name']."</b></a><br />\n";
  echo "plays: <b>".$artist['plays']."</b><br /><br /><br />\n\n";
}
*/
?>
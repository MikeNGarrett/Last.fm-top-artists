<?php

define('API_KEY', '');                  //your api key
define('LASTFM_USER', 'ectolysergic');  //last.fm username

/**
  * get artist info for listener's top ten
  * @param string $user last.fm username
  * @return array listener and artist info
  */
function getTopArtists($user = LASTFM_USER)
{
  if (!$doc = @file_get_contents('http://ws.audioscrobbler.com/2.0/?method=user.gettopartists&user='.$user.'&api_key='.API_KEY.'&limit=10'))
    die('could not connect to Last.fm API');
  
  $xml = new SimpleXMLElement($doc);
  $data = array();
  $data['username'] = $xml->topartists['user'];
  
  foreach($xml->topartists->artist as $artist)
  {
    $image=$artist->xpath("image[@size = 'large']");
    $imageRaw=$image[0]->asXML();
    $image = preg_replace('/(<.+?>)/', '', $imageRaw);

    $data['artists'][]=array('name' => $artist->name, 'plays' => $artist->playcount, 'image' => $image, 'link' => $artist->url);
  }
  
  return $data;
}


$topArtists = getTopArtists();
echo "<b>".$topArtists['username']."'s</b> most played artists<br /><br />\n";

foreach($topArtists['artists'] as $artist)
{
  echo "<image src=\"".$artist['image']."\" /><br />\n";
  echo "<a href=\"".$artist['link']."\"><b>".$artist['name']."</b></a><br />\n";
  echo "plays: <b>".$artist['plays']."</b><br /><br /><br />\n\n";
}


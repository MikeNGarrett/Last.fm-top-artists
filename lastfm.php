<?php

define('API_KEY', '0f7c0c0bd061c53a8ffde348d56e154f');                  //your api key
define('LASTFM_USER', 'livefire');  //last.fm username


/**
  * get artist info for listener's top ten
  * @param string $user last.fm username
  * @return array listener and artist info
  */
function getWrapUp($user = LASTFM_USER) {

	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_URL, 'http://ws.audioscrobbler.com/2.0/?method=user.getTopAlbums&user='.$user.'&api_key='.API_KEY.'&limit=50&period=12month&format=json');
	
	$doc = curl_exec($ch);
	curl_close($ch);
	
	if(empty($doc)) 
    die('could not connect to Last.fm API');
  
    $output = json_decode($doc);

  //$xml = new SimpleXMLElement($doc);

//  $data = array();
//  $data['username'] = $xml->topartists['user'];
/*  
  foreach($xml->topartists->artist as $artist)
  {
    $image=$artist->xpath("image[@size = 'large']");
    $imageRaw=$image[0]->asXML();
    $image = preg_replace('/(<.+?>)/', '', $imageRaw);

    $data['artists'][]=array('name' => $artist->name, 'plays' => $artist->playcount, 'image' => $image, 'link' => $artist->url);
  }
*/  
  return $output;
}

function getAlbum($mbid) {
	// last.fm release dates SUCK... so we use musicbrainz
	require_once 'mb/MusicBrainz/MusicBrainz.php';
		
	$mb = new MusicBrainz();
	
	try {	
	    $artist = $mb->lookup('artist', $mbid, array('releases'));  //bryan adams
	    $releases = $artist->getReleases();
	}
	catch (MusicBrainzException $e) {
	    echo $e->getMessage();
	}
	return $releases;
/*

// LAST.FM release dates... terrible
	if(empty($artist) || empty($album)) {
		return false;
	}
	if(!empty($mbid)) {
		$mbid = '&mbid='.$mbid;
	}
	if (!$doc = @file_get_contents('http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key='.API_KEY.'&limit=10&period=12month&artist='.$artist.'&album='.$album.$mbid.'&username='.LASTFM_USER.'&format=json'))
		die('could not connect to Last.fm API');
  
	$output = json_decode($doc);
	
	//http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key=0f7c0c0bd061c53a8ffde348d56e154f&artist=Cher&album=Believe&format=json

	return $output;
*/
}
function tryAlbum($mbid) {
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
	curl_setopt($ch, CURLOPT_URL, 'http://ws.audioscrobbler.com/2.0/?method=album.getinfo&api_key='.API_KEY.'&mbid='.$mbid.'&username='.LASTFM_USER.'&format=json');
	
	$doc = curl_exec($ch);
	curl_close($ch);
	
	if(empty($doc)) 
    die('could not connect to Last.fm API');

	$doc = str_replace('#', '', $doc);
	$output = json_decode($doc);
	return $output;
}

?>
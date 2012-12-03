<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>Wrap Up</title>		
	</head>
	<body>
	<h1>2012 Wrap Up</h1>
	<p>Your top albums as reported by last.fm according to our magic algorithm.</p>
<?php
// $albuminfo is empty... this is probably due to the fact that the right info is getting used
require 'lastfm.php';

$debug = false;

if($_GET && isset($_GET['user'])) {
	$user = $_GET['user'];	
} else {
	print('<div style="width: 96%; height: 500px; background: #FFF; margin: 2%;"><form action="/" method="get"><label for="user">Last.fm Username: <input type="text" name="user" /><input type="submit" value="GO"></form><p><small>Enter your last.fm username to get started.</small></p></div>');
	die;
}
print('<img src="loader.gif" style="position: absolute; top: 320px; display: block; margin: 0 auto; width: 220px; height: 19px; z-index: 1; left: 10%;" />');
$res = getWrapUp($user);
$output = array();

if($res) {
	$albums = $res->topalbums->album;
	$releasedate = 0;
	$rsource = 'nada';
	foreach($albums as $album) {
		if(empty($album->mbid)) {
			$mbalbuminfo = getAlbum($album->artist->mbid);
			foreach($mbalbuminfo as $release) {
				if($release->id == $album->mbid) {
					$releasedate = date('U', strtotime($release->date));
					$rsource = 'mbid';
				}
			}
			if(empty($releasedate)) {
				foreach($mbalbuminfo as $release) {

					if($album->name == $release->title) {
						$releasedate = date('U', strtotime($release->date));
						$rsource = 'mbtitle';
					}
				}
			}
		} else {
			$albuminfo = tryAlbum($album->mbid);
			//6 Apr 1999, 00:00
//			$date = date_create();
			$test = trim($albuminfo->album->releasedate);
			$date = date_create_from_format('d F Y, H:i', $test);//$albuminfo->album->releasedate);
			if($debug) {
				print_r(date_get_last_errors());
			}
//			print($albuminfo->album->releasedate.'<br/>');
			if($date) {
				$releasedate = date_format($date, 'U');
			} else {
				$releasedate = date('U', mktime(0,0,0,1,1,2012));			
			}
			$rsource = 'last';
		}

		if(empty($releasedate)) {
			$releasedate = date('U', mktime(0,0,0,1,1,2012));
			$rsource = 'crap';
		}

		if(date('Y', $releasedate) == '2012' ) {
			$diff = (date('U',time()) - $releasedate) / 60 / 60 / 24;
			if(isset($albuminfo->album->tracks)) {
				$number = count($albuminfo->album->tracks->track);
			} else {
				$number = 0;
			}
			if($number > 0) {
				$listens = ($albuminfo->album->userplaycount / $number);
			} else {
				$listens = ($albuminfo->album->userplaycount / 10);
			}
		$calc = round(($listens / $diff) * 10000, 0);
		
		while(!empty($output[$calc])) {
			$calc = $calc - 1;
		}
		$output[$calc]['last'] = $albuminfo->album;
		$output[$calc]['release'] = date('F j Y', $releasedate);
		$output[$calc]['debug'] = array(
			'listens' => $listens,
			'release' => date('F j Y', $releasedate),
			'release source' => $rsource,
		);
		if(!empty($mbalbuminfo)) {
			$output[$calc]['mb'] = $mbalbuminfo;
		}

			
		}
//		print('listens: '.$listens);

	}

}
krsort($output);

$i = 1;
foreach($output as $key => $data) {
$last = $data['last'];
?>
<div class="chart-item" style="clear: both; float: none; width: 96%; height: 180px; background: #FFF; padding: 25px 2%; z-index: 2; position: relative;">
	<div style="float: left; margin-right: 20px;">
		<a href="<?php echo $last->url; ?>"><img src="<?php echo $last->image[2]->text; ?>" /></a>
	</div>
	<div style="float: left; ">
		<h1 style="margin-top: 0;"><?php echo $i; ?>. <?php echo $last->name; ?> <small>By <a href="<?php echo $last->url; ?>"><?php echo $last->artist; ?></a></small></h1>
		<ul>
		<li><strong>Popularity:</strong> <?php echo $key; ?></li>
		<li><strong>Artist Profile:</strong> <a href="<?php echo $last->url; ?>">Link</a></li>
		<li><strong>Global Listeners:</strong> <?php echo $last->listeners; ?></li>
		<li><strong>Your Scrobbles:</strong> <?php echo $last->userplaycount; ?></li>
		<li><strong>Release Date:</strong> <?php echo $data['release']; ?></li>
		</ul>
	</div>
</div>
<?php
if($debug) {
	print_r($data['debug']);
//	print_r($data);
	if(!empty($data['mb'])) {
//		print_r($data['mb']);
	}
die;
}

$i++;
}

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
	</body>
</html>

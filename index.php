<?php
// $albuminfo is empty... this is probably due to the fact that the right info is getting used
require 'lastfm.php';

$debug = false;

$res = getWrapUp();
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
ksort($output);

$i = 1;
foreach($output as $key => $data) {
$last = $data['last'];
print_r($last);
//<img src="<?php echo $last->album->image; " />
?>
<h1><?php echo $i; ?></h1>
<h2><?php echo $last->name; ?></h2>
<h3>By <?php echo $last->artist; ?></h3>
<ul>
<li><strong>Number:</strong> <?php echo $key; ?></li>
<li><strong>Profile:</strong> <a href="<?php echo $last->url; ?>">Link</a></li>
<li><strong>Listeners:</strong> <?php echo $last->listeners; ?></li>
<li><strong>Your Listens:</strong> <?php echo $last->userplaycount; ?></li>
<li><strong>Release Date:</strong> <?php echo $data['release']; ?></li>
</ul>

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
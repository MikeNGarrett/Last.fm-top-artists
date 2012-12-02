<?php

require_once("../phpBrainz2.php");

$mbid = "d615590b-1546-441d-9703-b3cf88487cbd";

$trackIncludes = array(
	"artist",
	"releases",
	"puids"
	);

$phpBrainz2 = new phpBrainz2();

print_r($phpBrainz->get($mbid,$trackIncludes));

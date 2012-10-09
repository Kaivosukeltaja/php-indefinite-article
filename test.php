<?php

require_once("IndefiniteArticle.class.php");

$testWords = array("umbrella", "hour", "American", "German", "Ukrainian", "Uzbekistani", "euphenism", "Euler number");

foreach($testWords as $word) {
	echo "$word => ".IndefiniteArticle::A($word)."\n";
}


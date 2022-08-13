<?php

require_once("IndefiniteArticle.class.php");

$testWords = array("umbrella", "hour", "American", "German", "Ukrainian", "Uzbekistani", "euphenism", "Euler number", "11 Degrees T-shirt", "18", "1800");

foreach($testWords as $word) {
	echo "$word => ".IndefiniteArticle::A($word)."<br>\n";
}


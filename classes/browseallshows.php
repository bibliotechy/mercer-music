<?php

class BrowseAllShows extends Api {
	
	public static function buildResultArray($f3, $shows, $db) {
		$shows = BrowseAllShows::getAllShows($f3, $shows, $db);
		return $shows;
	}
	
	public static function getAllShows($f3, $shows, $db){
		$sql = "SELECT * 
  	            FROM ms_shows 
  	            WHERE Suppress <> 1";
	$f3->set('result',$db->exec($sql));
	foreach ($f3->get('result') as $value) {
		$shows[] =$value;
		}
	return $shows;
	}
}

?>
<?php

class BrowseAllMovies extends Api {
	
	public static function buildResultArray($f3, $movies, $db) {
		$movies = BrowseAllMovies::getAllMovies($f3, $movies, $db);
		return $movies;
	}
	
	public static function getAllMovies($f3, $movies, $db){
		$sql = "SELECT * 
  	            FROM ms_movies 
  	            WHERE Suppress <> 1";
	$f3->set('result',$db->exec($sql));
	foreach ($f3->get('result') as $value) {
		$movies[] =$value;
		}
	return $movies;
	}
}

?>
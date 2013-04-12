<?php

class Movie extends Api {
  
  public static function buildResultArray($f3, $movie, $db) {
  	$movie = Movie::getMovieBaseInfo($f3, $movie, $db);
	$movie = Movie::getHoldingsInfo($f3, $movie, $db);
	$movie = Movie::getSongsInMovie($f3, $movie, $db);
    return $movie;
  }
  
  public static function getMovieBaseInfo($f3, $movie, $db) {
  	$sql = "SELECT * 
  	        FROM ms_movies 
  	        WHERE ID =?";
	$f3->set('result',$db->exec($sql, $f3->get('PARAMS.movie')));
	foreach ($f3->get('result') as $key => $value) {
		$movie[$key] = $value;
	}
	return $movie;
  }
  
  public static function getHoldingsInfo($f3, $movie, $db) {
  	$sql = "SELECT h.Name 
  	        FROM ms_movies_holdings h 
  	        JOIN ms_j_movieholding j on j.holdingID = h.ID 
            WHERE  j.movieID =?";
    $f3->set('result',$db->exec($sql, $f3->get('PARAMS.movie')));
	foreach ($f3->get('result') as $key => $value) {
		$movie['Holdings'][] = $value;
	}
	return $movie;
  }
  
  public static function getSongsInMovie($f3, $movie, $db) {
  	$sql = "SELECT s.ID, s.Title 
  	        FROM ms s 
  	        JOIN ms_j_songmovie j on s.ID = j.songID
  	        WHERE j.movieID =?";
	$f3->set('result',$db->exec($sql, $f3->get('PARAMS.movie')));
	foreach ($f3->get('result') as $key => $value) {
		$movie['Songs'][] = $value;
	}
	return $movie;
  }
}
?>

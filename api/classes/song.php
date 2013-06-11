<?php

class Song extends Api{
     
    public static function buildResultArray($f3, $song, $db) {
    $song = Song::getSongBaseInfo($f3, $song, $db);
    $song = Song::getAlternateTitles($f3, $song, $db);
    $song = Song::getCitationsInfo($f3, $song, $db);
    $song = Song::getHoldingsInfo($f3, $song, $db);
	$song = Song::getMovies($f3, $song, $db);
	$song = Song::getShows($f3, $song, $db);
    return $song; 
  }

  public static function getSongBaseInfo($f3, $song, $db) {
    $sql = "SELECT * FROM ms WHERE ID =" . $f3->get('PARAMS.song') . " AND Suppress <> 1";
    $f3->set('result',$db->exec($sql));
    foreach ($f3->get('result')  as $key => $value) {
      $song[] = $value ;
    }
    return $song;
   }

  public static function getAlternateTitles($f3, $song, $db) {
    $sql = "SELECT Title FROM ms_alt WHERE ParentID = " . $f3->get('PARAMS.song');
    $f3->set('result',$db->exec($sql));
    if ($f3->get('result')) {
      foreach ($f3->get('result')  as $key => $value) {
        $song[0]['AlternateTitles'][$key] = $value;
      }
	}
	else {
		$song[0]['AlternateTitles'] = array();
    }
    return $song;
  }

  public static function getCitationsInfo ($f3, $song, $db) {
    $sql = "SELECT c.Name, c.Shortname, c.Letter, c.URL 
            FROM ms_citations c 
            JOIN ms_j_songcitation j on j.CitationID = c.ID 
            WHERE j.SongID =" . $f3->get('PARAMS.song');
    $f3->set('result',$db->exec($sql));
    if ($f3->get('result')) {
      foreach ($f3->get('result')  as $key => $value) {
        $song[0]['Citations'][$key] = $value;
      }
    }
	else {
		$song[0]['Citations'] = array();
	}
    return $song;
  }

  public static function getHoldingsInfo($f3, $song, $db) {
    $sql = "SELECT h.name, h.ID
            FROM ms_holdings h 
            JOIN ms_j_songholding j ON j.holdingID = h.ID
            WHERE j.SongID =" . $f3->get('PARAMS.song');
    $f3->set('result',$db->exec($sql));
    if ($f3->get('result')) {
      foreach ($f3->get('result')  as $key => $value) {
        $song[0]['Holdings'][$key] = $value;
        if (in_array($value['ID'], array(7, 9))){
          $song[0]['Holdings'][$key]['recording'] = Song::hasSoundRecording($f3,$db);
        }
      }
    }
	else {
	  $song[0]['Holdings'] = array();
	}
    return $song;
  }
  
  public static function getMovies($f3, $song, $db) {
  	$sql = "SELECT m.Title, m.ID 
  	        FROM ms_j_songmovie j JOIN ms_movies m on m.ID = j.movieID
  	        WHERE j.songID = " . $f3->get('PARAMS.song');
  	$f3->set('result',$db->exec($sql));
  	if ($f3->get('result')) {
      foreach ($f3->get('result')  as $key => $value) {
        $song[0]['Movies'][$key] = $value;
      }
    }
	else {
		$song[0]['Movies'] =  array();
	}
    return $song;
  }
  
 public static function getShows($f3, $song, $db) {
  	$sql = "SELECT s.Title, s.ID 
  	        FROM ms_j_songshow j JOIN ms_shows s on s.ID = j.showID
  	        WHERE j.songID = " . $f3->get('PARAMS.song');
  	$f3->set('result',$db->exec($sql));
  	if ($f3->get('result')) {
      foreach ($f3->get('result')  as $key => $value) {
        $song[0]['Shows'][$key] = $value;
      }
    }
	else {
		$song[0]['Shows'] =  array();
	}
    return $song;
  }
 
 
  public static function getSongTitle($f3, $song, $db) {
 	$sql = "SELECT Title FROM  ms
 	        WHERE ID = " . $f3->get('PARAMS.song');
    $f3->set('result',$db->exec($sql));
    foreach ($f3->get('result')  as $key => $value) {
      $song['Title'] = $value['Title'];
	}
	return $song;
 }

  public static function hasSoundRecording($f3, $db) {
    $sql = "SELECT ID from md_sound
            WHERE songID = :song
            LIMIT 1";
    $f3->set('result', $db->exec($sql, array(":song" => $f3->get('PARAMS.song'))));
    $isRecording = ($f3->get('result'))? 'true' : 'false';
    return $isRecording;

  }
}
?>

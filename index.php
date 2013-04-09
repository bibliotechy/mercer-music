<?php

$f3 =  require('../fatfree/lib/base.php');
$f3->map('/songs/@song', 'Song');
$f3->map('/discography/@song', 'DiscographySong');
$f3->map('/movies/@movie', 'Movie');
$f3->map('/shows/@show', 'Show');
$f3->run();

class Api {
  public $song = array();	

  public function __construct() {
    $this->db = new DB\SQL(
      'mysql:host=localhost;port=3306;dbname=special_collections',
      'root', 'mysqlroot');
    }
}

class Song extends Api{
     
  public function get($f3) {
    $this->song = Song::buildFullJSON($f3, $this->song, $this->db);
    //return the data about the song as json
    echo json_encode($this->song);
  }

  public static function buildFullJSON($f3, $song, $db) {
    $song = Song::getSongBaseInfo($f3, $song, $db);
    $song = Song::getAlternateTitles($f3, $song, $db);
    $song = Song::getCitationsInfo($f3, $song, $db);
    $song = Song::getHoldingsInfo($f3, $song, $db);
    return $song; 
  }

  public static function getSongBaseInfo($f3, $song, $db) {
    $sql = "SELECT * FROM ms WHERE ID =" . $f3->get('PARAMS.song') . " AND Suppress <> 1";
    $f3->set('result',$db->exec($sql));
    foreach ($f3->get('result')  as $key => $value) {
      $song[$key] = $value ;
    }
    return $song;
   }

  public static function getAlternateTitles($f3, $song, $db) {
    $sql = "SELECT Title FROM ms_alt WHERE ParentID = " . $f3->get('PARAMS.song');
    $f3->set('result',$db->exec($sql));
    if ($f3->get('result')) {
      foreach ($f3->get('result')  as $key => $value) {
        $song['0']['AlternateTitles'][$key] = $value;
      }
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
        $song['0']['Citations'][$key] = $value;
      }
    }
    return $song;
  }

  public static function getHoldingsInfo($f3, $song, $db) {
    $sql = "SELECT h.name 
            FROM ms_holdings h 
            JOIN ms_j_songholding j ON j.holdingID = h.ID
            WHERE j.SongID =" . $f3->get('PARAMS.song');
    $f3->set('result',$db->exec($sql));
    if ($f3->get('result')) {
      foreach ($f3->get('result')  as $key => $value) {
        $song['0']['Holdings'][$key] = $value;
      }
    }
    return $song;
  }
 
 public static function getSongTitle($f3, $song, $db) {
 	$sql = "SELECT Title FROM  ms
 	        WHERE ID = " . $f3->get('PARAMS.song');
    $f3->set('result',$db->exec($sql));
    foreach ($f3->get('result')  as $key => $value) {
      $song['Title'] = $value['Title'] ;
	}
	return $song;
 }
 
}

class DiscographySong extends Api{
  
   public function get($f3) {
    $this->song = DiscographySong::buildFullJSON($f3, $this->song, $this->db);
    //return the data about the song as json
    echo json_encode($this->song);
  }

  public static function buildFullJSON($f3, $song, $db) {
    $song = DiscographySong::getRecordingsInfo($f3, $song, $db);
	foreach ($song['recordings'] as $recording){
      	if ($recording['songType'] != '1') {
          $song = DiscographySong::getSongTitle($f3, $song, $db);
		}
        else {
          $song = Song::getSongTitle($f3, $song, $db);
        }
		break;
	  }
	$song = DiscographySong::getHoldingsInfo($f3, $song, $db);
    return $song;
  }

  public static function getRecordingsInfo($f3, $song, $db) {
    $sql = "SELECT * FROM md_sound  
            WHERE songID = " . $f3->get('PARAMS.song') .
			" AND Suppress <> 1";
    $f3->set('result',$db->exec($sql));
    $song['recordings'] = array();
    foreach ($f3->get('result') as $key => $value ) {
      $song['recordings'][$value['ID']] = $value ;
		}
    return $song;
  }

  public static function getSongTitle($f3, $song, $db) {
  	$sql = "SELECT Title from md_song
  	        WHERE ID = " . $f3->get("PARAMS.song");
	$f3->set('result',$db->exec($sql));
	foreach ($f3->get('result')  as $key => $value) {
      $song['Title'] = $value['Title'];
	}
	return $song;
  }
  
  public static function getHoldingsInfo($f3, $song, $db) {
    $sql = "SELECT h.name, j.soundID 
            FROM md_sound_holdings h 
            JOIN md_sound_j_soundholding j ON j.holdingID = h.ID
            JOIN md_sound s ON s.ID = j.soundID
            WHERE s.songID =" . $f3->get('PARAMS.song');
    $f3->set('result',$db->exec($sql));
    if ($f3->get('result')) {
      foreach ($f3->get('result')  as $value) {
        $song['recordings'][$value['soundID']]['Holdings'][] = $value['name'];
      }
    }
    return $song;
  }
}

class Movie extends Api {
  public $movie = array();
  	
  public function get($f3) {
    $this->movie = Movie::buildFullJSON($f3, $this->movie, $this->db);
    //return the data about the song as json
    echo json_encode($this->movie);
  }
  
  public static function buildFullJSON($f3, $movie, $db) {
  	$movie = Movie::getMovieBaseInfo($f3, $movie, $db);
	$movie = Movie::getHoldingsInfo($f3, $movie, $db);
	$movie = Movie::getSongsInMovie($f3, $movie, $db);
    return $movie;
  }
  
  
  public static function getMovieBaseInfo($f3, $movie, $db) {
  	$sql = "SELECT * 
  	        FROM ms_movies 
  	        WHERE ID = " . $f3->get('PARAMS.movie');
	$f3->set('result',$db->exec($sql));
	foreach ($f3->get('result') as $key => $value) {
		$movie[$key] = $value;
	}
	return $movie;
  }
  
  public static function getHoldingsInfo($f3, $movie, $db) {
  	$sql = "SELECT h.Name 
  	        FROM ms_movies_holdings h 
  	        JOIN ms_j_movieholding j on j.holdingID = h.ID 
            WHERE  j.movieID = " . $f3->get('PARAMS.movie');
    $f3->set('result',$db->exec($sql));
	foreach ($f3->get('result') as $key => $value) {
		$movie['Holdings'][] = $value;
	}
	return $movie;
  }
  
  public static function getSongsInMovie($f3, $movie, $db) {
  	$sql = "SELECT s.ID, s.Title 
  	        FROM ms s 
  	        JOIN ms_j_songmovie j on s.ID = j.songID
  	        WHERE j.movieID = " . $f3->get('PARAMS.movie');
	$f3->set('result',$db->exec($sql));
	foreach ($f3->get('result') as $key => $value) {
		$movie['Songs'][] = $value;
	}
	return $movie;
  }
}

class Show extends Api {
  public $show = array();
  	
  public function get($f3) {
    $this->show = Show::buildFullJSON($f3, $this->show, $this->db);
    //return the data about the song as json
    echo json_encode($this->show);
  }
  
  public static function buildFullJSON($f3, $show, $db) {
  	$show = Show::getShowBaseInfo($f3, $show, $db);
	$show = Show::getHoldingsInfo($f3, $show, $db);
	$show = Show::getSongsInShow($f3, $show, $db);
    return $show;
  }
  
  
  public static function getShowBaseInfo($f3, $show, $db) {
  	$sql = "SELECT * 
  	        FROM ms_shows 
  	        WHERE ID = " . $f3->get('PARAMS.show');
	$f3->set('result',$db->exec($sql));
	foreach ($f3->get('result') as $key => $value) {
		$show[] = $value;
	}
	return $show;
  }
  
  public static function getHoldingsInfo($f3, $show, $db) {
  	$sql = "SELECT h.Name 
  	        FROM ms_shows_holdings h 
  	        JOIN ms_j_showholding j on j.holdingID = h.ID 
            WHERE  j.showID = " . $f3->get('PARAMS.show');
    $f3->set('result',$db->exec($sql));
	foreach ($f3->get('result') as $key => $value) {
		$show['Holdings'][] = $value;
	}
	return $show;
  }
  
  public static function getSongsInShow($f3, $show, $db) {
  	$sql = "SELECT s.ID, s.Title 
  	        FROM ms s 
  	        JOIN ms_j_songshow j on s.ID = j.songID
  	        WHERE j.showID = " . $f3->get('PARAMS.show');
	$f3->set('result',$db->exec($sql));
	foreach ($f3->get('result') as $key => $value) {
		$show['Songs'][] = $value;
	}
	return $show;
  }
}


?>


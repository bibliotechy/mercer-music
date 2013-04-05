<?php

class Api {


}

class Song extends Api{
  
  public $song = array();
  
  public function get($f3) {
    $this->db=new DB\SQL(
      'mysql:host=localhost;port=3306;dbname=special_collections',
      'root', 'mysqlroot');

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

}

class DiscographySong {

  public $song = array();
  
  public function get($f3) {
    $this->db=new DB\SQL(
      'mysql:host=localhost;port=3306;dbname=special_collections',
      'root', 'mysqlroot');

    $this->song = DiscographySong::buildFullJSON($f3, $this->song, $this->db);

    //return the data about the song as json
    echo json_encode($this->song);
  }


  public static function buildFullJSON($f3, $song, $db) {
    $song = DiscographySong::getBaseSongInfo($f3, $song, $db);
    return $song;
  } 

  public static function getBaseSongInfo($f3, $song, $db) {
    $sql = "SELECT * FROM md_sound 
            WHERE ID = " . $f3->get('PARAMS.song');
    $f3->set('result',$db->exec($sql));
    foreach ($f3->get('result')  as $key => $value) {
      $song[$key] = $value ;
    }
    return $song;
  }
}

$f3 =  require('../fatfree/lib/base.php');
$f3->map('/songs/@song', 'Song');
$f3->map('/discography/@song', 'DiscographySong');
$f3->run();



?>


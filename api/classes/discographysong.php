<?php 

class DiscographySong extends Api{
  
  public static function buildResultArray($f3, $song, $db) {
    $song = DiscographySong::getRecordingsInfo($f3, $song, $db);
    $recording = reset($song['recordings']);
    if ($recording["songType"] != "1") {
      $song = DiscographySong::getSongTitle($f3, $song, $db);
	}
    else {
      $song = Song::getSongTitle($f3, $song, $db);
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

?>

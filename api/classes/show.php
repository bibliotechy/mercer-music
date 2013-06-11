<?php

class Show extends Api {
 
  public static function buildResultArray($f3, $show, $db) {
  	$show = Show::getShowBaseInfo($f3, $show, $db);
	$show = Show::getHoldingsInfo($f3, $show, $db);
	$show = Show::getSongsInShow($f3, $show, $db);
    return $show;
  }
  
  public static function getShowBaseInfo($f3, $show, $db) {
  	$sql = "SELECT * 
  	        FROM ms_shows 
  	        WHERE ID =?";
	$f3->set('result',$db->exec($sql, $f3->get('PARAMS.show')));
	foreach ($f3->get('result') as $key => $value) {
		$show[] = $value;
	}
	return $show;
  }
  
  public static function getHoldingsInfo($f3, $show, $db) {
  	$sql = "SELECT h.Name 
  	        FROM ms_shows_holdings h 
  	        JOIN ms_j_showholding j on j.holdingID = h.ID 
            WHERE  j.showID =?";
    $f3->set('result',$db->exec($sql, $f3->get('PARAMS.show')));
    if ($f3->get('result')) {
      foreach ($f3->get('result') as $key => $value) {
	    $show[0]['Holdings'][] = $value;
     }
    }
    else {
      $show[0]['Holdings'] = array();
    }



	return $show;
  }
  
  public static function getSongsInShow($f3, $show, $db) {
  	$sql = "SELECT s.ID, s.Title 
  	        FROM ms s 
  	        JOIN ms_j_songshow j on s.ID = j.songID
  	        WHERE j.showID =?";
	$f3->set('result',$db->exec($sql,  $f3->get('PARAMS.show')));
    if ($f3->get('result')) {
      foreach ($f3->get('result') as $key => $value) {
		$show[0]['Songs'][] = $value;
      }
    }
    else {
      $show[0]['Songs'] = array();
    }
	return $show;
  }
}
?>

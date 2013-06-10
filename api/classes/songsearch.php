<?php

class SongSearch extends Api {
	
	public static function buildResultArray($f3, $result, $db) {
		$result = SongSearch::getBaseSearchResults($f3, $result, $db);
		return $result;
	}

    public static function getBaseSearchResults($f3, $result, $db) {
    	
		$query = $db->quote('%' . $f3->get('PARAMS.query') . '%');	
    	$sql = "SELECT ID, Title, Copyright, Lyricist, Composer, Published, Awards, Notes 
    	        FROM ms 
    	        WHERE (Title LIKE $query 
				      OR Composer LIKE $query
              OR Lyricist LIKE $query
              OR Awards LIKE $query
              OR Notes LIKE $query
              OR Copyright LIKE $query)
              AND Suppress != 1
              ORDER BY Title";
		$f3->set('result', $db->exec($sql));
		foreach ($f3->get('result') as $key => $value) {
			$result[] = $value;
		}
		return $result;
    }	 
}

?>

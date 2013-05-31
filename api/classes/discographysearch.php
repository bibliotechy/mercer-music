<?php

class DiscographySearch extends Api {
	
	public static function buildResultArray($f3, $result, $db) {
		$result = DiscographySearch::getBaseSearchResults($f3, $result, $db);
		return $result;
	}

    public static function getBaseSearchResults($f3, $result, $db) {
    	
		$query = mysql_real_escape_string($f3->get('PARAMS.query'));	
    	$sql = "SELECT s.ID, s.Title
    	        FROM ms s JOIN md_sound d on s.ID = d.songID 
    	        WHERE (Title LIKE '%" . $query . "%' 
				OR Composer LIKE '%" . $query . "%'
				OR Lyricist LIKE '%" . $query . "%')
				AND d.songType = 1
		        AND s.Suppress <> 1
		        UNION
		        SELECT g.ID, g.Title
		        FROM md_song g
		        JOIN md_sound d on g.ID = d.songID
		        WHERE (g.Title LIKE '%" . $query . "%' 
				OR d.Composers LIKE '%" . $query . "%'
				OR d.Performers LIKE '%" . $query . "%'
				OR d.AlbumTitle LIKE '%" . $query . "%')
		        AND d.songType = 0
		        AND Suppress <> 1";
		
		$f3->set('result', $db->exec($sql));
		foreach ($f3->get('result') as $key => $value) {
			$result[] = $value;
		}
		return $result;
    }	 
}
?>
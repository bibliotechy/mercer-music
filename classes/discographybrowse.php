<?php
 
 Class DiscographyBrowse extends Api {
	
	public static function buildResultArray($f3, $result, $db) {
		$result = DiscographyBrowse::getBaseBrowseResults($f3, $result, $db);
		return $result;
	}

    public static function getBaseBrowseResults($f3, $result, $db) {
    	
		$query = mysql_real_escape_string($f3->get('PARAMS.letter'));
		$sql = "SELECT ID,Title
    	        FROM ms
    	        WHERE (Title LIKE '" . $query . "%'
				OR Title LIKE 'The" . $query . "%')
				AND Suppress <> 1
				UNION
				SELECT ID, Title
				FROM md_song
				WHERE (Title LIKE '" . $query . "%'
				OR Title LIKE 'The" . $query . "%')";
        $f3->set('result', $db->exec($sql));
		foreach ($f3->get('result') as $key => $value) {
			$result[] = $value;
		}
		return $result;
	}
}
 
?>
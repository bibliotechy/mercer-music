<?php
 
class BrowseAllDiscography extends Api {
	
	public static function buildResultArray($f3, $result, $db) {
		$result = BrowseAllDiscography::getBaseBrowseResults($f3, $result, $db);
		return $result;
	}

    public static function getBaseBrowseResults($f3, $result, $db) {
    	
		$query = mysql_real_escape_string($f3->get('PARAMS.letter'));
		$sql = "SELECT ID,Title
    	        FROM ms
    	        WHERE Suppress <> 1
				UNION
				SELECT ID, Title
				FROM md_song
				WHERE 1";
        $f3->set('result', $db->exec($sql));
		foreach ($f3->get('result') as $key => $value) {
			$result[] = $value;
		}
		return $result;
	}
}
 
?>
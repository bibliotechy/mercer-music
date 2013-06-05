<?php
    
Class BrowseAllSongs extends Api {
	
	public static function buildResultArray($f3, $result, $db) {
		$result = BrowseAllSongs::getBaseBrowseResults($f3, $result, $db);
		return $result;
	}

    public static function getBaseBrowseResults($f3, $result, $db) {
    	
		$query = $db->quote($f3->get('PARAMS.letter'));
		$sql = "SELECT ID 
    	        FROM ms
    	        WHERE Suppress <> 1";
        $f3->set('result', $db->exec($sql));
		foreach ($f3->get('result') as $key => $value) {
			$result[] = $value;
		}
		return $result;
	}
}
?>

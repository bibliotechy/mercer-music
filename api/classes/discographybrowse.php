<?php
 
 Class DiscographyBrowse extends Api {
	
	public static function buildResultArray($f3, $result, $db) {
		$result = DiscographyBrowse::getBaseBrowseResults($f3, $result, $db);
		return $result;
	}

    public static function getBaseBrowseResults($f3, $result, $db) {
    	
      $letter = $db->quote($f3->get('PARAMS.letter') . "%");
      $theletter = $db->quote("The " . $f3->get('PARAMS.letter') . "%");
		  $sql = "(SELECT s.ID,s.Title
            FROM ms s JOIN md_sound d on s.ID = d.songID 
    	      WHERE (Title LIKE $letter
            OR Title LIKE $theletter)
            AND d.songType = 1
				    AND d.Suppress != 1)
				    UNION
				    (SELECT g.ID, g.Title
				    FROM md_song g JOIN  md_sound d on g.ID = d.songID
				    WHERE (Title LIKE $letter
            OR Title LIKE $theletter)
            AND d.songType = 0
            AND d.Suppress != 1)
            ORDER BY Title";
    $f3->set('result', $db->exec($sql));
		foreach ($f3->get('result') as $key => $value) {
			$result[] = $value;
		}
		return $result;
	}
}
 
?>

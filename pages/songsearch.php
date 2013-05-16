<?php

class SongSearch extends Page{
	
	public function renderPage($f3) {
		$data = $this->getData($f3);
		$f3->set('header', 'templates/songHeader.htm');
	    $f3->set('content','templates/songsearch.htm');
		echo $this->template->render($this->base);
		
	}	
}

?>
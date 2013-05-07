<?php

class Song extends Page {
	
	function renderPage($f3) {
		$this->path = '/m2/api/songs/' . $f3->get('PARAMS.song');
		$data = $this->getData();
    	$f3->set('data', $data[0]);
    	$f3->set('header', 'templates/songHeader.htm');
    	$f3->set('content','templates/song.htm');
		echo $this->template->render($this->base);
	}
	
}

?>
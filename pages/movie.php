<?php

class Movie extends Page {

	public function renderPage($f3) {
			$this->path = '/m2/api/movies/' . $f3->get('PARAMS.movie');
			$data = $this->getData();
	    	$f3->set('data', $data[0]);
	    	$f3->set('header', 'templates/songHeader.htm');
	    	$f3->set('content','templates/movie.htm');
			echo $this->template->render($this->base);
	}
}
?>
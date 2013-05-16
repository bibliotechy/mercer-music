<?php

class Single extends Page {
	
	public function renderPage($f3) {
		$this->data = $this->getData($f3);
		if (in_array($f3->get('PARAMS.type'), array('song', 'movie', 'show'))) {
			$this->songdbRender($f3);
		}
		else {
			$this->discographyRender($f3);
		}
		$f3->set('content','templates/' . $f3->get('PARAMS.type') . '.htm');
		echo $this->template->render($this->base);	
	}
	
	private function songdbRender($f3) {
	    $f3->set('data', $this->data[0]);
	    $f3->set('header', 'templates/songHeader.htm');
	}
	
	private function discographyRender($f3) {
		$f3->set('data', $this->data);
		$f3->set('header','templates/discographyHeader.htm');
	}
}

?>
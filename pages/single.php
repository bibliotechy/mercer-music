<?php

class Single extends Page {
	
	public function renderPage($f3) {
		$this->setHeader($f3);
		$f3->set('content','templates/' . $f3->get('PARAMS.type') . '.htm');
		$this->data = $this->getData($f3);
		$this->setData($f3);
		echo $this->template->render($this->base);	
	}
	
	public function setHeader($f3) {
		if (in_array($f3->get('PARAMS.type'), array('song', 'movie', 'show'))) {
			$this->songdbHeader($f3);
		}
		else if ($f3->get('PARAMS.type' == 'discography')){
			$this->discographyHeader($f3);
		}
		else {
			//raise a 404
		}
	}
	
	private function songdbHeader($f3) {
	    $f3->set('header', 'templates/songHeader.htm');
	}
	
	private function discographyHeader($f3) {
		
		$f3->set('header','templates/discographyHeader.htm');
	}

	public function setData($f3) {
		if (in_array($f3->get('PARAMS.type'), array('song', 'movie', 'show'))) {
			$this->setSongdbData($f3);
		}
		else {
			$this->setDiscographyData($f3);
		}
	}
		
	private function setSongdbData($f3) {
		$f3->set('data', $this->data[0]);
	}
	
	private function setDiscographyData($f3) {
		$f3->set('data', $this->data);
	}
	
	public function getPath($f3) {
		$this->path = $f3->get('apiPath') . "/" . $f3->get('PARAMS.type') . "/" . $f3->get('PARAMS.query');
		//print $this->path;
		return $this->path;
	}

}

?>
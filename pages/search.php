<?php

class Search extends Page {
	
	public function renderPage($f3) {
		$this->setHeader($f3);
		$f3->set('content','templates/' . $f3->get('PARAMS.type') . 'Search.htm');
		$data = $this->getData($f3);
		$f3->set('data', $data);
        echo $this->template->render($this->base);		
	}
	
	public function getPath($f3) {
		$this->path = $f3->get('apiPath') . "/" . $f3->get('PARAMS.type'); 
		$this->path .= "/search/" . $f3->get('PARAMS.query');
		return $this->path;
	}
	
	public function setHeader($f3) {
		if ($f3->get('PARAMS.type') == 'song') {
			$f3->set('header', 'templates/songHeader.htm');
		}
		else if ($f3->get('PARAMS.type') == 'discography') {
			$f3->set('header', 'templates/discographyHeader.htm');
		}
		else {
			//raise a 404
		}	
	}
	
}

?>
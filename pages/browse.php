<?php

class Browse extends Page {
	
	public function renderPage($f3) {
		$this->setHeader($f3);
		$f3->set('content','templates/' . $f3->get('PARAMS.type') . 'Browse.htm');
		$data = $this->getData($f3);
		$f3->set('data', $data);
    echo $this->template->render($this->base);		
	}
	
	public function getPath($f3) {
		$this->path = $f3->get('apiPath') . "/" . $f3->get('PARAMS.type') . "/browse"; 
		$this->path .= ($f3->get('PARAMS.query') != null )? '/' . $f3->get('PARAMS.query') : '';
		return $this->path;
	}
	
	public function setHeader($f3) {
		if (in_array($f3->get('PARAMS.type'), array('song','movie','show'))) {
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

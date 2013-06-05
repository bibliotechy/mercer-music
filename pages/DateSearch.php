<?php

class DateSearch extends Page {
	
	public function renderPage($f3) {
		$this->setHeader($f3);
		$f3->set('content','templates/' . $f3->get('PARAMS.type') . 'Search.htm');
		$data = $this->getData($f3);
		$f3->set('data', $data);
        echo $this->template->render($this->base);		
	}
	
	public function getPath($f3) {
		$this->path = $f3->get('apiPath') . "/" . $f3->get('PARAMS.type'); 
		$this->path .= '/search/' . urlencode($f3->get('PARAMS.query')) . '/';
		$this->path .= $f3->get('PARAMS.fromMonth') . '/' . $f3->get('PARAMS.fromYear') . '/';
		$this->path .=  $f3->get('PARAMS.toMonth') . '/' . $f3->get('PARAMS.toYear');
		return $this->path;
	}
}

?>

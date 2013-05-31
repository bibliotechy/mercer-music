<?php

class Landing extends Page {
	
	public function renderPage($f3) {
		$this->setHeader($f3);
		$f3->set('content','templates/' . $f3->get('PARAMS.type') . 'Landing.htm');
        echo $this->template->render($this->base);		
	}	
	
}

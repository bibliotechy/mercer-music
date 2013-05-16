<?php

class Single extends Page {
	
		public function renderPage($f3) {
		$data =  $this->getData($f3);
	    $f3->set('data', $data[0]);
	    $f3->set('header', $this->getHeader($f3));
	    $f3->set('content','templates/' . $f3->get('PARAMS.type') . '.htm');
		echo $this->template->render($this->base);
	}
	
	private function getHeader($f3) {
		if ($f3->get('PARAMS.type') == ('song' || 'movie' || 'show')) {
			return 'templates/songHeader.htm';
		}
		
	}
	
}

?>
<?php

class Page {
	
	public function __construct() {
		$this->web = new Web();
		$this->template = new Template();
		$this->base = "templates/base.htm";
	} 
    
	public function getData($f3) {
		$path = (isset($this->path))? $this->path : $this->getPath($f3);
		$request = $this->web->request($path);
		//print $request['body'];
		return json_decode($request['body']);
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

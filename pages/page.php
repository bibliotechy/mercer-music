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
		print $request['body'];
		return json_decode($request['body']);
	}
	
	public function getPath($f3) {
		$this->path = $f3->get('apiPath') . "/" . $f3->get('PARAMS.type') . "/" . $f3->get('PARAMS.query');
		print $this->path;
		return $this->path;
	}
	
}

?>
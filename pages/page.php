<?php

class Page {
	public function __construct() {
		$this->web = new Web();
		$this->template = new Template();
		$this->base = "templates/base.htm";
	} 
    
	public function getData() {
		$request = $this->web->request($this->path);
		return json_decode($request['body']);
	}
}

?>
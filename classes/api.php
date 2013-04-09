<?php
class Api {
  public $song = array();	

  public function __construct() {
    $this->db = new DB\SQL(
      'mysql:host=localhost;port=3306;dbname=special_collections',
      'root', 'mysqlroot');
    }
}

?>

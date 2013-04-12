<?php
class Api {
	
  public function __construct() {
  	// DB connection to be used by all extening classes
    $this->db = new DB\SQL(
      'mysql:host=localhost;port=3306;dbname=special_collections',
      'root', 'mysqlroot');
	// placeholder that is extended by buildFullJSON
	$this->result = array();	
    }

  /*
   * Function that responds to get requests of each $f3->map() in root index.php
   * see: https://github.com/bcosca/fatfree#representational-state-transfer-rest
   * Each extending class uses this, with class name for callin static function
   * determined at runtime. 
   */
  public function get($f3) {
    $name = get_called_class();
    $this->result = $name::buildFullJSON($f3, $this->result, $this->db);
    //since we are sening JSON, let's do it right.
    header('Content-type: application/json');
    //return the data as JSON
    echo json_encode($this->result);
  }
}

?>

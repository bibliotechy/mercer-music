<?php

// load the base f3 library
$f3 =  require('lib/base.php');

//lazy load the classes in the classes directory as needed
$f3->set('AUTOLOAD', 'pages/');


$f3->set('root', '/m2');
$f3->set('apiPath', "/m2/api");


// Soung and Discography Browse by Letter
$f3->route('/GET /@type/browse/@query', 'Browse->renderPage');

$f3->route('/GET /@type/browse','Browse->renderPage');

$f3->route('/POST /@type/search/@query', 'Search->renderPage');

//Routing for Single song /  movie / show
$f3->route('/GET /@type/@query', 'Single->renderPage');




$f3->run();

?>


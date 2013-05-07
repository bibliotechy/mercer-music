<?php

// load the base f3 library
$f3 =  require('lib/base.php');

//lazy load the classes in the classes directory as needed
$f3->set('AUTOLOAD', 'pages/');
$f3->set('root', '/m2');

// set the routes and functions to call  
$f3->route('/GET /songs', 
  function($f3) {
    $f3->set('header','templates/songHeader.htm');
    $f3->set('content', '');
    $template = new Template();
    echo $template->render('templates/base.htm');
  });

$f3->route('/GET /songs/@song', 'Song->renderPage');

$f3->route('/GET /movies/@movie', 'Movie->renderPage');

$f3->run();

?>


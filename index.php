<?php

// load the base f3 library
$f3 =  require('../fatfree/lib/base.php');

//lazy load the classes in the classes directory as needed
$f3->set('AUTOLOAD', 'classes/');

// set up routing for API to each type of information
$f3->map('/songs/@song', 'Song');
$f3->map('/discography/@song', 'DiscographySong');
$f3->map('/movies/@movie', 'Movie');
$f3->map('/shows/@show', 'Show');
$f3->run();

?>


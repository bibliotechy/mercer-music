<?php

// load the base f3 library
$f3 =  require('../lib/base.php');

//lazy load the classes in the classes directory as needed
$f3->set('AUTOLOAD', 'classes/');

// set the routes and functions to call  
$f3->route('/GET /song/search/@query', 'SongSearch->get');
$f3->route('/GET /song/browse/@letter', 'SongBrowse->get');
$f3->route('/GET /song', 'BrowseAllSongs->get');
$f3->map('/song/@song', 'Song');

$f3->route('/GET /discography/search/@query', 'DiscographySearch->get');
$f3->route('/GET /discography/browse/@letter', 'DiscographyBrowse->get');
$f3->route('/GET /discography', 'BrowseAllDiscography->get');
$f3->map('/discography/@song', 'DiscographySong');

$f3->route('/GET /movie/browse', 'BrowseAllMovies->get');
$f3->map('/movie/@movie', 'Movie');

$f3->route('/GET /show/browse', 'BrowseAllShows->get');
$f3->map('/show/@show', 'Show');

$f3->map('/test/@song', 'MyTest');

$f3->run();

?>


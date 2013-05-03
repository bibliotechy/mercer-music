<?php

// load the base f3 library
$f3 =  require('lib/base.php');

//lazy load the classes in the classes directory as needed
$f3->set('AUTOLOAD', 'pages/');

// set the routes and functions to call  
$f3->route('/GET /songs/search/@query', 'SongSearch->get');
$f3->route('/GET /songs/browse/@letter', 'SongBrowse->get');
$f3->route('/GET /songs', 'BrowseAllSongs->get');
$f3->map('/songs/@song', 'Song');

$f3->route('/GET /discography/search/@query', 'DiscographySearch->get');
$f3->route('/GET /discography/browse/@letter', 'DiscographyBrowse->get');
$f3->route('/GET /discography', 'BrowseAllDiscography->get');
$f3->map('/discography/@song', 'DiscographySong');

$f3->route('/GET /movies', 'BrowseAllMovies->get');
$f3->map('/movies/@movie', 'Movie');

$f3->route('/GET /shows', 'BrowseAllShows->get');
$f3->map('/shows/@show', 'Show');

$f3->map('/test/@song', 'MyTest');

$f3->run();

?>


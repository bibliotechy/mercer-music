<?php

// load the base f3 library
$f3 =  require('../fatfree/lib/base.php');

//lazy load the classes in the classes directory as needed
$f3->set('AUTOLOAD', 'classes/');

// set the routes and functions to call  
$f3->route('/GET /api/songs/search/@query', 'SongSearch->get');
$f3->route('/GET /api/songs/browse/@letter', 'SongBrowse->get');
$f3->route('/GET /api/songs/all', 'BrowseAllSongs->get');
$f3->map('/api/songs/@song', 'Song');

$f3->route('/GET /api/discography/search/@query', 'DiscographySearch->get');
$f3->route('/GET /api/discography/browse/@letter', 'DiscographyBrowse->get');
$f3->map('/api/discography/@song', 'DiscographySong');

$f3->route('/GET /api/movies/all', 'BrowseAllMovies->get');
$f3->map('/api/movies/@movie', 'Movie');

$f3->route('/GET /api/shows/all', 'BrowseAllShows->get');
$f3->map('/api/shows/@show', 'Show');


$f3->run();

?>


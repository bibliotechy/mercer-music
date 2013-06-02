<?php

// load the base f3 library
$f3 =  require('lib/base.php');

//lazy load the classes in the classes directory as needed
$f3->set('AUTOLOAD', 'pages/');


$f3->set('root', '/m2');
$f3->set('apiPath', "/m2/api");


$f3->route('/GET /@type', 'Landing->renderPage');

// Soung and Discography Browse by Letter
$f3->route('/GET /@type/browse/@query', 'Browse->renderPage');

$f3->route('/GET /@type/browse','Browse->renderPage');

// redirect for search, to allow bookmarking searches with pretty urls.
// essentially just redirects to next routing function below.

$f3->route('GET /@type/search?q=@query*', 
		function($f3) {
			if ($_GET['fy'] != "00" || $_GET['ty'] != "00"){
				$dest = '/' . $f3->get('PARAMS.type') . '/search/' . $_GET['q'];
				$dest .= '/from/'. $_GET['fm'] . '/' . $_GET['fy'] . '/to/' . $_GET['tm'] . '/' . $_GET['ty'];
				$f3->reroute($dest);
			}
			else {
				$dest = '/' . $f3->get('PARAMS.type') . '/search/' . $_GET['q'];
				$f3->reroute($dest);	
			}
		});

$f3->route('/GET /@type/search/@query', 'Search->renderPage');

$f3->route('/GET /@type/search/@query/from/@fromMonth/@fromYear/to/@toMonth/@toYear' , 'DateSearch->renderPage');

//Routing for Single song /  movie / show / Discography
$f3->route('/GET /@type/@query', 'Single->renderPage');




$f3->run();

?>


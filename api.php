<?php

use App\App;

require_once __DIR__ . '/vendor/autoload.php';

// TODO A: Improve the readability of this file through refactoring and documentation.
// TODO B: Clean up the following code so that it's easier to see the different
// routes and handlers for the API, and simpler to add new ones.
// TODO C: If there are performance concerns in the current code, please
// add comments on how you would fix them
// TODO D: Identify any potential security vulnerabilities in this code.
// TODO E: Document this code to make it more understandable
// for other developers.

header( 'Content-Type: application/json' );

//get title and prefixSearch variables from request
$title = $_GET['title'];
$prefixSearch = $_GET['prefixsearch'];
// ^^ security vulnrability - we would need to sterilize user input before passing to any function in the
// app so that if these variables were used in a database qurey, a bad actor could not
// perform an sql injection attack34we

/**
 * Gets article contents when given an article title and prefix search
 *
 * @param String $title - title of article
 * @param String $prefixSearch -
 */
function getArticleContent($title, $prefixSearch){
	$app = new App();
	//If not title and prefix get all articles
	if ( !isset($title ) && !isset($prefixSearch) ) {
		return $app->getListOfArticles();
	} elseif ( isset( $prefixSearch) ) {
		$articles = $app->getListOfArticles();
		// filter artciles that match request prefix
		$prefix = strtolower($prefixSearch);
		return array_filter($articles, function($article) use ($prefix){
			$article = strtolower($article);
			//^^ strtolower is being called for each article
			return strpos($article, $prefix === 0);
		});
	} else {
		return $app->fetch( $_GET );
	}
}

getArticleContent($title, $prefixSearch);
$content = getArticleContent($title, $prefixSearchß);
echo json_encode([ 'content' => $content ]);


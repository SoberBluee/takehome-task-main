<?php

// TODO A: Improve the readability of this file through refactoring and documentation.
// TODO B: Review the HTML structure and make sure that it is valid and contains
// required elements. Edit and re-organize the HTML as needed.
// TODO C: Review the index.php entrypoint for security and performance concerns
// and provide fixes. Note any issues you don't have time to fix.
// TODO D: The list of available articles is hardcoded. Add code to get a
// dynamically generated list.
// TODO E: Are there performance problems with the word count function? How
// could you optimize this to perform well with large amounts of data? Code
// comments / psuedo-code welcome.
// TODO F (optional): Implement a unit test that operates on part of App.php

	use App\App;

	require_once __DIR__ . '/vendor/autoload.php';

	$app = new App();

	$title = '';
	$body = '';
	if ( isset( $_GET['title'] ) ) {
		$title = htmlentities( $_GET['title'] );
		$body = $app->fetch( $_GET );
		$body = file_get_contents("articles/{$title}");
	}
?>

<head>
	<link rel='stylesheet' href='http://design.wikimedia.org/style-guide/css/build/wmui-style-guide.min.css'>
	<link rel='stylesheet' href='styles.css'>
	<script src='main.js'></script>
</head>

<?php
	$wordCount = getWordCount('articles/');

	if ( $_POST ) {
		$app->save( "articles/{$_POST['title']}", $_POST['body'] );
	}

	/**
	 * Get the word count of all files from a given path
	 *
	 * @param String $path - path of the directory you want a word count from
	 * @return string - word count string
	 */
	function getWordCount($path): string{
		$wordCount = 0;
		// global $wgBaseArticlePath;
		// $wgBaseArticlePath = 'articles/';
		// ^^ you shouldn't define and modify global variables within a function
		// as this break encapusulation

		$dir = new DirectoryIterator( $path );
		foreach ( $dir as $fileinfo ) {
			if ( $fileinfo->isDot() ) continue;

			$contents = file_get_contents( $path . $fileinfo->getFilename() );
			if( !$contents ) continue;
			// $characters = explode( " ", $contents );
			// $wordCount += count( $characters );
			// ^^ you don't need to split and run a count on an array to count words in a string
			// you can instead use str_word_count($content) to count the number of words in a string
			// also if there is no data in $contents then it will still be attempting to run these functions
			// when its unnecessary
			// Also doing the above could also give an inaccurate results for some strings
			$wordCount += str_word_count($contents);
		}
		return "$wordCount words written";
	}
?>
<body>
	<div id=header class=header>
		<a href='/'>Article editor</a><div><?php echo $wordCount?></div>
	</div>
	<div class='page'>
		<div class="container">
			<h2 class="title">Create/Edit Article</h2>
			<p class="description">Create a new article by filling out the fields below. Edit an article by typing the beginning of the title in the title field, selecting the title from the auto-complete list, and changing the text in the textfield.</p>
			<form action='index.php' method='post'>
				<input
					class='input-control'
					name='title'
					type='text'
					placeholder='Article title...'
					value="<?php echo $title ?>"
				/>

				<textarea
					class='input-control'
					name='body'
					placeholder='Article body...'
				><?php echo $body ?></textarea>

				<button class='submit-button' type="submit"/>Submit</button>

				<h2 class="title">Preview</h2>
				<?php echo $title ?>
				<?php echo $body ?>

				<h2 class="title">Articles</h2>
				<ul>
					<li>
						<a href='index.php?title=Foo'>Foo</a>
					</li>
				</ul>
			</form>
		</div>
	</div>
</body>


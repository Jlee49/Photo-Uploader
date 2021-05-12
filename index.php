<?php
/**The application's function file and configuration settings files are required**/
	require_once dirname(__FILE__).'/includes/functions.php';
	require_once dirname(__FILE__).'/includes/config.php';
	require_once dirname(__FILE__).'/includes/connector.php';
	require_once dirname(__FILE__).'/lang/' . $config['language'] . '.php';
	
	$pageContent = '';
	$page_heading = 'PhotoUploader and Viewer';

	
/**Different views of the application can be called using the switch statement. This allows for a single point of entry**/
	if (!isset($_GET['page'])) {
		$page = 'home'; // display home page
	} else {
		$page = $_GET['page']; // else requested page
	}
	switch ($page) {
		case 'home' :
			include 'views/home.php';
			break;
		case 'upload' :
			include 'views/upload.php';
			break;
		case 'image':
			include 'views/image.php';
			break;
		default :
		include 'views/404.php';
	}

	$page_title = 'w1FMA';



/**Contents of the page.html is taken and the next few lines replace appropriate headings, title and content to display
the correct content on the correct view**/
$content = file_get_contents('templates/page.html');
$content = str_replace('[+page_title+]', $page_title, $content);
$content = str_replace('[+page_heading+]', $page_heading, $content);
$content = str_replace('[+content+]', $pageContent, $content);

/**The page is echoed or displayed*/
echo $content;
?>


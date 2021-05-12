<?php
	require_once dirname (dirname(__FILE__) ).'/includes/connector.php';
//Home view with simple content
	$pageContent .= '<h2>' . $lang['homepage_heading'] .'</h2>';
	$result = getDetails($link);
	if ($result === false) {
		echo mysqli_error($link);
	} 
	else{
		while ($row = mysqli_fetch_assoc($result)) {
			$pageContent.= '<div><a href="index.php?page=image&id='.htmlentities($row['id']) .'">
							<img src="'.htmlentities($row['thumb_url']).'">'
							. htmlentities($row['title']).
							'</div>';
				}

	mysqli_free_result($result);
	}
?>
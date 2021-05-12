<?php
	//required files are included
	require_once dirname (dirname(__FILE__) ).'/includes/functions.php';
	require_once dirname (dirname(__FILE__) ).'/includes/connector.php';
	//Empty variable which is used to add strings to
	$pageContent = '';
	
	//If there is a name set for page and id is set... shown in the url such as ?page=image&id=1
	if (isset($_GET['page']) && (isset($_GET['id']))){
		//ID is retrieved
		$currentID= $_GET['id'];
		//Since getNumberOfImages() function returns an array, I convert it into a single string
		$numberOfImages = implode(' ', getNumberOfImages($link));
		if ($currentID > $numberOfImages){
			//If the ID in the url is greater than the maximum ID in the database, it means it shouldnt exist
			//Therefore 404.php will be displayed
			include 'views/404.php';
		}
		else{
			//Otherwise , query is made to retrieve the wanted data and display it
			$result = getDetails($link);
			if ($result === false) {
				echo mysqli_error($link);
			} 
			else{
				while ($row = mysqli_fetch_assoc($result)) {
					//Checking which id is required. When it is found it will show details for that ID
					if (htmlentities($row['id'] == $currentID)){
					$pageContent.= '<div><a href="index.php">
									<img src="'.htmlentities($row['img_url']).'"><br>
									Image ID('. htmlentities($row['id']) .') : '
									. htmlentities($row['title']).
									'<br>'. htmlentities($row['desc']) .
									'</div>';
					}
				}

			mysqli_free_result($result);
			}
		}
	}
?>
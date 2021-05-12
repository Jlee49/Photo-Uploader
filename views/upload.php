<?php
	require_once dirname (dirname(__FILE__) ).'/includes/functions.php';
	require_once dirname (dirname(__FILE__) ).'/includes/connector.php';
	require_once dirname (dirname(__FILE__) ).'/lang/' . $config['language'] . '.php';
/**A line from en.php is used to **/
	$pageContent .= '<h2>'. $lang['upload_heading'].'</h2>';
	$title = '';
	$description = '';
	$error=false;
	//Checks if form has been submitted
	if (isset($_POST['imgUpload'])) {
		//Checking fields
		$title = trim($_POST["imgTitle"]);
		$description = trim($_POST["imgDescription"]);
		
		//If title is not filled out, variable becomes empty and the field becomes empty,
		//otherwise it will remain as the value in the field
		if (!checkField($title)){
			echo'Title must be filled out<br>';
			$title = '';
			$error = true;
		}

		//If description is not filled out, variable becomes empty and the field becomes empty,
		//otherwise it will remain as the value in the field
		if (!checkField($description)){
			echo'Description must be filled out<br>';
			$description = '';
			$error = true;
		}
		//If form has been submitted, check the file is a jpg/jpeg
		if ((substr($_FILES['userfile']['name'] , -4) != ".jpg") && (substr($_FILES['userfile']['name'] , -4) != ".JPG")){
			echo "Files must end with .jpg or .JPG";
		}
		else if ($_FILES['userfile']['type'] != "image/jpeg") {
			echo "Only jpeg can be uploaded";
		}
		else if (is_uploaded_file($_FILES['userfile']['tmp_name']) && $error == false) {
			$updir = dirname (dirname(__FILE__) ).'/uploads/';
			$upfilename = basename($_FILES['userfile']['name']);
			$newname = $updir . $upfilename;
			$tmpname = $_FILES['userfile']['tmp_name'];
		
			if (file_exists($newname)) {
				echo "File already exists - not uploaded again";
				$error = true;
			} else {
			
				if (move_uploaded_file($tmpname, $newname) && $error == false) {
					echo 'Image uploaded successfully';
					$img_Title = htmlentities($_POST["imgTitle"]);
					$description = htmlentities($_POST["imgDescription"]);
					//Calls a function that converts the uploaded img to the correct size and saving in to a folder. aspect ratio must be maintained
					$newThumbnail = convertToThumbnail(dirname (dirname(__FILE__) ). '/uploads/'. $_FILES['userfile']['name'], $_FILES['userfile']['name']);
					$newThumbnail = convertToLargeImage(dirname (dirname(__FILE__) ). '/uploads/'. $_FILES['userfile']['name'], $_FILES['userfile']['name']);
					$thumbnail_Url = 'https://titan.dcs.bbk.ac.uk/~jlee49/w1fma/thumbnails/' . $_FILES['userfile']['name'];
					$img_Url = 'https://titan.dcs.bbk.ac.uk/~jlee49/w1fma/images/' . $_FILES['userfile']['name'];
					$fileName = $_FILES['userfile']['name'];
					$largeImgData = getimagesize(dirname (dirname(__FILE__) ). '/images/'. $_FILES['userfile']['name']);
					$width = $largeImgData[0];
					$height = $largeImgData[1];
					storeDetails($link, $fileName, $thumbnail_Url, $img_Title, $img_Url, $description, $width, $height);
				} else {
					echo 'Image not uploaded successfully. Please try again';
				}
			}
		}
		else{
			$error = $_FILES['userfile']['error'];
			if ($error == UPLOAD_ERR_INI_SIZE) {
				echo 'File upload failed - size exceeded';
			} else if ($error == UPLOAD_ERR_FORM_SIZE) {
				echo 'File upload failed - form size exceeded';
			} else if ($error == UPLOAD_ERR_PARTIAL) {
				echo 'File upload failed - partial exceeded';
			} else if ($error == UPLOAD_ERR_NO_FILE) {
				echo 'File upload failed - no file supplied';
			} else {
				echo 'File upload failed - error code ' . $error;
			}
		}
	}
	$pageContent .= "
	    <h2>Select an image:</h2>

		<form enctype='multipart/form-data' action= ". htmlentities($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8') . " method='post'>
			<div>
				<label for='fileinput'>Upload an image:</label>
				<input name='userfile' type='file' id='fileinput' />
				<p>Only JPEG images are accepted</p>
			</div>
			<div>
				<label for='title'>Title</label>
				<input name='imgTitle' type='text' id='imgTitle' value='" . $title ."'/>
			</div>
			<div>
				<label for='description'>Description</label>
				<input name='imgDescription' type='text' id='imgDescription' value='" . $description . "'/>
			</div>
			<div>
				<input type='submit' value='Upload File' name='imgUpload'/>
			</div>
		</form>";
?>
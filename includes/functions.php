<?php
//Function to check title and description fields
function checkField($field){
	if($field == ''){
		return false;
	}
	else{
		return true;
	}
}

//Function convert the uploaded image into thumbnail size
function convertToThumbnail($imgpath, $imgname){
	$details = getimagesize($imgpath);
	if ($details !== false){
		$src = imagecreatefromjpeg($imgpath);
		$width = $details[0];
		$height = $details[1];
		if ($height >= $width){
			$ratio = $height/$width;
			$new_width = 150/$ratio;
			$new_height = $new_width * $ratio;
			$new = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($new, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($new, 'thumbnails/'. $imgname, 90);
			imagedestroy($src);
			imagedestroy($new);
		}
		if ($height < $width){
			$ratio = $width/$height;
			$new_height = 150 / $ratio;
			$new_width = $new_height * $ratio;
			$new = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($new, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($new, 'thumbnails/'. $imgname, 90);
			imagedestroy($src);
			imagedestroy($new);
		}
	}
	else{
		return false;
	}
}

//Function to convert uploaded image into the large image
function convertToLargeImage($imgpath, $imgname){
	$details = getimagesize($imgpath);
	if ($details !== false){
		$src = imagecreatefromjpeg($imgpath);
		$width = $details[0];
		$height = $details[1];
		if ($height >= $width){
			$ratio = $height/$width;
			$new_width = 600 / $ratio;
			$new_height = $new_width * $ratio;
			$new = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($new, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($new, 'images/'. $imgname, 90);
			imagedestroy($src);
			imagedestroy($new);
		}
		if ($height < $width){
			$ratio = $width/$height;
			$new_height = 600 / $ratio;
			$new_width = $new_height * $ratio;
			$new = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($new, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($new, 'images/'. $imgname, 90);
			imagedestroy($src);
			imagedestroy($new);
		}
	}
	else{
		return false;
	}
}

//Function for storing the uploaded image details in the database
function storeDetails($link, $filename, $thumbUrl, $title, $imgurl, $desc, $largeWidth, $largeHeight){
	$sql = "INSERT INTO images(name, title, img_url, thumb_url, images.desc, large_width, large_height)
			VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = mysqli_prepare($link, $sql);
	mysqli_stmt_bind_param($stmt, "sssssss", $filename, $title, $imgurl, $thumbUrl, $desc, $largeWidth, $largeHeight);
	mysqli_stmt_execute($stmt);
}

//Function to check for JSON error
function checkLastJSONerror() {
	switch (json_last_error()) {
		case JSON_ERROR_NONE:
			return 'No errors';
		
		case JSON_ERROR_DEPTH:
			return 'Maximum stack depth exceeded';
		
		case JSON_ERROR_STATE_MISMATCH:
			return 'Underflow or the modes mismatch';
		
		case JSON_ERROR_CTRL_CHAR:
			return 'Unexpected control character found';
		
		case JSON_ERROR_SYNTAX:
			return 'Syntax error, malformed JSON';
		
		case JSON_ERROR_UTF8:
			return 'Malformed UTF-8 characters, possibly incorrectly encoded';
		
		default:
			return 'Unknown error';
		
	}
}

//Function for getting the number of images by returning the number of unique IDs in the database
function getNumberOfImages($link){
	$sql = "SELECT COUNT(id) 
			FROM images";
	$result = mysqli_query($link, $sql);
	if ($result === false) {
		return mysqli_error($link);
	} 
	else{
		return mysqli_fetch_assoc($result);
	}
}

function getDetails($link){
	$sql = "SELECT * 
			FROM images";
	$result = mysqli_query($link, $sql);
	return $result;
}

function getJSONDetails($link){
	$sql = "SELECT id, title, images.desc, name, large_width, large_height
			FROM  images";
	$result = mysqli_query($link, $sql);
	return $result;
}
?>
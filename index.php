<html>
<body bgcolor=dimgrey>
<center>
<?php
//CACHED VERSION
$qkme = $_SERVER['QUERY_STRING'];
	//Grab the image url from the query string
$imgWidth = '50%';
	//Sets the global width of images
$imgBorder = '2';
	//Sets the global image border size
if(preg_match('/^a\/([a-z0-9]{5,7})/i', $qkme)) {
	//Check if url is that of an albumn
	$albumn = file_get_contents("http://qkme.me/".$qkme);
		//Download the image albumn html into a variable
	preg_match_all('/http:\/\/i\.qkme\.me\/([a-z0-9]{5,7})\.(png|jpg|gif|jpeg)/i', $albumn, $out, PREG_PATTERN_ORDER);
	$matches = preg_grep('/([a-z0-9]{5,7})\.(png|jpg|gif|jpeg)/i', $out[0]);
		//Find all images in the albumn and store their filenames in an array
		//Set the whole match array to variable
	$matches = array_unique($matches);
	foreach($matches as $value) {
		$fname="./cache/".str_replace("http://i.qkme.me/", "", $value);
			//Set the cached filename
		if(file_exists($fname)){	
			//Check if the file is already cached
			echo "<img width=$imgWidth border=$imgBorder src=\"".$fname."\">" . "<br><br>";
				//Add the cached file to the html
		}
		else {
			$con = stream_context_create(array('http'=>array('timeout'=>15)));
				//Prevent long running timed out downloads, but long enough to get large files
			$image = @file_get_contents('http://i.qkme.me/'.str_replace("http://i.qkme.me/", "", $value),0,$con);
				//Download the image into a variable
			if(!$image) {
				echo "Cannot retrieve qkme file";
					//If the download failed, tell us
				die();
					//And exit
			}
			else {
				file_put_contents($fname, $image);
					//Save the image to cache
				echo "<img width=$imgWidth border=$imgBorder  src=\"".$fname."\">" . "<br><br>";
					//Add the cached file to the html
			}
		}
	}
}
else if(preg_match('/^([a-z0-9]{5,7})\.(png|jpg|gif|jpeg)/i', $qkme)) {
	//Make sure only valid qkme filenames are allowed, 5-7 characters, and png, gif, jpg or jpeg extensions
	$fname="./cache/".$qkme;
		//Set the cached filename
	if(file_exists($fname)) {	
		//Check if the file is already cached
		echo "<img width=$imgWidth border=$imgBorder src=\"".$fname."\">" . "<br>";
			//Add the cached file to the html
	}
	else {
		$con = stream_context_create(array('http'=>array('timeout'=>15)));
			//Prevent long running timed out downloads, but long enough to get large files
		$image = @file_get_contents('http://i.qkme.me/'.$qkme,0,$con);
			//Download the image into a variable
		if(!$image) {
			echo "Cannot retrieve qkme file";
				//If the download failed, tell us
			die();
				//And exit
		}
		else {
			file_put_contents($fname, $image);
				//Save the image to cache
			echo "<img width=$imgWidth border=$imgBorder src=\"".$fname."\">" . "<br>";
				//Add the cached file to the html
		}	
	}	
}
else if(preg_match('/^([a-z0-9]{5,7})/i', $qkme)) {
	//Make sure only valid qkme filenames are allowed, 5-7 characters, and png, gif, jpg or jpeg extensions
	$fname="./cache/".$qkme.".jpg";
		//Set the cached filename
	if(file_exists($fname)) {	
		//Check if the file is already cached
		echo "<img width=$imgWidth border=$imgBorder src=\"".$fname."\">" . "<br>";
			//Add the cached file to the html
	}
	else {
		$con = stream_context_create(array('http'=>array('timeout'=>15)));
			//Prevent long running timed out downloads, but long enough to get large files
		$image = @file_get_contents('http://i.qkme.me/'.$qkme.".jpg",0,$con);
			//Download the image into a variable
		if(!$image) {
			echo "Cannot retrieve qkme file";
				//If the download failed, tell us
			die();
				//And exit
		}
		else {
			file_put_contents($fname, $image);
				//Save the image to cache
			echo "<img width=$imgWidth border=$imgBorder src=\"".$fname."\">" . "<br>";
				//Add the cached file to the html
		}	
	}	
}
else {
	die("Not a valid qkme image");
		//Exit if it's not valid
}
?>
</center>
</body>
</html>

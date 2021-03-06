<?php
	require('header.php');
	
	if(isset($_SESSION["userid"])):

		//pildi üleslaadimine osa
	
	//var_dump($_POST);
	//var_dump($_FILES);
	$thumbPhotoDir ="uploadThumbnail/";
	$originalPhotoDir = "uploadOriginalPhoto/";
	$normalPhotoDir = "uploadNormalPhoto/";
	$error = null;
	$notice = null;
	$imageFileType = null;
	$fileUploadSizeLimit = 1048576;
	$fileNamePrefix = "vr_";
	$fileName = null;
	$maxWidth = 600;
	$maxHeight = 400;
	$thumbSize = 100;
	
	if(isset($_POST["photoSubmit"]) and !empty($_FILES["fileToUpload"]["tmp_name"])){
		
		//kas üldse on pilt?
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false){
			//failitüübi väljaselgitamine ja sobivuse kontroll
			if($check["mime"] == "image/jpeg"){
				$imageFileType = "jpg";
			} elseif ($check["mime"] == "image/png"){
				$imageFileType = "png";
			} else {
				$error = "Ainult jpg ja png pildid on lubatud! "; 
			}
		} else {
			$error = "Valitud fail ei ole pilt! ";
		}
		
		//ega pole liiga suur
		if($_FILES["fileToUpload"]["size"] > $fileUploadSizeLimit){
			$error .= "Valitud fail on liiga suur! ";
		}
		
		//loome oma nime failile
		$timestamp = microtime(1) * 10000;
		$fileName = $fileNamePrefix . $timestamp . "." .$imageFileType;
		
		//$originalTarget = $originalPhotoDir .$_FILES["fileToUpload"]["name"];
		$originalTarget = $originalPhotoDir .$fileName;
		
		//äkki on fail olemas?
		if(file_exists($originalTarget)){
			$error .= "Selline fail on juba olemas!";
		}
		
		//kui vigu pole
		if($error == null){
			
			$photoUp = new Photo($_FILES["fileToUpload"], $imageFileType);
			
			//teen pildi väiksemaks
			/* if($imageFileType == "jpg"){
				$myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
			}
			if($imageFileType == "png"){
				$myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
			} */
			
			//$myNewImage = resizePhoto($myTempImage, $maxWidth, $maxHeight);
			$photoUp->resizePhoto($maxWidth, $maxHeight);
			
			//lisan vesimärgi
			$photoUp->addWatermark("vr_watermark.png", 3, 10);
			
			//$result = saveImgToFile($photoUp->myNewImage, $normalPhotoDir .$fileName, $imageFileType);
			$result = $photoUp->saveImgToFile($normalPhotoDir .$fileName);
			if($result == 1) {
				$notice = "Vähendatud pilt laeti üles! ";
			} else {
				$error = "Vähendatud pildi salvestamisel tekkis viga!";
			}
			
			$photoUp->resizePhoto($thumbSize, $thumbSize);
						
			//lõpetame vähendatud pildiga ja teeme thumbnail'i
			/* imageDestroy($myNewImage);
			$myNewImage = resizePhoto($myTempImage, $thumbSize, $thumbSize); */
			//$result = saveImgToFile($photoUp->myNewImage, $thumbPhotoDir .$fileName, $imageFileType);
			$result = $photoUp->saveImgToFile($thumbPhotoDir .$fileName);
			if($result == 1) {
				$notice = "Pisipilt laeti üles! ";
			} else {
				$error .= " Pisipildi salvestamisel tekkis viga!";
			}
			
			/* imageDestroy($myNewImage);
			imagedestroy($myTempImage); */
			unset($photoUp);
			
			if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $originalTarget)){
				$notice .= "Originaalpilt laeti üles! ";
			} else {
				$error .= " Pildi üleslaadimisel tekkis viga!";
			}
			
			//kui kõik hästi, salvestame info andmebaasi!!!
			if($error == null){
				$result = addPhotoData($_SESSION["userid"], $fileName, $_POST["altText"], $_POST["privacy"]);
				if($result == 1){
					$notice .= "Pildi andmed lisati andmebaasi!";
				} else {
					$error .= " Pildi andmete lisamisel andmebaasi tekkis tehniline tõrge: " .$result;
				}
			}
			
		}//kui vigu pole
	}
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
</head>
<body>
<div class="container">
	<h1>Fotode üleslaadimine</h1>
	<p>See leht on valminud õppetöö raames!</p>
	<p><?php echo $_SESSION["userFirstName"]. " " .$_SESSION["userLastName"] ."."; ?> Logi <a href="?logout=1">välja</a>!</p>
	<p>Tagasi <a href="home.php">avalehele</a>!</p>
	<hr>
	
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
		<div class="custom-file">
			<input type="file" class="custom-file-input" id="customFile" name="fileToUpload">
			<label class="custom-file-label" for="customFile">Vali pildifail!</label>
		</div>
		<div class="form-group">
			<label for="alttext">Alt tekst</label>
			<input type="text" class="form-control" id="alttext" name="altText" placeholder="Sisesta alt text">
		</div>
		<label>Privaatsus</label><br>
		<div class="form-check">
			<input class="form-check-input" type="checkbox" id="priv1" name="privacy" value="3" checked>
			<label class="form-check-label" for="priv1">
				Privaatne
			</label>
		</div>
		<div class="form-check">
			<input class="form-check-input" type="checkbox" id="priv2" name="privacy" value="2">
			<label class="form-check-label" for="priv2">
				Sisseloginud kasutajatele
			</label>
		</div>
		<div class="form-check">
			<input class="form-check-input" type="checkbox" id="priv3" name="privacy" value="1">
			<label class="form-check-label" for="priv3">
				Avalik
			</label>
		</div>
		<div class="form-group">
			<input type="submit" name="photoSubmit" class="btn btn-primary" value="Lae valitud pilt üles!">
		</div>
		<span><?php echo $error; echo $notice; ?></span>
	</form>
	
	<br>
	<hr>
</div>
<?php else:?>
	<div class="container">
		<h2>Lehe nägemiseks peate sisse olema logitud!</h2>
	</div>
<?php endif;?>
</body>
</html>
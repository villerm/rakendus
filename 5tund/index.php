<?php
	require('header.php');
	$publicThumbnails =  readAllSemiPublicPictureThumbs();
	if(isset($_SESSION["userid"])):
	$privateThumbnails = readAllMyPictureThumbs();
	$valmis = new valmis;
?>
<div class="container">
	<h1>Minu oma pildid</h1>
	<p>Tagasi <a href="../">avalehele</a>!</p>
	<hr>
    <div>
		<?php echo $privateThumbnails; ?>
	</div>
	<hr>
	<h1>Avalikud pildid</h1>
	<?php 
$page = 1; 
$limit = 5;
$picCount = countPics(2);

if(!isset($_GET["page"]) or $_GET["page"] < 1){
  $page = 1;
} elseif(round($_GET["page"] - 1) * $limit >= $picCount){
  $page = ceil($picCount / $limit);
}	else {
  $page = $_GET["page"];
}

$galleryHTML = readgalleryImages(2, $page, $limit);

?>

<?php 
	if($page > 1){
		echo '<a href="?page=' .($page - 1) .'">Eelmine leht</a> | ';
	} else {
		echo "<span>Eelmine leht</span> | ";
	}
	if($page *$limit <= $picCount){
		echo '<a href="?page=' .($page + 1) .'">Järgmine leht</a>';
	} else {
		echo "<span> Järgmine leht</span>";
	}
?>
	<div class="row">
	<?php
		echo $galleryHTML;
	?>
	</div>
</div>
<?php else:?>
	<div class="container">
	<h1>Avalikud pildid</h1>
	<div class="row">
		<?php echo $publicThumbnails; ?>
	</div>
</div>
<?php endif;?>
</body>
</html>


<?php
	require('header.php');
	$publicThumbnails =  readAllSemiPublicPictureThumbs();
	if(isset($_SESSION["userid"])):
	$privateThumbnails = readAllMyPictureThumbs();
	$valmis = new valmis;
?>
  <div id="modalArea" class="modalArea">
	<!--Sulgemisnupp-->
	<span id="modalClose" class="modalClose">&times;</span>
	<!--pildikoht-->
	<div class="modalHorizontal">
		<div class="modalVertical">
		<p id="modalCaption">Ilus pilt</p>
			<img src="vr_15900538056338.jpg" id="modalImg" class="modalImg" alt="galeriipilt">
			
		</div>
	</div>
  </div>
<style>
.modalArea {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.9);
	color: white;
	font-family: arial, sans-serif;
	font-size: 1.25em;
}

.modalClose {
    position: absolute;
    top: 15px;
    right: 35px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.modalClose:hover, .modalClose:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

 .modalVertical {
	text-align: center;
}

.modalHorizontal {
	height: 100%;
	display: flex;
	flex-direction: row;
	justify-content: center;
	align-items: center;
	animation-name: zoom;
    animation-duration: 0.6s;
}

.modalRating {
	margin-top: 10px;
}


@keyframes zoom {
    from {transform:scale(0); opacity: 0;} 
    to {transform:scale(1); opacity: 1;}
}
</style>
<div class="container">
	<h1>Minu oma pildid</h1>
	<p>Tagasi <a href="../">avalehele</a>!</p>
	<hr>
    <div id="gallery">
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
	<div class="row" id="gallery">
	<?php
		echo $galleryHTML;
	?>
	</div>
</div>
<?php else:?>
	<div class="container">
	<h1>Avalikud pildid</h1>
	<div class="row" id="gallery">
		<?php echo $publicThumbnails; ?>
	</div>
</div>
<?php endif;?>
</body>
</html>


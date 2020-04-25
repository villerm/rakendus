<?php
	require('header.php');

	if(isset($_SESSION["userid"])):
	$privateThumbnails = readAllMyPictureThumbs();
	$publicThumbnails =  readAllSemiPublicPictureThumbs();
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
	<div>
		<?php echo $publicThumbnails; ?>
	</div>
</div>

</body>
</html>
<?php endif;?>

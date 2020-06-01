<?php
require('header.php');

if(isset($_POST["newsSubmit"])){
    if(isset($_POST["newsTitle"]) and !empty(test_input($_POST["newsTitle"]))){
        $newsTitle = test_input($_POST["newsTitle"]);
    } else {
        $newsError = "Uudise pealkiri on sisestamata! ";
    }
    if(isset($_POST["newsContent"]) and !empty(test_input($_POST["newsContent"]))){
        $newsContent = test_input($_POST["newsContent"]);
    } else {
        $newsError .= "Uudise sisu on kirjutamata!";
    }
    //echo $newsTitle ."\n";
    //echo $newsContent;
    //saadame andmebaasi
    if(empty($newsError)){
        //echo "Salvestame!";
        $response = saveNews($_SESSION["userid"], $newsTitle, $newsContent);
        if($response == 1){
            $newsError = "Uudis on salvestatud!";
        } else {
            $newsError = "Uudise salvestamisel tekkis tõrge!";
        }
    }
}
?>
<body>
    <?php if(isset($_SESSION["userid"])):?>
    <div class="container">
        <h1>Uudise lisamine</h1>
        <p>See leht on valminud õppetöö raames!</p>
        <a href='news.php'>Uudised</a>
    </div>
    <div class="container">
        <form class="newsForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="newsTitle">Pealkiri</label>
                <input type="text" class="form-control" name="newsTitle" placeholder="Sisesta pealkiri" value="<?php if(isset($newsTitle)){echo $newsTitle; };?>">
            </div>
            <div class="form-group">
                <label for="newsContent">Sisu</label>
                <textarea class="form-control" id="newsContent" name="newsContent" rows="5" placeholder="Sisesta uudis"><?php if(isset($newsContent)){echo $newsContent;}; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="newsSubmit">Salvesta</button>
            <?php if (isset($newsError)) {
                    $alertType = 'danger';
                    if($newsError == 'Uudis on salvestatud!'){
                        $alertType = 'success';
                    }
                        echo '<div class="alert alert-'.$alertType.'" role="alert">'.$newsError.'</div>';
                    }; ?>
        </form>
    </div>
    <?php endif;?>
        <div class="container">
            <a href='activity.php'>Logid</a>
            <h1>Uudised</h1>
            <h5>Uudiste lisamiseks pead sisse logima!</h5>
            <div class="row">
                <?php echo readnews(6);?>
            </div>
        </div>
    
</body>

</html>
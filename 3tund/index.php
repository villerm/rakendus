<?php
require('header.php');
?>

<body>
    <div class="container">
        <h1>Uudise lisamine</h1>
        <p>See leht on valminud õppetöö raames!</p>
        <a href='news.php'>Uudised</a>
        <a href='activity.php'>Logid</a>
        <a href='newuser.php'>Registreeri konto</a>
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

</body>

</html>
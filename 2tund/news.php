<?php
require('../../../../config.php');
require('functions.php');
require('header.php');

if (isset($_POST['newsRead'])) :
    if (isset($_POST['newsCount']) && !empty(test_input($_POST['newsCount']))) :
        $newsCount = test_input($_POST['newsCount']);
    else :
        $newsCount = NULL;
    endif;
else:
    $newsCount = NULL;
endif;

?>

<body>
    <div class="container">
        <h1>Uudised</h1>
        <a href='.'>Lisa uudis</a>
        <h5>Mitu uudist soovid kuvada?</h5>
        <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group mx-sm-3">
                <input type="number" class="form-control" id="newsCount" name="newsCount" placeholder="sisesta arv" value="<?php if(isset($newsCount)){echo $newsCount; };?>">
            </div>
            <button type="submit" class="btn btn-primary" name="newsRead">Kuva</button>
        </form>
    </div>
    <div class="container">
        <div class="row">
            <?php echo readnews($newsCount);?>
        </div>
    </div>
</body>

</html>